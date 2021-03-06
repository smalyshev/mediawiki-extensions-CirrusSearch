<?php

namespace CirrusSearch;

use CirrusSearch;
use CirrusSearch\Maintenance\Maintenance;
use JobQueueGroup;
use MediaWiki\Logger\LoggerFactory;
use MediaWiki\MediaWikiServices;
use MWException;
use MWTimestamp;
use Title;
use WikiPage;

/**
 * Force reindexing change to the wiki.
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

$IP = getenv( 'MW_INSTALL_PATH' );
if( $IP === false ) {
	$IP = __DIR__ . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );
require_once( __DIR__ . '/../includes/Maintenance/Maintenance.php' );

class ForceSearchIndex extends Maintenance {
	const SECONDS_BETWEEN_JOB_QUEUE_LENGTH_CHECKS = 3;
	public $fromDate = null;
	public $toDate = null;
	public $toId = null;
	public $indexUpdates;
	public $limit;
	public $queue;
	public $maxJobs;
	public $pauseForJobs;
	public $namespace;
	public $excludeContentTypes;

	/**
	 * @var int number of completed jobs
	 */
	private $completed;

	/**
	 * @var boolean true if the script is run with --ids
	 */
	private $runWithIds;

	/**
	 * @var int[][] chunks of ids to reindex when --ids is used, chunk size
	 * is controlled by mBatchSize
	 */
	private $ids;


	public function __construct() {
		parent::__construct();
		$this->mDescription = "Force indexing some pages.  Setting --from or --to will switch from id based indexing to "
			. "date based indexing which uses less efficient queries and follows redirects.\n\n"
			. "Note: All froms are _exclusive_ and all tos are _inclusive_.\n"
			. "Note 2: Setting fromId and toId use the efficient query so those are ok.\n"
			. "Note 3: Operates on all clusters unless --cluster is provided.\n";
		$this->setBatchSize( 10 );
		$this->addOption( 'from', 'Start date of reindex in YYYY-mm-ddTHH:mm:ssZ (exc.  Defaults to 0 epoch.', false, true );
		$this->addOption( 'to', 'Stop date of reindex in YYYY-mm-ddTHH:mm:ssZ.  Defaults to now.', false, true );
		$this->addOption( 'fromId', 'Start indexing at a specific page_id.  Not useful with --deletes.', false, true );
		$this->addOption( 'toId', 'Stop indexing at a specific page_id.  Not useful with --deletes or --from or --to.', false, true );
		$this->addOption( 'ids', 'List of ids (comma separated) to reindex. Not allowed with deletes/from/to/fromId/toId/limit.', false, true );
		$this->addOption( 'deletes', 'If this is set then just index deletes, not updates or creates.', false );
		$this->addOption( 'limit', 'Maximum number of pages to process before exiting the script. Default to unlimited.', false, true );
		$this->addOption( 'buildChunks', 'Instead of running the script spit out commands that can be farmed out to ' .
			'different processes or machines to rebuild the index.  Works with fromId and toId, not from and to.  ' .
			'If specified as a number then chunks no larger than that size are spat out.  If specified as a number ' .
			'followed by the word "total" without a space between them then that many chunks will be spat out sized to ' .
			'cover the entire wiki.' , false, true );
		$this->addOption( 'queue', 'Rather than perform the indexes in process add them to the job queue.  Ignored for delete.' );
		$this->addOption( 'maxJobs', 'If there are more than this many index jobs in the queue then pause before adding ' .
			'more.  This is only checked every ' . self::SECONDS_BETWEEN_JOB_QUEUE_LENGTH_CHECKS . ' seconds.  Not meaningful ' .
			'without --queue.', false, true );
		$this->addOption( 'pauseForJobs', 'If paused adding jobs then wait for there to be less than this many before ' .
			'starting again.  Defaults to the value specified for --maxJobs.  Not meaningful without --queue.', false, true );
		$this->addOption( 'indexOnSkip', 'When skipping either parsing or links send the document as an index.  ' .
			'This replaces the contents of the index for that entry with the entry built from a skipped process.' .
			'Without this if the entry does not exist then it will be skipped entirely.  Only set this when running ' .
			'the first pass of building the index.  Otherwise, don\'t tempt fate by indexing half complete documents.' );
		$this->addOption( 'forceParse', 'Bypass ParserCache and do a fresh parse of pages from the Content.' );
		$this->addOption( 'skipParse', 'Skip parsing the page.  This is really only good for running the second half ' .
			'of the two phase index build.  If this is specified then the default batch size is actually 50.' );
		$this->addOption( 'skipLinks', 'Skip looking for links to the page (counting and finding redirects).  Use ' .
			'this with --indexOnSkip for the first half of the two phase index build.' );
		$this->addOption( 'namespace', 'Only index pages in this given namespace', false, true );
		$this->addOption( 'excludeContentTypes', 'Exclude pages of the specified content types. These must be a comma separated list of strings such as "wikitext" or "json" matching the CONTENT_MODEL_* constants.', false, true, false );
	}

	public function execute() {
		global $wgCirrusSearchMaintenanceTimeout;

		$this->disablePoolCountersAndLogging();
		$wiki = sprintf( "[%20s]", wfWikiID() );

		// Set the timeout for maintenance actions
		$this->getConnection()->setTimeout( $wgCirrusSearchMaintenanceTimeout );

		// Make sure we've actually got indices to populate
		if ( !$this->simpleCheckIndexes() ) {
			$this->error( "$wiki index(es) do not exist. Did you forget to run updateSearchIndexConfig?", 1 );
		}

		// We need to check ids options early otherwize hasOption may return
		// true even if the user did not set the option on the commandline
		if ( $this->hasOption( 'ids' ) ) {
			if ( $this->getOption( 'deletes' ) || $this->hasOption( 'limit' )
				|| $this->hasOption( 'from' ) || $this->hasOption( 'to' )
				|| $this->hasOption( 'fromId' ) || $this->hasOption( 'toId' )
			) {
				$this->error( '--ids cannot be used with deletes/from/to/fromId/toId/limit', 1 );
			}


			$this->runWithIds = true;
			$ids = array_map( function( $id ) {
					$id = trim( $id );
					if ( !ctype_digit( $id ) ) {
						$this->error( "Invalid id provided in --ids, got '$id', expected a positive integer", 1 );
					}
					return intval( $id );
				},
				explode( ',', $this->getOption( 'ids' ) ) );
			$ids = array_unique( $ids, SORT_REGULAR );
			$this->ids = array_chunk( $ids, $this->mBatchSize );
		}

		if ( !is_null( $this->getOption( 'from' ) ) || !is_null( $this->getOption( 'to' ) ) ) {
			// 0 is falsy so MWTimestamp makes that `now`.  '00' is epoch 0.
			$this->fromDate = new MWTimestamp( $this->getOption( 'from', '00' )  );
			$this->toDate = new MWTimestamp( $this->getOption( 'to', false ) );
		}
		$this->toId = $this->getOption( 'toId' );
		$this->indexUpdates = !$this->getOption( 'deletes', false );
		$this->limit = $this->getOption( 'limit' );
		$buildChunks = $this->getOption( 'buildChunks' );
		if ( $buildChunks !== null ) {
			$this->buildChunks( $buildChunks );
			return;
		}
		$this->queue = $this->getOption( 'queue' );
		$this->maxJobs = $this->getOption( 'maxJobs' ) ? intval( $this->getOption( 'maxJobs' ) ) : null;
		$this->pauseForJobs = $this->getOption( 'pauseForJobs' ) ?
			intval( $this->getOption( 'pauseForJobs' ) ) : $this->maxJobs;
		$updateFlags = 0;
		if ( $this->getOption( 'indexOnSkip' ) ) {
			$updateFlags |= Updater::INDEX_ON_SKIP;
		}
		if ( $this->getOption( 'skipParse' ) ) {
			$updateFlags |= Updater::SKIP_PARSE;
			if ( !$this->getOption( 'batch-size' ) ) {
				$this->setBatchSize( 50 );
			}
		}
		if ( $this->getOption( 'skipLinks' ) ) {
			$updateFlags |= Updater::SKIP_LINKS;
		}

		if ( $this->getOption( 'forceParse' ) ) {
			$updateFlags |= Updater::FORCE_PARSE;
		}
		if ( !$this->getOption( 'batch-size' ) &&
			( $this->getOption( 'queue' ) || $this->getOption( 'deletes' ) )
		) {
			$this->setBatchSize( 100 );
		}

		$this->namespace = $this->hasOption( 'namespace' ) ?
			intval( $this->getOption( 'namespace' ) ) : null;

		$this->excludeContentTypes = array_filter( array_map(
			'trim',
			explode( ',', $this->getOption( 'excludeContentTypes', '' ) )
		) );
		if ( $this->indexUpdates ) {
			if ( $this->queue ) {
				$operationName = 'Queued';
			} else {
				$operationName = 'Indexed';
			}
		} else {
			$operationName = 'Deleted';
		}
		$operationStartTime = microtime( true );
		$lastJobQueueCheckTime = 0;
		$this->completed = 0;
		$rate = 0;

		$minUpdate = $this->fromDate;
		if ( $this->indexUpdates ) {
			$minId = $this->getOption( 'fromId', -1 );
		} else {
			$minNamespace = -100000000;
			$minTitle = '';
		}

		while ( $this->jobsTodo() ) {
			$size = 0;
			if ( $this->indexUpdates ) {
				if ( $this->runWithIds ) {
					$updates = $this->findUpdatesByIds( array_shift( $this->ids ) );
				} else {
					/** @suppress PhanUndeclaredVariable */
					$updates = $this->findUpdates( $minUpdate, $minId, $this->toDate );
				}
				$size = count( $updates );
				// Note that we'll strip invalid updates after checking to the loop break condition
				// because we don't want a batch the contains only invalid updates to cause early
				// termination of the process....
			} else {
				/** @suppress PhanUndeclaredVariable */
				$deletes = $this->findDeletes( $minUpdate, $minNamespace, $minTitle, $this->toDate );
				$size = count( $deletes );
				// @todo: add --ids support with --deletes
				// instead of inspecting the archive table we could maybe create Titles, try
				// to fetch them with LinkBatch then send deletes only on those where
				// $title->exists() === false
			}

			if ( $size == 0 ) {
				break;
			}
			if ( $this->indexUpdates ) {
				/** @suppress PhanUndeclaredVariable */
				$last = $updates[ $size - 1 ];
				// We make sure to set this if we need it but don't bother when we don't because
				// it requires loading the revision.
				if ( isset( $last[ 'update' ] ) ) {
					$minUpdate = $last[ 'update' ];
				}
				$minId = $last[ 'id' ];

				// Strip updates down to just pages
				$pages = array();
				/** @suppress PhanUndeclaredVariable */
				foreach ( $updates as $update ) {
					if ( isset( $update[ 'page' ] ) ) {
						$pages[] = $update[ 'page' ];
					}
				}
				if ( $this->queue ) {
					$now = microtime( true );
					if ( $now - $lastJobQueueCheckTime > self::SECONDS_BETWEEN_JOB_QUEUE_LENGTH_CHECKS ) {
						$lastJobQueueCheckTime = $now;
						$queueSize = $this->getUpdatesInQueue();
						if ( $this->maxJobs !== null && $this->maxJobs < $queueSize )  {
							do {
								$this->output( "$wiki Waiting while job queue shrinks: $this->pauseForJobs > $queueSize\n" );
								usleep( self::SECONDS_BETWEEN_JOB_QUEUE_LENGTH_CHECKS * 1000000 );
								$queueSize = $this->getUpdatesInQueue();
							} while ( $this->pauseForJobs < $queueSize );
						}
					}
					JobQueueGroup::singleton()->push(
						Job\MassIndex::build( $pages, $updateFlags, $this->getOption( 'cluster' ) )
					);
				} else {
					// Update size with the actual number of updated documents.
					$updater = $this->createUpdater();
					$size = $updater->updatePages( $pages, null, null, $updateFlags );
				}
			} else {
				$titlesToDelete = array();
				$idsToDelete = array();
				/** @suppress PhanUndeclaredVariable */
				foreach( $deletes as $delete ) {
					$titlesToDelete[] = $delete[ 'title' ];
					$idsToDelete[] = $delete[ 'page' ];
					$lastDelete = $delete;
				}
				$minUpdate = $lastDelete[ 'timestamp' ];
				$minNamespace = $lastDelete[ 'title' ]->getNamespace();
				$minTitle = $lastDelete[ 'title' ]->getText();
				$updater = $this->createUpdater();
				$updater->deletePages( $titlesToDelete, $idsToDelete );
			}

			$this->completed += $size;
			$rate = $this->calculateIndexingRate( $this->completed, $operationStartTime );

			if ( is_null( $this->toDate ) ) {
				/** @suppress PhanUndeclaredVariable */
				$endingAt = $minId;
			} else {
				$endingAt = $minUpdate->getTimestamp( TS_ISO_8601 );
			}
			$this->output( "$wiki $operationName $size pages ending at $endingAt at $rate/second\n" );
		}
		$this->output( "$operationName a total of {$this->completed} pages at $rate/second\n" );

		$lastQueueSizeForOurJob = PHP_INT_MAX;
		$waitStartTime = microtime( true );
		if ( $this->queue ) {
			$this->output( "Waiting for jobs to drain from the queue\n" );
			while ( true ) {
				$queueSizeForOurJob = $this->getUpdatesInQueue();
				if ( $queueSizeForOurJob === 0 ) {
					break;
				}
				// We subtract 5 because we some jobs may be added by deletes
				if ( $queueSizeForOurJob > $lastQueueSizeForOurJob ) {
					$this->output( "Queue size went up.  Another script is likely adding jobs " .
						"and it'll wait for them to empty.\n" );
					break;
				}
				if ( microtime( true ) - $waitStartTime > 120 ) {
					// Wait at least two full minutes before we check if the job count went down.
					// Less then that and we might be seeing lag from redis's counts.
					$lastQueueSizeForOurJob = $queueSizeForOurJob;
				}
				$this->output( "$wiki $queueSizeForOurJob jobs left on the queue.\n" );
				usleep( self::SECONDS_BETWEEN_JOB_QUEUE_LENGTH_CHECKS * 1000000 );
			}
		}
	}

	private function jobsTodo() {
		if ( $this->runWithIds ) {
			return !empty( $this->ids );
		} else {
			return is_null( $this->limit ) || $this->limit > $this->completed;
		}
	}

	/**
	 * @param int $completed
	 * @param double $operationStartTime
	 *
	 * @return double
	 */
	private function calculateIndexingRate( $completed, $operationStartTime ) {
		$rate = $completed / ( microtime( true ) - $operationStartTime );

		if ( $rate < 1 ) {
			return round( $rate, 1 );
		}

		return round( $rate );
	}

	/**
	 * Do some simple sanity checking to make sure we've got indexes to populate.
	 * Note this isn't nearly as robust as updateSearchIndexConfig is, but it's
	 * not designed to be.
	 *
	 * @return bool
	 */
	private function simpleCheckIndexes() {
		$wiki = wfWikiID();

		// Top-level alias needs to exist
		if ( !$this->getConnection()->getIndex( $wiki )->exists() ) {
			return false;
		}

		// Now check all index types to see if they exist
		foreach ( $this->getConnection()->getAllIndexTypes() as $indexType ) {
			// If the alias for this type doesn't exist, fail
			if ( !$this->getConnection()->getIndex( $wiki, $indexType )->exists() ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Find $this->mBatchSize pages that have updates made after (minUpdate,minId) and before maxUpdate.
	 *
	 * @param $minUpdate string|null Minimum mediawiki timestamp
	 * @param $minId int|null Minimum mediawiki page id
	 * @param string|null $maxUpdate Maximum mediawiki timestamp
	 * @return array An array of the last update timestamp, id, and page that was found.
	 *    Sometimes page is null - those record should be used to determine new
	 *    inputs for this function but should not by synced to the search index.
	 */
	private function findUpdates( $minUpdate, $minId, $maxUpdate ) {
		$dbr = $this->getDB( DB_SLAVE );
		$minId = $dbr->addQuotes( $minId );
		if ( $maxUpdate === null ) {
			$where = array( "$minId < page_id" );
			if ( $this->toId !== null ) {
				$toId = $dbr->addQuotes( $this->toId );
				$where[] = "page_id <= $toId";
			}
			if ( $this->namespace ) {
				$where['page_namespace'] = $this->namespace;
			}
			if ( $this->excludeContentTypes ) {
				$list = $dbr->makeList( $this->excludeContentTypes, LIST_COMMA );
				$where[] = "page_content_model NOT IN ($list)";
			}

			// We'd like to filter out redirects here but it makes the query much slower on larger wikis....
			$res = $dbr->select(
				array( 'page' ),
				WikiPage::selectFields(),
				$where,
				__METHOD__,
				array( 'ORDER BY' => 'page_id',
				       'LIMIT' => $this->mBatchSize )
			);
		} else {
			$minUpdate = $dbr->addQuotes( $dbr->timestamp( $minUpdate ) );
			$maxUpdate = $dbr->addQuotes( $dbr->timestamp( $maxUpdate ) );

			$where = array(
				'page_id = rev_page',
				'rev_id = page_latest',
				"( ( $minUpdate = rev_timestamp AND $minId < page_id ) OR $minUpdate < rev_timestamp )",
				"rev_timestamp <= $maxUpdate"
			);
			if ( $this->namespace ) {
				$where['page_namespace'] = $this->namespace;
			}
			if ( $this->excludeContentTypes ) {
				$list = $dbr->makeList( $this->excludeContentTypes, LIST_COMMA );
				$where[] = "page_content_model NOT IN ($list)";
			}

			$res = $dbr->select(
				array( 'page', 'revision' ),
				array_merge(
					array( 'rev_timestamp' ),
					WikiPage::selectFields()
				),
				$where,
				// Note that redirects are allowed here so we can pick up redirects made during search downtime
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp, rev_page',
				       'LIMIT' => $this->mBatchSize )
			);
		}

		return $this->decodeResults( $res, $maxUpdate );
	}

	/**
	 * Find $this->mBatchSize pages that have updates made after (minUpdate,minId) and before maxUpdate.
	 *
	 * @param $ids int[] list of ids
	 * @return array An array of the last update timestamp, id, and page that was found.
	 *    Sometimes page is null - those record should be used to determine new
	 *    inputs for this function but should not by synced to the search index.
	 */
	private function findUpdatesByIds( array $ids ) {
		$dbr = $this->getDB( DB_SLAVE );
		$where = array();
		$where[] = 'page_id IN (' . $dbr->makeList( $ids ) . ')';
		if ( $this->namespace ) {
			$where['page_namespace'] = $this->namespace;
		}
		if ( $this->excludeContentTypes ) {
			$list = $dbr->makeList( $this->excludeContentTypes, LIST_COMMA );
			$where[] = "page_content_model NOT IN ($list)";
		}

		// We'd like to filter out redirects here but it makes the query much slower on larger wikis....
		$res = $dbr->select(
			array( 'page' ),
			WikiPage::selectFields(),
			$where,
			__METHOD__,
			array( 'ORDER BY' => 'page_id',
			       'LIMIT' => $this->mBatchSize )
		);

		return $this->decodeResults( $res, null );
	}

	/**
	 * @param mixed $res Database result
	 * @param string|null Maximum mediawiki timestamp
	 * @return array[]
	 */
	private function decodeResults( $res, $maxUpdate ) {
		$result = array();
		// Build the updater outside the loop because it stores the redirects it hits.  Don't build it at the top
		// level so those are stored when it is freed.
		$updater = $this->createUpdater();

		foreach ( $res as $row ) {
			// No need to call Updater::traceRedirects here because we know this is a valid page because
			// it is in the database.
			$page = WikiPage::newFromRow( $row, WikiPage::READ_LATEST );

			try {
				$content = $page->getContent();
			} catch ( MWException $ex ) {
				LoggerFactory::getInstance( 'CirrusSearch' )->warning(
					"Error deserializing content, skipping page: {pageId}",
					array( 'pageId' => $row->page_id )
				);
				continue;
			}

			if ( $content === null ) {
				// Skip pages without content.  Pages have no content because their latest revision
				// as loaded by the query above doesn't exist.
				$this->output( "Skipping page with no content: $row->page_id\n" );
				$page = null;
			} else if ( $content->isRedirect() ) {
				if ( $maxUpdate === null ) {
					// Looks like we accidentally picked up a redirect when we were indexing by id and thus trying to
					// ignore redirects!  Just ignore it!  We would filter them out at the db level but that is slow
					// for large wikis.
					$page = null;
				} else {
					// We found a redirect.  Great.  Since we can't index special pages and redirects to special pages
					// are totally possible, as well as fun stuff like redirect loops, we need to use
					// Updater's redirect tracing logic which is very complete.  Also, it returns null on
					// self redirects.  Great!
					list( $page, ) = $updater->traceRedirects( $page->getTitle() );
				}
			}
			$update = array(
				'page' => $page,
				'id' => $row->page_id,
			);
			if ( $maxUpdate !== null ) {
				$update[ 'update' ] = new MWTimestamp( $row->rev_timestamp );
			}
			$result[] = $update;
		}

		return $result;
	}

	/**
	 * Find $this->mBatchSize deletes who were deleted after (minUpdate,minNamespace,minTitle) and before maxUpdate.
	 *
	 * @param string $minUpdate
	 * @param int $minNamespace
	 * @param string $minTitle
	 * @param string $maxUpdate
	 * @return array An array of the last update timestamp and id that were found
	 */
	private function findDeletes( $minUpdate, $minNamespace, $minTitle, $maxUpdate ) {
		$dbr = $this->getDB( DB_SLAVE );
		$minUpdate = $dbr->addQuotes( $dbr->timestamp( $minUpdate ) );
		$minNamespace = $dbr->addQuotes( (string) $minNamespace );
		$minTitle = $dbr->addQuotes( $minTitle );
		$maxUpdate = $dbr->addQuotes( $dbr->timestamp( $maxUpdate ) );
		$where = array(
			"( ( $minUpdate = ar_timestamp AND $minNamespace < ar_namespace AND $minTitle < ar_title )"
				. " OR $minUpdate < ar_timestamp )",
			"ar_timestamp <= $maxUpdate"
		);
		if ( $this->namespace ) {
			$where['ar_namespace'] = $this->namespace;
		}

		$res = $dbr->select(
			'archive',
			array( 'ar_timestamp', 'ar_namespace', 'ar_title', 'ar_page_id' ),
			$where,
			__METHOD__,
			array( 'ORDER BY' => 'ar_timestamp, ar_namespace, ar_title',
			       'LIMIT' => $this->mBatchSize )
		);
		$result = array();
		foreach ( $res as $row ) {
			$result[] = array(
				'timestamp' => new MWTimestamp( $row->ar_timestamp ),
				'title' => Title::makeTitle( $row->ar_namespace, $row->ar_title ),
				'page' => $row->ar_page_id,
			);
		}
		return $result;
	}

	/**
	 * @param string|int $buildChunks If specified as a number then chunks no
	 *  larger than that size are spat out.  If specified as a number followed
	 *  by the word "total" without a space between them then that many chunks
	 *  will be spat out sized to cover the entire wiki.
	 */
	private function buildChunks( $buildChunks ) {
		$dbr = $this->getDB( DB_SLAVE );
		if ( $this->toId === null ) {
			$this->toId = $dbr->selectField( 'page', 'MAX(page_id)' );
			if ( $this->toId === false ) {
				$this->error( "Couldn't find any pages to index.  toId = $this->toId.", 1 );
			}
		}
		$fromId = $this->getOption( 'fromId' );
		if ( $fromId === null ) {
			$fromId = $dbr->selectField( 'page', 'MIN(page_id) - 1' );
			if ( $fromId === false ) {
				$this->error( "Couldn't find any pages to index.  fromId = $fromId.", 1 );
			}
		}
		if ( $fromId === $this->toId ) {
			$this->error( "Couldn't find any pages to index.  fromId = $fromId = $this->toId = toId.", 1 );
		}
		$builder = new \CirrusSearch\Maintenance\ChunkBuilder();
		$builder->build( $this->mSelf, $this->mOptions, $buildChunks, $fromId, $this->toId );
	}

	/**
	 * Get the number of cirrusSearchMassIndex jobs in the queue.
	 * @return int length
	 */
	private function getUpdatesInQueue() {
		return JobQueueGroup::singleton()->get( 'cirrusSearchMassIndex' )->getSize();
	}

	/**
	 * @return Updater
	 */
	private function createUpdater() {
		$flags = array();
		if ( $this->hasOption( 'cluster' ) ) {
			$flags[] = 'same-cluster';
		}
		return new Updater( $this->getConnection(), $flags );
	}
}

$maintClass = ForceSearchIndex::class;
require_once RUN_MAINTENANCE_IF_MAIN;
