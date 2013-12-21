<?php

/**
 * Messages for CirrusSearch extension
 */

$messages = array();

/**
 * English
 */
$messages['en'] = array(
	'cirrussearch-desc' => 'Elasticsearch-powered search for MediaWiki',
	'cirrussearch-backend-error' => 'We could not complete your search due to a temporary problem. Please try again later.',
	'cirrussearch-now-using' => 'This wiki is using a new search engine. ([[mw:Special:MyLanguage/Help:CirrusSearch|Learn more]])',
	'cirrussearch-ignored-headings' => ' #<!-- leave this line exactly as it is --> <pre>
# Headings that will be ignored by search.
# Changes to this take effect as soon as the page with the heading is indexed.
# You can force page reindexing by doing a null edit.
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is the exact title to ignore, case and everything
References
External links
See also
 #</pre> <!-- leave this line exactly as it is -->',
	'cirrussearch-pref-label' => 'New search',
	'cirrussearch-pref-desc' => 'Try our new search which supports a greater number of languages, provides more up-to-date results, and can even find text inside of templates.',
);

/** Message documentation (Message documentation)
 * @author Kunal Mehta
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'cirrussearch-desc' => '{{desc|name=Cirrus Search|url=http://www.mediawiki.org/wiki/Extension:CirrusSearch}}
"Elasticsearch" is a full-text search engine. See http://www.elasticsearch.org/',
	'cirrussearch-backend-error' => 'Error message shown to the users when we have an issue communicating with our search backend',
	'cirrussearch-now-using' => "Note that this wiki is using a new search engine with a link for people to learn more.  That'll contain information on filing a bug, new syntax, etc.",
	'cirrussearch-ignored-headings' => 'Headings that will be ignored by search. You can translate the text, including "Leave this line exactly as it is". Some lines of this messages have one (1) leading space.',
	'cirrussearch-pref-label' => 'Preference label for option to enable CirrusSearch by default',
	'cirrussearch-pref-desc' => 'Description for option to enable CirrusSearch by default',
);

/** Arabic (العربية)
 * @author Asaifm
 */
$messages['ar'] = array(
	'cirrussearch-desc' => 'عملية البحث مدعومة من قبل Elasticsearch لميدياويكي',
	'cirrussearch-backend-error' => 'لم نستطع إكمال بحثك بسبب مشكلة مؤقتة. الرجاء المحاولة لاحقاً.',
	'cirrussearch-now-using' => 'تستخدم الويكي محرك بحث جديد. ([[mw:Special:MyLanguage/Help:CirrusSearch|إضغط هنا للمزيد من المعلومات]])',
	'cirrussearch-ignored-headings' => ' # <!-- أترك هذا السطر كما هو --> <pre>
# سيتم تجاهل الترويسات خلال عملية البحث
#ا لتغييرات ستأخذ مجراها ما أن يتم فهرسة الصفحة التي تحتوي على ترويسات
# يمكنك فرض عملية فهرسة الصفحة من خلال تعديل فارغ
# الصيغة هي كالأتي:
# * كل ما يكتب بعد "#" إلى آخر السطر يعتبر تعليق
# * كل سطر غير فارغ سيكون العنوان الذي سيتم تجاهله (سيأخذ العنوان كما هو بالضبط بالتشكيل وخلافه)
المراجع
الوصلات الخارجية
أنظر أيضا
#</pre><!--أترك هذا السطر كما هو -->',
	'cirrussearch-pref-label' => 'بحث جديد',
	'cirrussearch-pref-desc' => 'جرب طريقة البحث الجديدة التي تدعم عدد أكبر من اللغات وتوفر نتائج أفضل من ناحية التحديثات. كما يمكنها أيضا البحث لك عن نصوص داخل قوالب.',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'cirrussearch-desc' => 'Gueta col motor Elasticsearch pa MediaWiki',
	'cirrussearch-backend-error' => 'Nun pudimos completar la gueta por un problema temporal. Por favor, vuelva a intentalo más sero.',
	'cirrussearch-now-using' => 'Esta wiki ta usando un motor de gueta nuevu. ([[mw:Special:MyLanguage/Help:CirrusSearch|Ver más]])',
	'cirrussearch-ignored-headings' => " #<!-- dexar esta llinia exactamente como ta --> <pre>
# Testeres que nun se tendrán en cuenta na gueta.
# Los cambios fechos equí son efeutivos nel momentu que s'indexa la páxina cola testera.
# Pue forzar el reindexáu d'una páxina faciendo una edición nula.
# La sintaxis ye la siguiente:
#   * Tolo qu'hai dende un caráuter \"#\" al fin de llinia ye un comentariu
#   * Cada llinia non-balera ye'l títulu exactu a descartar, incluyendo mayúscules y demás
Referencies
Enllaces esternos
Ver tamién
 #</pre> <!-- dexar esta llinia exactamente como ta -->",
	'cirrussearch-pref-label' => 'Gueta nueva',
	'cirrussearch-pref-desc' => 'Usar un motor de gueta nuevu que fai índices de plantíes espandíes, tien sofitu pa más llingües y anueva más rápido.',
);

/** Bikol Central (Bikol Central)
 * @author Geopoet
 */
$messages['bcl'] = array(
	'cirrussearch-desc' => 'Elastikongpaghanap-makusugon na panhanap para sa MediaWiki',
	'cirrussearch-backend-error' => 'Dae nyamo makukumpleto an saimong paghahanap nin huli sa sarong temporaryong problema.
Tabi man paki-otroha giraray oro-atyan.',
	'cirrussearch-ignored-headings' => ' #<!-- walaton ining linya eksaktong siring sana kaini --> <pre> 
# Mga Kapamayuhanan na pinagpapabayaan sa paghahanap. 
# Mga Kaliwatan kaini magkaka-epekto matapos na an pahina na igwang kapamayuhanan maipaghukdo. 
# Ika makakapagpuwersa sa pahina na maihuhukdo otro sa paagi nin paghimo nin sarong blangko na pagliwat. # An Sintaks iyo ining minasunod: 
# * An gabos magpoon sa sarong karakter na "#" sagkod sa tapos kan linya iyo an sarong komento 
# * An lambang linya na bakong blangko iyo an eksaktong titulo na pababayaan, kaso asin gabos na bagay 
Mga Panultulan
Panluwas na mga sugpon
Hilingon man 
#</pre> <!-- walaton ining linya eksaktong siring sana kaini -->',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'cirrussearch-desc' => 'Пошук у MediaWiki з дапамогай ElasticSearch',
	'cirrussearch-backend-error' => 'Мы не змаглі выканаць пошукавы запыт з-за часовых праблемаў. Паспрабуйце пазьней, калі ласка.',
	'cirrussearch-ignored-headings' => ' #<!-- не зьмяняйце гэты радок --> <pre>
# Загалоўкі, якія мусіць ігнараваць пошукавы рухавік.
# Зьмены будуць ужытыя па наступным індэксаваньні старонкі.
# Вы можаце змусіць пераіндэксаваць старонку пустым рэдагаваньнем.
# Сынтакс наступны:
#   * Усё, што пачынаецца з "#" — камэнтар
#   * Усякі непусты радок — загаловак, які трэба ігнараваць
Крыніцы
Вонкавыя спасылкі
Глядзіце таксама
 #</pre> <!-- не зьмяняйце гэты радок -->',
);

/** Breton (brezhoneg)
 * @author Fohanno
 */
$messages['br'] = array(
	'cirrussearch-backend-error' => "N'hon eus ket gallet kas hoc'h enklask da benn abalamour d'ur gudenn dibad. Esaeit en-dro diwezhatoc'h, mar plij.",
	'cirrussearch-pref-label' => 'Enklask nevez',
);

/** Catalan (català)
 * @author Fitoschido
 * @author QuimGil
 * @author Vriullop
 */
$messages['ca'] = array(
	'cirrussearch-desc' => 'Cerca realitzada amb Elasticsearch per a MediaWiki',
	'cirrussearch-backend-error' => 'La seva cerca no ha pogut ser completada degut a un problema temporal. Si us plau, provi-ho més tard.',
	'cirrussearch-now-using' => 'Aquest wiki està utilitzant un nou cercador. ([[mw:Special:MyLanguage/Help:CirrusSearch|Més informació]])',
	'cirrussearch-ignored-headings' => ' #<!-- deixeu aquesta línia tal com està --> <pre>
# Títols que seran ignorats pel cercador.
# Els canvis fets aquí tindran efecte tant aviat com la pàgina amb el títol sigui indexada.
# Podeu forçar que una pàgina s\'indexi de nou fent una edició nul·la.
# La sintaxi és la següent:
#   * Tot el que hi hagi des d\'un caràcter "#" fins el final de línia és un comentari
#   * Tota línia no buida és el títol exacte a ignorar, amb les majúscules i complet
Referències
Enllaços externs
Vegeu també
 #</pre> <!-- deixeu aquesta línia tal com està -->',
	'cirrussearch-pref-desc' => 'Usa un motor de cerca nou, que indexa plantilles expandides, admet més idiomes i s’actualitza més freqüentment.', # Fuzzy
);

/** Czech (čeština)
 * @author Mormegil
 */
$messages['cs'] = array(
	'cirrussearch-desc' => 'Vyhledávání v MediaWiki běžící na Elasticsearch',
	'cirrussearch-backend-error' => 'Kvůli dočasnému problému jsme nemohli provést požadované vyhledávání. Zkuste to znovu později.',
	'cirrussearch-now-using' => 'Tato wiki používá nový vyhledávač. ([[mw:Special:MyLanguage/Help:CirrusSearch|Více informací]])',
	'cirrussearch-ignored-headings' => ' #<!-- tento řádek ponechte beze změny --> <pre>
# Zde uvedené nadpisy budou ignorovány vyhledáváním.
# Změny této stránky se projeví ve chvíli, kdy je stránka používající příslušný nadpis indexována.
# Přeindexování stránky můžete vynutit prázdnou editací.
# Syntaxe je taková:
#   * Cokoli od znaku „#“ do konce řádky je komentář.
#   * Každá neprázdná řádka je přesný nadpis, který se má ignorovat, včetně velikosti písmen a tak.
Reference
Externí odkazy
Související články
Související stránky
 #</pre> <!-- tento řádek ponechte beze změny -->',
	'cirrussearch-pref-label' => 'Nové hledání',
	'cirrussearch-pref-desc' => 'Používat nový vyhledávač, který indexuje rozbalené šablony, podporuje více jazyků a rychleji se aktualizuje.', # Fuzzy
);

/** Danish (dansk)
 * @author Christian List
 */
$messages['da'] = array(
	'cirrussearch-desc' => 'Søgning for MediaWiki drevet af Elasticsearch',
	'cirrussearch-backend-error' => 'Vi kunne ikke fuldføre søgningen på grund af et midlertidigt problem.  Prøv igen senere.',
	'cirrussearch-now-using' => 'Denne wiki bruger en ny søgemaskine. ([[mw:Special:MyLanguage/Help:CirrusSearch|Læs mere]])',
	'cirrussearch-ignored-headings' => ' #<!-- lad denne linje være præcis som den er --> <pre>
# Overskrifter, der vil blive ignoreret af søgning.
# Ændringer til dette træder i kraft så snart siden med overskriften er indekseret.
# Du kan tvinge siden til genindeksering ved at lave en nul redigering.
# syntaksen er som følger:
#   * Alt fra en tegnet "#" til slutningen af linjen er en kommentar
#   * Hver ikke-tomme linje er den nøjagtige titel der skal ignoreres, der skelnes også mellem store og små bogstaver
Referencer
Eksterne henvisninger
Se også
Kilder og henvisninger
Eksterne kilder/henvisninger
Kilder
 #</pre> <!-- lad denne linje være præcis som den er -->',
	'cirrussearch-pref-label' => 'Ny søgning',
	'cirrussearch-pref-desc' => 'Brug en ny søgemaskine, der indekserer udvidede skabeloner, understøtter flere sprog, og opdatere hurtigere.', # Fuzzy
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'cirrussearch-desc' => 'Ermöglicht eine „elasticsearch“-gestütze Suche',
	'cirrussearch-backend-error' => 'Deine Suche konnte aufgrund eines vorübergehenden Problems nicht abgeschlossen werden. Bitte später erneut versuchen.',
	'cirrussearch-now-using' => 'Dieses Wiki verwendet eine neue Suchmaschine. ([[mw:Special:MyLanguage/Help:CirrusSearch|Mehr erfahren]])',
	'cirrussearch-ignored-headings' => ' #<!-- diese Zeile nicht verändern --> <pre>
# Überschriften, die von der Suche ignoriert werden.
# Diese Änderungen werden wirksam, sobald die Seite mit der Überschrift indexiert wurde.
# Du kannst die Seitenindexierung erzwingen, indem du einen Nulledit durchführst.
# Syntax:
#   * Alles, was einer Raute („#“) bis zum Zeilenende folgt, ist ein Kommentar.
#   * Jede nicht-leere Zeile ist der exakte zu ignorierende Titel.
Einzelnachweise
Weblinks
Siehe auch
 #</pre> <!-- diese Zeile nicht verändern -->',
	'cirrussearch-pref-label' => 'Neue Suche',
	'cirrussearch-pref-desc' => 'Teste unsere neue Suchmaschine, die eine größere Anzahl an Sprachen unterstützt, aktuellere Ergebnisse liefert und auch Text innerhalb Vorlagen finden kann.',
);

/** Swiss High German (Schweizer Hochdeutsch)
 * @author Filzstift
 */
$messages['de-ch'] = array(
	'cirrussearch-desc' => 'Ermöglicht eine durch «Elasticsearch» gestützte Suche',
);

/** Spanish (español)
 * @author Fitoschido
 * @author Ihojose
 * @author Luis Felipe Schenone
 */
$messages['es'] = array(
	'cirrussearch-desc' => 'Hace que la búsqueda sea con Solr',
	'cirrussearch-backend-error' => 'No pudimos completar tu búsqueda debido a un problema temporario. Por favor intenta de nuevo más tarde.',
	'cirrussearch-now-using' => 'Esta wiki está utilizando un nuevo motor de búsqueda. ([[mw:Special:MyLanguage/Help:CirrusSearch|Ver más información]])',
	'cirrussearch-ignored-headings' => ' #<!-- deje esta línea tal y como está --> <pre>
# Títulos que serán ignorados por la búsqueda.
# Los cambios estarán en vigor tan pronto como la página con el título esté indexada.
# Puede forzar la página a ser reindexada haciendo una edición nula.
# La sintaxis es la siguiente: .N!
#   * Todo, desde un carácter "#" al final de la línea es un comentario
#   * Todas las líneas en blanco es un título exacto para ignorar, caso y cualquier 
Referencia
Enlaces externos
Véase también
 #</pre> <!-- deje esta línea tal y como está -->',
	'cirrussearch-pref-label' => 'Búsqueda nueva',
	'cirrussearch-pref-desc' => 'Usar un motor de búsqueda nuevo, que indiza plantillas expandidas, admite más idiomas y se actualiza más seguido.',
);

/** Persian (فارسی)
 * @author Ebraminio
 */
$messages['fa'] = array(
	'cirrussearch-desc' => 'جستجوی قدرت‌گرفته از Elasticsearch برای مدیاویکی',
	'cirrussearch-backend-error' => 'ما نمی‌توانیم جستجویتان به دلیل یک مشکل موقت کامل کنیم. لطفاً بعداً دوباره تلاش کنید.',
);

/** Finnish (suomi)
 * @author Nike
 */
$messages['fi'] = array(
	'cirrussearch-pref-label' => 'Uusi haku',
);

/** French (français)
 * @author Gomoko
 * @author Jean-Frédéric
 * @author Linedwell
 * @author Robby
 */
$messages['fr'] = array(
	'cirrussearch-desc' => 'Fait effectuer la recherche par Solr',
	'cirrussearch-backend-error' => 'Nous n’avons pas pu mener à bien votre recherche à cause d’un problème temporaire. Veuillez réessayer ultérieurement.',
	'cirrussearch-now-using' => 'Ce wiki utilise un nouveau moteur de recherche. ([[mw:Special:MyLanguage/Help:CirrusSearch|en savoir plus]])',
	'cirrussearch-ignored-headings' => ' #<!-- laisser cette ligne comme telle --> <pre>
# Titres de sections qui seront ignorés par la recherche
# Les changements effectués ici prennent effet dès lors que la page avec le titre est indexée.
# Vous pouvez forcer la réindexation de la page en effectuant une modification vide
# La syntaxe est la suivante :
#   * Toute ligne précédée d’un « # » est un commentaire
#   * Toute ligne non-vide est le titre exact à ignorer, casse comprise
Références
Liens externes
Voir aussi
 #</pre> <!-- laisser cette ligne comme telle -->',
	'cirrussearch-pref-label' => 'Nouvelle recherche',
	'cirrussearch-pref-desc' => 'Essayer notre nouvelle recherche qui supporte un plus grand nombre de langues, fournit davantage de résultats à jour, et peut même trouver du texte dans les modèles.',
);

/** Galician (galego)
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'cirrussearch-desc' => 'Procura baseada en Elasticsearch para MediaWiki',
	'cirrussearch-backend-error' => 'Non puidemos completar a súa procura debido a un problema temporal. Inténteo de novo máis tarde.',
	'cirrussearch-now-using' => 'Este wiki utiliza un novo motor de procuras. ([[mw:Special:MyLanguage/Help:CirrusSearch|Máis información]])',
	'cirrussearch-ignored-headings' => ' #<!-- Deixe esta liña tal e como está --> <pre>
# Cabeceiras que serán ignoradas nas buscas.
# Os cambios feitos aquí realízanse en canto se indexa a páxina coa cabeceira.
# Pode forzar o reindexado da páxina facendo unha edición baleira.
# A sintaxe é a seguinte:
#   * Todo o que vaia despois dun carácter "#" ata o final da liña é un comentario
#   * Toda liña que non estea en branco é o título exacto que ignorar, coas maiúsculas e minúsculas
Referencias
Ligazóns externas
Véxase tamén
 #</pre> <!-- Deixe esta liña tal e como está -->',
	'cirrussearch-pref-label' => 'Nova pescuda',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'cirrussearch-desc' => 'חיפוש במדיה־ויקי באמצעות Elasticsearch',
	'cirrussearch-backend-error' => 'לא הצלחנו להשלים את החיפוש שלך בשל בעיה זמנית. נא לנסות שוב מאוחר יותר.',
	'cirrussearch-now-using' => 'הוויקי הזה משתמש במנוע חיפוש חדש. ([[mw:Special:MyLanguage/Help:CirrusSearch|מידע נוסף]])',
	'cirrussearch-ignored-headings' => ' #<!-- leave this line exactly as it is --> <pre>
# כותרות של פסקאות שהחיפוש יתעלם מהן
# שינויים כאן ייכנסו לתוקף כשדף עם הכותרת הזאת ייכנס לאינדקס החיפוש
# אפשר לכפות הכנסה מחדש לאינדקס על־ידי עשיית עריכה אפסית
# התחביר הוא
#   * כל דבר שמתחילת בתו # ועד סוף השורה הוא הערה
#   * כל שורה שאינה ריקה היא כותרת שיש להתעלם ממנה, כולל רישיות האותיות וכיו"ב
הערות שוליים
קישורים חיצוניים
לקריאה נוספת
 #</pre> <!-- leave this line exactly as it is -->',
	'cirrussearch-pref-label' => 'חיפוש חדש',
	'cirrussearch-pref-desc' => 'נסו את החיפוש החדש שלנו, שתומך ביותר שפות, מספק תוצאות עדכניות יותר ואפילו מוצא טקסט בתוך תבניות.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'cirrussearch-desc' => 'Recerca pro MediaWiki actionate per Elasticsearch',
	'cirrussearch-backend-error' => 'Un problema temporari ha impedite le completion del recerca. Per favor reproba plus tarde.',
	'cirrussearch-now-using' => 'Iste wiki usa un nove motor de recerca. ([[mw:Special:MyLanguage/Help:CirrusSearch|Leger plus]])',
	'cirrussearch-ignored-headings' => ' #<!-- non modificar in alcun modo iste linea --> <pre>
# Titulos de sectiones que essera ignorate per le recerca.
# Cambiamentos in isto habera effecto post le indexation del paginas con iste sectiones.
# Tu pote fortiar le re-indexation de un pagina per medio de un modification nulle.
# Le syntaxe es:
#   * Toto a partir de un character "#" usque al fin del linea es un commento
#   * Cata linea non vacue es un titulo exacte a ignorar, con distinction inter majusculas e minusculas
Referentias
Ligamines externe
Vide etiam
 #</pre> <!-- non modificar in alcun modo iste linea -->',
	'cirrussearch-pref-label' => 'Nove recerca',
	'cirrussearch-pref-desc' => 'Usar un nove motor de recerca que indexa patronos in forma expandite, supporta plus linguas, e se actualisa plus rapidemente.', # Fuzzy
);

/** Italian (italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'cirrussearch-desc' => 'Ricerca realizzata con Elasticsearch per MediaWiki',
	'cirrussearch-backend-error' => 'Non si è riuscito a completare la tua ricerca a causa di un problema temporaneo. Riprova più tardi.',
	'cirrussearch-now-using' => 'Questo wiki usa un nuovo motore di ricerca. ([[mw:Special:MyLanguage/Help:CirrusSearch|Ulteriori informazioni]])',
	'cirrussearch-ignored-headings' => ' #<!-- lascia questa riga esattamente come è --> <pre>
# Elenco delle intestazioni che saranno ignorate dalla ricerca.
# Le modifiche a questa pagina saranno effettive non appena la pagina sarà indicizzata.
# Puoi forzare la re-indicizzazione di una pagina effettuando una modifica nulla.
# La sintassi è la seguente:
#   * Tutto dal carattere "#" alla fine della riga è un commento
#   * Tutte le righe non vuote sono le intestazioni esatte da ignorare, maiuscolo/minuscolo e tutto
Note
Voci correlate
Collegamenti esterni
 #</pre> <!-- lascia questa riga esattamente come è -->',
	'cirrussearch-pref-label' => 'Nuova ricerca',
	'cirrussearch-pref-desc' => "Prova la nostra nuova ricerca, che supporta un numero maggiore di lingue, fornisce risultati più aggiornati e può anche trovare il testo all'interno di template.",
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Shirayuki
 */
$messages['ja'] = array(
	'cirrussearch-desc' => 'MediaWiki 用の Elasticsearch 検索',
	'cirrussearch-backend-error' => '一時的な問題により検索を実行できませんでした。後でやり直してください。',
	'cirrussearch-now-using' => 'このウィキでは新しい検索エンジンを使用しています。([[mw:Special:MyLanguage/Help:CirrusSearch|詳細]])',
	'cirrussearch-pref-label' => '新規検索',
	'cirrussearch-pref-desc' => '数多くの言語に対応、より新しい検索結果を提供、テンプレート内のテキストも検索可能、という特徴がある新しい検索を試用',
);

/** Korean (한국어)
 * @author Hym411
 * @author 아라
 */
$messages['ko'] = array(
	'cirrussearch-desc' => '미디어위키를 위한 Elasticsearch 검색',
	'cirrussearch-backend-error' => '일시적인 문제 때문에 검색을 완료할 수 없습니다. 나중에 다시 시도하세요.',
	'cirrussearch-now-using' => '이 위키는 새로운 검색 엔진을 사용합니다. ([[mw:Special:MyLanguage/Help:CirrusSearch|더 알아보기]])',
	'cirrussearch-ignored-headings' => ' #<!-- 이 줄은 그대로 두십시오 --> <pre>
# 검색에서 무시되는 문단 제목입니다.
# 이 문서에 대한 바뀜은 즉시 문단 제목으로 된 문서가 다시 색인됩니다.
# null 편집을 하여 문서 다시 색인을 강제할 수 있습니다.
# 문법은 다음과 같습니다:
#   * "#" 문자에서 줄의 끝까지는 주석입니다
#   * 빈 줄이 아닌 줄은 무시할 정확한 제목이며, 대소문자를 무시합니다
참고
참조
출처
바깥 링크
바깥 고리
같이 보기
함께 보기
 #</pre> <!-- 이 줄은 그대로 두십시오 -->',
	'cirrussearch-pref-label' => '새 검색',
	'cirrussearch-pref-desc' => '확장된 틀 검색, 더 많은 언어 지원, 더 빠른 업데이트를 지원하는 새로운 검색 엔진을 사용합니다.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'cirrussearch-desc' => 'Elasticsearch-Sichfonctioun fir MediaWiki',
	'cirrussearch-backend-error' => 'Mir konnten Är Sich wéint engem temporäre Problem net maachen. Probéiert w.e.g. méi spéit nach eng Kéier.',
	'cirrussearch-now-using' => 'Dës Wiki benotzt eng nei Sichmaschinn.([[mw:Special:MyLanguage/Help:CirrusSearch|Fir méi ze wëssen]])',
	'cirrussearch-ignored-headings' => " #<!-- dës Zeil net änneren --> <pre>
# Iwwerschrëften, déi vun der Sich ignoréiert ginn.
# Dës Ännerunge gi wirksam, soubal déi Säit mat der Iwwerschrëft indexéiert gouf.
# Dir kënnt déi Säitenindexéierung erzwéngen, andeem dir eng Nullännerung maacht.
# Syntax:
# * Alles, wat no enger Raut („#“) bis zum Ënn vun der Zeil steet, ass eng Bemierkung.
# * All net-eidel Zeil ass de geneeën Titel fir z'ignoréieren.
Referenzen
Weblinken
Kuckt och
 #</pre> <!-- dës Zeil net änneren -->",
	'cirrussearch-pref-label' => 'Nei sichen',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'cirrussearch-desc' => 'Пребарување со Solr',
	'cirrussearch-backend-error' => 'Не можам наполно да го изведам пребарувањето поради привремен проблем. Обидете се подоцна.',
	'cirrussearch-now-using' => 'Ова вики користи нов пребарувач. ([[mw:Special:MyLanguage/Help:CirrusSearch|Дознајте повеќе]])',
	'cirrussearch-ignored-headings' => ' #<!-- не менувајте ништо во овој ред --> <pre>
# Заглавија што ќе се занемарат при пребарувањето.
# Измените во ова ќе стапат на сила штом ќе се индексира страницата со заглавието.
# Можете да наметнете преиндексирање на страницата ако извршите празно уредување.
# Синтаксата е следнава:
#   * Сето она што од знакот „#“ до крајот на редот е коментар
#   * Секој непразен ред е точниот наслов што треба да се занемари, разликувајќи големи од мали букви и сето останато
Наводи
Надворешни врски
Поврзано
 #</pre> <!-- не менувајте ништо во овој ред -->',
	'cirrussearch-pref-label' => 'Ново пребарување',
	'cirrussearch-pref-desc' => 'Користете нов пребарувач што индексира проширени шаблони, поддржува повеќе јазици и побргу се подновува.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'cirrussearch-desc' => 'Enjin pencarian yang dikuasakan oleh Elasticsearch untuk MediaWiki',
	'cirrussearch-backend-error' => 'Kami tidak dapat melengkapkan pencarian anda disebabkan masalah yang sementara. Sila cuba lagi nanti.',
);

/** Dutch (Nederlands)
 * @author Bluyten
 * @author Breghtje
 * @author Romaine
 * @author Siebrand
 */
$messages['nl'] = array(
	'cirrussearch-desc' => 'Zoeken via Solr',
	'cirrussearch-backend-error' => 'Als gevolg van een tijdelijk probleem kon uw zoekopdracht niet worden voltooit. Probeer het later opnieuw.',
	'cirrussearch-now-using' => 'Deze wiki maakt gebruik van een nieuwe zoekmachine. ([[mw:Special:MyLanguage/Help:CirrusSearch|Meer lezen]])',
	'cirrussearch-ignored-headings' => ' #<!-- leave this line exactly as it is --> <pre>
# Koppen die worden genegeerd tijdens het zoeken.
# Wijzigingen worden van kracht als een kop wordt geïndexeerd.
# U kunt opnieuw indexeren afdwingen door het uitvoeren van een nullbewerking.
# De syntaxis is al volgt:
#   * All tekst vanaf het teken "#" tot het einde van de regel wordt gezien als een opmerking;
#   * Iedere niet-lege regel is de precieze te negeren kop, inclusief hoofdlettergebruik en degelijke.
Referenties
Externe links
Zie ook
 #</pre> <!-- leave this line exactly as it is -->',
	'cirrussearch-pref-label' => 'Nieuwe zoekopdracht',
	'cirrussearch-pref-desc' => 'Probeer de nieuwe zoekfunctie die een groter aantal talen ondersteunt, meer recente zoekresultaten geeft, en zelfs tekst in sjablonen kan vinden.',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'cirrussearch-desc' => 'Fa efectuar la recèrca per Solr',
	'cirrussearch-backend-error' => 'Avèm pas pogut menar corrèctament vòstra recèrca a causa d’un problèma temporari. Ensajatz tornarmai ulteriorament.',
);

/** Polish (polski)
 * @author Chrumps
 */
$messages['pl'] = array(
	'cirrussearch-pref-label' => 'Nowe wyszukiwanie',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Jaideraf
 */
$messages['pt-br'] = array(
	'cirrussearch-desc' => "Mecanismo de busca ''Elasticsearch'' para MediaWiki",
	'cirrussearch-backend-error' => 'Não foi possível completar a busca devido a um problema temporário. Por favor, tente novamente mais tarde.',
	'cirrussearch-now-using' => 'Este wiki está utilizando um novo mecanismo de busca. ([[mw:Special:MyLanguage/Help:CirrusSearch|Learn more]])',
	'cirrussearch-ignored-headings' => ' #<!-- deixe esta linha exatamente como está --> <pre>
# Subtítulos que serão ignorados pela busca.
# Mudanças feitas aqui têm efeito quando a página com o subtítulo é indexada.
# Você pode forçar a reindexação realizando uma edição nula.
# A sintaxe é a seguinte:
#   * Tudo a partir do caractere "#", até o final da linha, é um comentário
#   * Cada linha não vazia é o título exato a ser ignorado, inclusive no uso de maiúsculas
Referências
Ligações externas
Ver também
 #</pre> <!-- deixe esta linha exatamente como está -->',
	'cirrussearch-pref-label' => 'Nova busca',
	'cirrussearch-pref-desc' => 'Utilizar o novo mecanismo de busca que indexa predefinições, suporta mais idiomas e atualiza mais rápido.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'cirrussearch-desc' => 'Ricerche Elasticsearch-powered pe MediaUicchi',
	'cirrussearch-backend-error' => "Non ge putime combletà 'a ricerca toje pe 'nu probbleme tembonarèe. Pe piacere pruève cchiù tarde.",
	'cirrussearch-ignored-headings' => " #<!-- lasse sta linèe accume ste --> <pre>
# Testate ca avène scettate jndr'à le ricerche.
# Le cangiaminde devendane effettive quanne 'a pàgene avène indicizzate.
# Tu puè forzà 'a reindicizzazzione d'a pàgene facenne 'nu cangiamende vecande.
# 'A sindasse jè 'a seguende:
#   * Ogneccose da 'u carattere \"#\" 'nzigne a fine d'a linèe jè 'nu commende
#   * Ogne linèa chiene jè 'u titole esatte da ignorà, case e ogneccose
Refereminde
Collegaminde de fore
'Ndruche pure
 #</pre> <!-- lasse sta linèe accume ste -->",
);

/** Russian (русский)
 * @author Okras
 */
$messages['ru'] = array(
	'cirrussearch-desc' => 'Поиск для MediaWiki на базе Elasticsearch',
	'cirrussearch-backend-error' => 'Нам не удалось завершить поиск из-за временной проблемы. Пожалуйста, повторите попытку позже.',
	'cirrussearch-now-using' => 'Эта вики использует новый поисковый движок. ([[mw:Special:MyLanguage/Help:CirrusSearch|Подробнее]])',
	'cirrussearch-ignored-headings' => ' #<!-- оставьте эту строку как есть --> <pre>
# Заголовки, которые будут игнорироваться поиском.
# Изменения вступают в силу, как только страница с заголовком индексируется.
# Вы можете принудить переиндексировать страницу с помощью нулевой правки.
# Синтаксис выглядит следующим образом:
#   * Всё, начинающееся на символ «#» и до конца строки является комментарием
#   * Каждая непустая строка является точным названием того, что будет игнорироваться, включая регистр и прочее
Примечания
Ссылки
См. также
 #</pre> <!-- оставьте эту строку как есть -->',
	'cirrussearch-pref-label' => 'Новый поиск',
	'cirrussearch-pref-desc' => 'Попробуйте наш новый поиск, который поддерживает большее количество языков, предоставляет более свежие результаты, и может даже найти текст внутри шаблонов.',
);

/** Slovak (slovenčina)
 * @author Sudo77(new)
 */
$messages['sk'] = array(
	'cirrussearch-backend-error' => 'Kvôli dočasnému problému sme nemohli dokončiť požadované vyhľadávanie. Skúste to znovu neskôr.',
);

/** Swedish (svenska)
 * @author Bengt B
 * @author Jopparn
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'cirrussearch-desc' => 'Elasticsearch-driven sökning för Mediawiki',
	'cirrussearch-backend-error' => 'Vi kunde inte slutföra din sökning på grund av ett tillfälligt problem. Försök igen senare.',
	'cirrussearch-ignored-headings' => '#<!-- leave this line exactly as it is --> <pre>
 # Rubriker som kommer att ignoreras av sökningen.
 # Ändringar till detta kommer att gälla så fort sidan med rubriken är indexerad.
 # Du kan tvinga sidan omindexera genom att göra en null redigering.
 # syntaxen är då följande:
 #   * Allt från ett "#" tecken till slutet av raden är en kommentar
 #   * Varje icke-tom rad är den exakta titeln som kommer att ignoreras, shiftläge och allt
Referenser
Externa länkar
Se också
 #</pre> <!-- leave this line exactly as it is -->',
	'cirrussearch-pref-label' => 'Ny sökning',
	'cirrussearch-pref-desc' => 'Prova vår nya sökning som stöder ett större antal språk, ger fler uppdaterade resultat och kan även hitta text inuti mallar.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Ата
 */
$messages['uk'] = array(
	'cirrussearch-desc' => 'Вмикає пошук з допомогою Solr',
	'cirrussearch-backend-error' => 'Нам не вдалося завершити ваш пошук через тимчасову проблему. Спробуйте ще раз пізніше.',
	'cirrussearch-now-using' => 'Це вікі використовує новий пошуковий рушій. ([[mw:Special:MyLanguage/Help:CirrusSearch|Докладніше]])',
	'cirrussearch-ignored-headings' => ' #<!-- залиште цей рядок точно таким, яким він є --> <pre>
# Заголовки, які будуть ігноруватися при пошуці.
# Зміни, які набирають сили при індексуванні сторінки з заголовком.
# Ви можете примусити переіндексувати сторінку з нульовим редагуванням.
# Синтаксис наступний:
#   * Усе, що починається з символу "#" до кінця рядка, є коментарем
#   * Кожний непорожній рядок є точним заголовком для ігнорування
Посилання
Зовнішні посилання
Див. також
 #</pre> <!-- залиште цей рядок точно таким, яким він є -->',
	'cirrussearch-pref-label' => 'Новий пошук',
	'cirrussearch-pref-desc' => 'Спробуйте наш новий пошук, який підтримує більше число мов, надає більше оновлених результатів і навіть може шукати текст всередині шаблону.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'cirrussearch-desc' => 'Công cụ tìm kiếm Elasticsearch dành cho MediaWiki',
	'cirrussearch-backend-error' => 'Không thể hoàn tất truy vấn của bạn vì một vấn đề tạm thời. Xin vui lòng thử lại sau.',
	'cirrussearch-now-using' => 'Wiki này đang sử dụng một công cụ tìm kiếm mới. ([[mw:Special:MyLanguage/Help:CirrusSearch|Tìm hiểu thêm]])',
	'cirrussearch-ignored-headings' => ' #<!-- để yên dòng này --> <pre>
# Công cụ tìm kiếm sẽ bỏ qua các đề mục này.
# Các thay đổi trên danh sách này sẽ có hiệu lực một khi trang có đề mục được đưa vào chỉ mục.
# Để bắt trang phải được đưa lại vào chỉ mục, thực hiện một sửa đổi vô hiệu quả.
# Cú pháp:
#   * Tất cả mọi thứ từ ký hiệu “#” để cuối dòng là chú thích.
#   * Mỗi dòng có nội dung là đúng tên đề mục để bỏ qua, phân biệt chữ hoa/thường.
Tham khảo
Chú thích
Liên kết ngoài
Xem thêm
Đọc thêm
 #</pre> <!-- để yên dòng này -->',
	'cirrussearch-pref-label' => 'Công cụ tìm kiếm mới',
	'cirrussearch-pref-desc' => 'Sử dụng một công cụ tìm kiếm mới có khả năng tìm văn bản được bung từ bản mẫu, hỗ trợ nhiều ngôn ngữ hơn, và cập nhật nhanh hơn.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Cwek
 * @author Qiyue2001
 * @author Shizhao
 * @author TianyinLee
 * @author Xiaomingyan
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'cirrussearch-desc' => '搜索由Elasticsearch为MediaWiki提供',
	'cirrussearch-backend-error' => '由于出现暂时性的问题，我们未能完成你的搜寻。请稍后再试。',
	'cirrussearch-now-using' => '这个wiki使用了新的搜索引擎。（[[mw:Special:MyLanguage/Help:CirrusSearch|详情]]）',
	'cirrussearch-pref-label' => '新搜索',
	'cirrussearch-pref-desc' => '使用新搜索引擎。该搜索引擎能索引展开模板，支持更多语言，更新更快。', # Fuzzy
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Justincheng12345
 */
$messages['zh-hant'] = array(
	'cirrussearch-desc' => 'MediaWiki的Solr搜尋', # Fuzzy
	'cirrussearch-backend-error' => '由於出現暫時性的問題，我們未能完成你的搜尋。請稍後再試。',
);
