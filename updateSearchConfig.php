<?php
/**
 * Update the search configuration on the search backend.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */
require_once( "maintenance/Maintenance.php" );

/**
 * Update the elasticsearch configuration for this index.
 */
class UpdateElasticsearchIndex extends Maintenance {
	private $rebuild, $closeOk;

	// Is the index currently closed?
	private $closed = false;

	private $reindexChunkSize = 1000;

	private $indexIdentifier;
	private $reindexAndRemoveOk;
	private $returnCode = 0;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update the elasticsearch index for this wiki";
		$this->addOption( 'rebuild', 'Blow away the identified index and rebuild it from scratch.' );
		$this->addOption( 'forceOpen', "Open the index but do nothing else.  Use this if " .
			"you've stuck the index closed and need it to start working right now." );
		$this->addOption( 'closeOk', "Allow the script to close the index if decides it has " .
			"to.  Note that it is never ok to close an index that you just created. Also note " .
			"that changing analysers might require a reindex for them to take effect so you might " .
			"be better off using --reindexAndRemoveOk and a new --indexIdentifier to rebuild the " .
			"entire index. Defaults to false." );
		$this->addOption( 'forceReindex', "Perform a reindex right now." );
		$this->addOption( 'indexIdentifier', "Set the identifier of the index to work on.  " .
			"You'll need this if you have an index in production serving queries and you have " .
			"to alter some portion of its configuration that cannot safely be done without " .
			"rebuilding it.  Once you specify a new indexIdentify for this wiki you'll have to " .
			"run this script with the same identifier each time.  Defaults to 'red'.", false, true);
		$this->addOption( 'reindexAndRemoveOk', "If the alias is held by another index then " .
			"reindex all documents from that index (via the alias) to this one, swing the " .
			"alias to this index, and then remove other index.  You'll have to redo all updates ".
			"performed during this operation manually.  Defaults to false.");
	}

	public function execute() {
		if ( $this->getOption( 'forceOpen', false) ) {
			$this->getIndex()->open();
			return;
		}
		if ( $this->getOption( 'forceReindex', false) ) {
			$this->reindex();
			return;
		}
		$this->rebuild = $this->getOption( 'rebuild', false );
		$this->closeOk = $this->getOption( 'closeOk', false );
		$this->indexIdentifier = $this->getOption( 'indexIdentifier', 'red' );
		$this->reindexAndRemoveOk = $this->getOption( 'reindexAndRemoveOk', false );

		$this->validateIndex();
		$this->validateAnalyzers();
		$this->validateMapping();
		$this->validateAlias();

		if ($this->closed) {
			$this->getIndex()->open();
		}
		if ( $this->returnCode ) {
			die( $this->returnCode );
		}
	}

	private function validateIndex() {
		if ( $this->rebuild ) {
			$this->output( "Rebuilding index..." );
			$this->createIndex( true );
			$this->output( "ok\n" );
			return;
		}
		if ( !$this->getIndex()->exists() ) {
			$this->output( "Creating index..." );
			$this->createIndex( false );
			$this->output( "ok\n" );
			return;
		}
		$this->output( "Index exists so validating...\n" );
		global $wgCirrusSearchShardCount, $wgCirrusSearchReplicaCount;
		$settings = $this->getIndex()->getSettings()->get();

		$this->output( "\tValidating number of shards..." );
		$actualShardCount = $settings['index.number_of_shards'];
		if ( $actualShardCount == $wgCirrusSearchShardCount ) {
			$this->output( "ok\n" );
		} else {
			$this->output( "is $actualShardCount but should be $wgCirrusSearchShardCount...cannot correct!\n" );
			$this->error(
				"Number of shards is incorrect and cannot be changed without a rebuild. You can solve this\n" .
				"problem by running this program again with either --rebuild or --reindexAndRemoveOk.  Make\n" .
				"sure you understand the consequences of either choice..  This script will now continue to\n" .
				"validate everything else." );
			$this->returnCode = 1;
		}

		$this->output( "\tValidating number of replicas..." );
		$actualReplicaCount = $settings['index.number_of_replicas'];
		if ( $actualReplicaCount == $wgCirrusSearchReplicaCount ) {
			$this->output( "ok\n" );
		} else {
			$this->output( "is $actualReplicaCount but should be $wgCirrusSearchReplicaCount..." );
			$this->getIndex()->getSettings()->setNumberOfReplicas( $wgCirrusSearchReplicaCount );
			$this->output( "corrected\n" );
		}
	}

	private function validateAnalyzers() {
		function vaActualMatchRequired( $prefix, $settings, $required ) {
			foreach( $required as $key => $value ) {
				$settingsKey = $prefix . '.' . $key;
				if ( is_array( $value ) ) {
					if ( !vaActualMatchRequired( $settingsKey, $settings, $value ) ) {
						return false;
					}
					continue;
				}
				// Note that I really mean !=, not !==.  Coercion is cool here.
				if ( !array_key_exists( $settingsKey, $settings ) || $settings[ $settingsKey ] != $value ) {
					return false;
				}
			}
			return true;
		}

		$this->output( "Validating analyzers..." );
		$settings = $this->getIndex()->getSettings()->get();
		$requiredAnalyzers = $this->buildAnalyzers();
		if ( vaActualMatchRequired( 'index', $settings, $requiredAnalyzers ) ) {
			$this->output( "ok\n" );
		} else {
			$this->output( "different..." );
			$this->closeAndCorrect( function() use ($requiredAnalyzers) {
				$this->getIndex()->getSettings()->set( $requiredAnalyzers );
			} );
		}
	}

	private function validateMapping() {
		function vmActualMatchRequired( $actual, $required ) {
			foreach( $required as $key => $value ) {
				if ( !array_key_exists( $key, $actual ) ) {
					return false;
				}
				if ( is_array( $value ) ) {
					if ( !is_array( $actual[ $key ] ) ) {
						return false;
					}
					if ( !vmActualMatchRequired( $actual[ $key ], $value ) ) {
						return false;
					}
					continue;
				}
				// Note that I really mean !=, not !==.  Coercion is cool here.
				if ( $actual[ $key ] != $value ) {
					return false;
				}
			}
			return true;
		}

		$this->output( "Validating mappings...\n" );
		$actualMappings = $this->getIndex()->getMapping();
		$actualMappings = $actualMappings[ $this->getIndex()->getName() ];

		$this->output( "\tValidating mapping for page type..." );
		$requiredPageMappings = $this->buildPageMappings();
		if ( array_key_exists( 'page', $actualMappings) && 
				vmActualMatchRequired( $actualMappings[ 'page' ][ 'properties' ], $requiredPageMappings ) ) {
			$this->output( "ok\n" );
		} else {
			$this->output( "different..." );
			// TODO Conflict resolution here might leave old portions of mappings
			$action = new \Elastica\Type\Mapping( $this->getPageType(), $requiredPageMappings );
			try {
				$action->send();
				$this->output( "corrected\n" );
			} catch ( \Elastica\Exception\ExceptionInterface $e ) {
				$this->output( "failed!\n" );
				$message = $e->getMessage();
				$this->error( "Couldn't update mappings.  Here is elasticsearch's error message: $message\n" );
				$this->returnCode = 1;
			}
		}
	}

	private function validateAlias() {
		$this->output( "Validating aliases..." );
		$otherIndeciesWithAlias = array();
		$status = CirrusSearch::getClient()->getStatus();
		foreach ( $status->getIndicesWithAlias( CirrusSearch::getIndexName() ) as $index ) {
			if( $index->getName() === CirrusSearch::getIndexName( $this->indexIdentifier ) ) {
				$this->output( "ok\n" );
				return;
			} else {
				$otherIndeciesWithAlias[] = $index->getName();
			}
		}
		if ( !$otherIndeciesWithAlias ) {
			$this->output( "alias is free..." );
			$this->getIndex()->addAlias( CirrusSearch::getIndexName(), false );
			$this->output( "corrected\n" );
			return;
		}
		if ( $this->reindexAndRemoveOk ) {
			$this->output( "is taken...\n" );
			$this->output( "\tReindexing...\n");
			$this->reindex();
			$this->output( "\tSwapping alias...");
			$this->getIndex()->addAlias( CirrusSearch::getIndexName(), true );
			$this->output( "done\n" );
			$this->output( "\tRemoving old index..." );
			foreach ( $otherIndeciesWithAlias as $otherIndex ) {
				CirrusSearch::getClient()->getIndex( $otherIndex )->delete();
			}
			$this->output( "done\n" );
			return;
		}
		$this->output( "cannot correct!\n" );
		$this->error(
			"The alias is held by another index which means it might be actively serving\n" .
			"queries.  You can solve this problem by running this program again with\n" .
			"--reindexAndRemoveOk.  Make sure you understand the consequences of either\n" .
			"choice." );
		$this->returnCode = 1;
	}

	/**
	 * Rebuild the index by pulling everything out of it and putting it back in.  This should be faster than
	 * reparsing everything.
	 */
	private function reindex() {
		global $wgCirrusSearchShardCount;

		$query = new Elastica\Query();
		$query->setFields( array( '_id', '_source' ) );

		// Note here we dump from the current index (using the alias) so we can use CirrusSearch::getPageType
		$result = CirrusSearch::getPageType()->search( $query, array(
			'search_type' => 'scan',
			'scroll' => '10m',
			'size'=> $this->reindexChunkSize / $wgCirrusSearchShardCount
		) );
		$totalDocsToReindex = $result->getResponse()->getData();
		$totalDocsToReindex = $totalDocsToReindex['hits']['total'];
		$this->output( "\t\tAbout to reindex $totalDocsToReindex documents\n" );

		while ( true ) {
			wfProfileIn( __method__ . '::receiveDocs' );
			$result = $this->getIndex()->search( array(), array(
				'scroll_id' => $result->getResponse()->getScrollId(),
				'scroll' => '10m'
			) );
			wfProfileOut( __method__ . '::receiveDocs' );
			if ( !$result->count() ) {
				$this->output( "\t\tAll done\n" );
				break;
			}
			$this->output( "\t\tSending " . $result->count() . " documents to be reindexed\n" );
			wfProfileIn( __method__ . '::packageDocs' );
			$documents = array();
			while ( $result->current() ) {
				$documents[] = new \Elastica\Document( $result->current()->getId(), $result->current()->getSource() );
				$result->next();
			}
			wfProfileOut( __method__ . '::packageDocs' );
			wfProfileIn( __method__ . '::sendDocs' );
			$updateResult = $this->getPageType()->addDocuments( $documents );
			wfDebugLog( 'CirrusSearch', 'Update completed in ' . $updateResult->getEngineTime() . ' (engine) millis' );
			wfProfileOut( __method__ . '::sendDocs' );
		}
	}

	private function createIndex( $rebuild ) {
		global $wgCirrusSearchShardCount, $wgCirrusSearchReplicaCount;
		$this->getIndex()->create( array(
			'settings' => array_merge( $this->buildAnalyzers(), array(
				'number_of_shards' => $wgCirrusSearchShardCount,
				'number_of_replicas' => $wgCirrusSearchReplicaCount
			) )
		), $rebuild );
		$this->closeOk = false;
	}

	private function buildAnalyzers() {
		return array(
			'analysis' => array(
				'analyzer' => array(
					'text' => $this->buildTextAnalyzer(),
					'suggest' => array_merge( $this->buildTextAnalyzer(), array(
						'filter' => array( 'suggest_shingle' )
					) )
				),
				'filter' => array(
					'suggest_shingle' => array(
						'type' => 'shingle',
						'min_shingle_size' => 2,
						'max_shingle_size' => 5
					)
				)
			)
		);
	}

	private function buildTextAnalyzer() {
		global $wgLanguageCode;
		switch ($wgLanguageCode) {
			case 'en': return array(
				'type' => 'english'
			);
		}
	}

	private function buildPageMappings() {
		// Note never to set something as type='object' here because that isn't returned by elasticsearch
		// and is infered anyway.
		return array(
			'title' => $this->buildFieldWithSuggest( 'title' ),
			'text' => $this->buildFieldWithSuggest( 'text' ),
			'category' => array( 'type' => 'string', 'analyzer' => 'text' ),
			'redirect' => array(
				'properties' => array(
					'title' => array( 'type' => 'string', 'analyzer' => 'text' )
				)
			)
		);
	}

	private function buildFieldWithSuggest( $name ) {
		return array(
			'type' => 'multi_field',
			'fields' => array(
				$name => array( 'type' => 'string', 'analyzer' => 'text' ),
				'suggest' => array( 'type' => 'string', 'analyzer' => 'suggest' )
			)
		);
	}

	private function closeAndCorrect( $callback ) {
		if ( $this->closeOk ) {
			$this->getIndex()->close();
			$this->closed = true;
			$callback();
			$this->output( "corrected\n" );
		} else {
			$this->output( "cannot correct\n" );
			$this->error("This script encountered an index difference that requires that the index be\n" .
				"closed, modified, and then reopened.  To allow this script to close the index run it\n" .
				"with the --closeOk parameter and it'll close the index for the briefest possible time\n" .
				"Note that the index will be unusable while closed." );
			$this->returnCode = 1;
		}
	}

	/**
	 * Get the index being updated by the search config.
	 */
	private function getIndex() {
		return CirrusSearch::getIndex( $this->indexIdentifier );
	}

	/**
	 * Get the type being updated by the search config.
	 */
	private function getPageType() {
		return $this->getIndex()->getType( CirrusSearch::PAGE_TYPE_NAME );
	}
}

$maintClass = "UpdateElasticsearchIndex";
require_once RUN_MAINTENANCE_IF_MAIN;