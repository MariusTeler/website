<?
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */

/**
 * Get menu items (pages) as configured via Admin interface
 *
 * @param string $position Position, can be MENU_HEADER or MENU_FOOTER, from MENU_TYPES, and is the identifier field in database
 * @param bool $withStatus If menu item must be active (status = 1 field in database). Defaults to true
 * @return array List of menu items
 */
function menuGet($position, $withStatus = true)
{
    static $pages;

    if (!$pages) {
        $pages = dbSelect(
            'id, parent_id, type, name, url_key, title, link_name, is_noindex',
            'cms_pages',
            $withStatus ? 'status = 1' : '',
            'ord ASC'
        );
        $pages = array_column($pages, null, 'id');
    }

    $dbFields = "m.id, m.parent_id, m.page_id, m.link, m.link_name, m.icon, m.is_popup";
    $dbTables = 'cms_menu m LEFT JOIN cms_pages p ON p.id = m.page_id';
    $dbWhere = [];

    // Menu position
    $dbWhere[] = "m.identifier = " . dbEscape($position);

    // Active pages
    if ($withStatus) {
        $dbWhere[] = '(p.status = 1 OR p.status IS NULL)';
    }

    $dbWhere = implode(' AND ', $dbWhere);

    // Get menu
    $menuAll = dbSelect(
        $dbFields,
        $dbTables,
        $dbWhere,
        'm.parent_id ASC, m.ord ASC'
    );

    $menu = array();
    foreach ($menuAll as $row) {
        $row['page'] = $pages[$row['page_id']];
        if ($row['page']['parent_id']) {
            $row['page']['parent'] = $pages[$row['page']['parent_id']];
        }

        if (!$row['parent_id']) {
            $menu[$row['id']] = $row;
            $menu[$row['id']]['submenu'] = [];
        } else {
            if ($menu[$row['parent_id']]) {
                $menu[$row['parent_id']]['submenu'][] = $row;
            }
        }
    }

    return array_values($menu);
}

/**
 * Get menu URL for menu item
 *
 * @param array $row Menu item info obtained via menuGet() function
 * @param int $linkType The type of the link as defined by the following constants:
 *                      - LINK_RELATIVE: the returned link will be relative (domain is not included)
 *                      - LINK_ABSOLUTE: the returned link will be absolute (domain is included)
 *                      - LINK_FRONT: if used via admin interface, te returned link will be absolute, used for
 *                                    front module (without the "/admin" part, usually for newsletters or mails)
 * @return string URL for menu item
 */
function menuLink($row, $linkType = LINK_RELATIVE)
{
    if (strlen($row['link'])) {
        return $row['link'];
    }

    if ($row['page']['parent_id']) {
        $link = makeLink($linkType, $row['page']['parent'], $row['page']);
    } else {
        $link = makeLink($linkType, $row['page']);
    }

    return $link;
}

/**
 * Get link target attribute for menu item
 *
 * @param array $row Menu item info obtained via menuGet() function
 * @return string Returns target="_blank" attribute if is_popup = 1 field in database, or empty string
 */
function menuPopup($row)
{
    if ($row['is_popup']) {
        return 'target="_blank"';
    }

    return '';
}

/**
 * Get URL<br>
 * Example: makeLink(LINK_RELATIVE, 'category', 'subcategory', 'blog-post') returns '/category/subcategory/blog-post'
 *
 * @param int $linkType The type of the link as defined by the following constants:
 *                      - LINK_RELATIVE: the returned link will be relative (domain is not included)
 *                      - LINK_ABSOLUTE: the returned link will be absolute (domain is included)
 *                      - LINK_FRONT: if used via admin interface, te returned link will be absolute, used for
 *                                    front module (without the "/admin" part, usually for newsletters or mails)
 * @param string (variable number of) | array (containing url_key)
 * @return string
 */
function makeLink($linkType)
{
    global $websiteURL;

    // Function arguments
    $funcArgs = func_get_args();

    // Build link
    $link = array();

    // Multilingual links
    $lang = getLang();
    if ($lang && count($funcArgs) > 1) {
        if (!(PLATFORM_MODULE == PLATFORM_MODULE_ADMIN && $linkType == LINK_ABSOLUTE)) {
            $link[] = $lang;
        }
    }

    foreach ($funcArgs as $i => $row) {
        if ($i) {
            if (is_array($row)) {
                if ($row['url_key']) {
                    $link[] = $row['url_key'];
                }
            } else {
                $link[] = $row;
            }
        }
    }

    $link = implode('/', $link);

    switch ($linkType) {
        case LINK_RELATIVE:
            $link = '/' . $link;
            break;

        case LINK_ABSOLUTE:
            $link = $websiteURL . $link;
            break;

        case LINK_FRONT:
            $link = str_replace('/admin', '', $websiteURL) . $link;
            break;
    }

    return $link;
}

/**
 * Get image URL
 *
 * @param string $imagesFolder Images folder as defined in constants (IMAGES_PAGE, etc.)
 * @param string $thumbType Thumb type as defined in constants (THUMB_SMALL, THUMB_MEDIUM, THUMB_LARGE, THUMB_FACEBOOK, etc.)
 * @param string $image Image file name, containing extension (from database)
 * @param int $linkType The type of the link as defined by the following constants:
 *                      - LINK_RELATIVE: the returned link will be relative (domain is not included)
 *                      - LINK_ABSOLUTE: the returned link will be absolute (domain is included)
 * @param int $timestamp Image update timestamp (from database)
 * @return string
 */
function imageLink($imagesFolder, $thumbType, $image, $linkType = LINK_RELATIVE, $timestamp = 0)
{
    global $websiteURL;

    $imageLink = '';

    if ($image) {
        $imageLink = UPLOAD_URL . $imagesFolder . '/' . $thumbType . '/' . $image;

        if ($linkType == LINK_ABSOLUTE) {
            $imageLink = substr($websiteURL, 0, -1) . $imageLink;
        }

        if ($timestamp) {
            $imageLink .= '?v=' . urlencode($timestamp);
        }
    }

    return $imageLink;
}

/**
 * Get blog post URL
 *
 * @param int $linkType The type of the link as defined by the following constants:
 *                      - LINK_RELATIVE: the returned link will be relative (domain is not included)
 *                      - LINK_ABSOLUTE: the returned link will be absolute (domain is included)
 *                      - LINK_FRONT: if used via admin interface, te returned link will be absolute, used for
 *                                    front module (without the "/admin" part, usually for newsletters or mails)
 * @param array $post The blog post, array containing 'url_key' as key
 * @return string
 */
function blogLink($linkType, $post)
{
    static $pagesById;

    // Retrieve blog pages
    if (!$pagesById) {
        $pages = dbSelect(
            'id, parent_id, url_key',
            'cms_pages'
        );
        $pagesById = array_column($pages, null, 'id');
    }

    // Blog page
    $page = $pagesById[$post['page_id']];

    if (!$page['parent_id']) {
        $link = makeLink($linkType, $page, $post);
    } else {
        $link = makeLink($linkType, $pagesById[$page['parent_id']], $page, $post);
    }

    return $link;
}

/**
 * Get button URL from metadata button info
 *
 * @param array $row Button info containing {prefix}_page_id, {prefix}_link (from database, usually the metadata field)
 * @param string $prefix Prefix of the fields from button info array
 * @param int $linkType The type of the link as defined by the following constants:
 *                      - LINK_RELATIVE: the returned link will be relative (domain is not included)
 *                      - LINK_ABSOLUTE: the returned link will be absolute (domain is included)
 *                      - LINK_FRONT: if used via admin interface, te returned link will be absolute, used for
 *                                    front module (without the "/admin" part, usually for newsletters or mails)
 * @return string URL for the button
 */
function buttonLink($row, $prefix = 'button_', $linkType = LINK_RELATIVE, $withStatus = true)
{
    static $pages;

    // Get all pages just the first time
    if (!$pages) {
        $pages = dbSelect(
            'id, parent_id, type, name, url_key, title, link_name, is_noindex',
            'cms_pages',
            $withStatus ? 'status = 1' : '',
            'ord ASC'
        );
        $pages = array_column($pages, null, 'id');
    }

    if ($row[$prefix . 'page_id']) {
        $rowPage = $pages[$row[$prefix . 'page_id']];
        $link = makeLink(
            $linkType,
            $rowPage['parent_id'] ? $pages[$rowPage['parent_id']] : $rowPage,
            $rowPage['parent_id'] ? $rowPage: []
        );
    } else {
        $link = $row[$prefix . 'link'];
    }

    return $link;
}

/**
 * Count visits for entity using additional tables
 *
 * @param string $tableCounter DB table that stores visits counter
 * @param string $tableVisits DB table that stores recent visits
 * @param int $id Entity id
 * @param string $tableEntityKey DB key in tables to store entity id
 * @param int $timeHours Number of hours after which a new visit will counted from same IP
 * @param string $tableCounterKey DB key in $tableCounter that holds total visits counter
 */
function countVisit($tableCounter, $tableVisits, $id, $tableEntityKey, $timeHours, $tableCounterKey = 'visits')
{
    $dateVisited = dbShiftKey(dbSelect(
        'date',
        $tableVisits,
        'ip = ' . dbEscape($_SERVER['REMOTE_ADDR']) . '
                AND ' . $tableEntityKey . ' = ' . dbEscape($id) . '
                AND date > ' . (time() - $timeHours * 60 * 60),
        'date DESC',
        '',
        '0,1'
    ));

    if (!$dateVisited) {
        $r = dbRunQuery("
                UPDATE {$tableCounter} 
                SET {$tableCounterKey} = {$tableCounterKey} + 1 
                WHERE {$tableEntityKey} = " . dbEscape($id)
        );

        if (dbAffectedRows() < 1) {
            dbInsert($tableCounter, array(
                $tableEntityKey => $id,
                $tableCounterKey => 1
            ));
        }

        dbInsert($tableVisits, array(
            $tableEntityKey => $id,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => time()
        ));
    }
}

/**
 * Determine the requested page, assign requested data to that page and resulting ids to $_GET
 *
 * @param array $req The requested URL path parts
 * @param array $options Rules for possible paths that match data from database using url_key table field (default).
 *                       Each entry in the $options array is generated using rewriteOption() function
 */
function rewritePage($req, $options)
{
    global $cfg__;

    if (!$_GET['page']) {
        /*if ($lang = getLang()) {
            $lang = '_' . $lang;
        }*/

        $i = $ii = 0;
        $parseVars = array();
        foreach ($options as $j => $row) {
            // Check if $req[$i] part exists
            if (strlen($req[$i])) {
                if (in_array($req[$i], $row['skipReq'])) {
                    if ($req[$i + 1]) {
                        $i++;
                        $parseVars['dummy404' . $req[$i]] = 1;
                    } else {
                        break;
                    }
                }

                if (
                    /*!$_GET['page'] ||*/
                    !$row['parentPage'] ||
                    ($row['parentPage'] && in_array($_GET['page'], $row['parentPage']))
                ) {
                    // Build where
                    $where = array();

                    if ($row['status'] && !$_GET['preview']) {
                        $where[] = $row['status'];
                    }

                    // url_key match
                    $where[] = $row['DBKey'] . $lang . ' = ' . dbEscape(htmlspecialchars($req[$i]));

                    if ($row['parentField']) {
                        if (is_array($row['parentField'])) {
                            foreach ($row['parentField'] as $parentDB => $parentGET) {
                                if (!is_array($parentGET)) {
                                    if ($_GET[$parentGET]) {
                                        $where[] = $parentDB . ' = ' . dbEscape($_GET[$parentGET]);
                                    }
                                } else {
                                    foreach (array_reverse($parentGET) as $pGET) {
                                        if ($_GET[$pGET]) {
                                            $where[] = $parentDB . ' = ' . dbEscape($_GET[$pGET]);

                                            break;
                                        }
                                    }
                                }
                            }
                        } elseif ($_GET[$options[$ii]['GETKey']]) {
                            $where[] = $row['parentField'] . ' = ' . dbEscape($_GET[$options[$ii]['GETKey']]);
                        }
                    }

                    if ($row['where']) {
                        $where[] = $row['where'];
                    }

                    $id = dbShift(dbSelect('*', $row['table'], implode(' AND ', $where)));

                    if ($id) {
                        if ($lang) {
                            $id = parseLang($id, $row['table']);
                        }

                        $_GET[$row['GETKey']] = $id['id'];
                        $_GET['page'] = ($cfg__['category']['pages'][$id['type']] ? $cfg__['category']['pages'][$id['type']] : $row['GETPage']);
                        $parseVars[$row['GETKey']] = $id;
                        $i++;
                        $ii = $j;
                    }
                }
            }
        }

        if ($parseVars && $_GET['page']) {
            foreach ($parseVars as $key => $val) {
                parseVar($key, $val, $_GET['page']);
            }
        }
    }
}

/**
 * Generate URL processing rule as an array that is used in constructing an array of parameters for rewritePage() function
 *
 * @param string $table Table to be searched for URL part
 * @param string $GETKey $_GET key that will be populated with the row id, if found
 * @param string $GETPage Page that will be parsed, if no page is defined in $cfg__['category']['pages'][$page['type']]
 * @param string|array $parentField Field(s) in table that must match the values of determined $_GET keys.
 *                                  If string in provided, the field will match the previously found $_GET key.
 *                                  If an array is provided, the field name will be each array key and will match each $_GET value, if value is string.
 *                                  If value is array, the field name will match first $_GET key value, in reverse order.
 *                                  Defaults to empty string
 * @param string $where Additional where condition to be added to SQL query. Defaults to empty string
 * @param string $status Status condition to be added to SQL query. Defaults to 'status = 1'
 * @param string $DBKey Table field to match the URL part against. Defaults to 'url_key'
 * @param array $parentPage Parent page(s), that if matched, will trigger current rule processing.
 *                          If $parentPage is not matched, current rule will not be processed and will skip to the next rule.
 *                          Defaults to empty array
 * @param array $skipReq Will skip URL parts that match provided parts and will populate $_GET.
 *                       with 'dummy404{$part}' if there are additional URL parts following.
 *                       Defaults to empty array
 *
 * @return array
 */
function rewriteOption(
    $table,
    $GETKey,
    $GETPage,
    $parentField = '',
    $where = '',
    $status = 'status = 1',
    $DBKey = 'url_key',
    $parentPage = array(),
    $skipReq = array()
) {
    return array(
        'table' => $table,
        'GETKey' => $GETKey,
        'GETPage' => $GETPage,
        'parentField' => $parentField,
        'where' => $where,
        'status' => $status,
        'DBKey' => $DBKey,
        'parentPage' => $parentPage,
        'skipReq' => $skipReq
    );
}

/**
 * Encode text for URL Rewrite
 *
 * @param string $text Text to be encoded
 * @return string
 */
function rewriteEnc($text)
{
    $text = preg_replace("/[áàâãªäă]/u","a", $text);
    $text = preg_replace("/[ÁÀÂÃÄĂ]/u","A", $text);
    $text = preg_replace("/[ÍÌÎÏİ]/u","I", $text);
    $text = preg_replace("/[íìîïı]/u","i", $text);
    $text = preg_replace("/[șşȘŞ]/u","s", $text);
    $text = preg_replace("/[țȚ]/u","t", $text);
    $text = preg_replace("/[éèêë]/u","e", $text);
    $text = preg_replace("/[ÉÈÊË]/u","E", $text);
    $text = preg_replace("/[óòôõºö]/u","o", $text);
    $text = preg_replace("/[ÓÒÔÕÖ]/u","O", $text);
    $text = preg_replace("/[úùûü]/u","u", $text);
    $text = preg_replace("/[ÚÙÛÜ]/u","U", $text);
    $text = str_replace("ç","c", $text);
    $text = str_replace("Ç","C", $text);
    $text = str_replace("ğ","g", $text);
    $text = str_replace("Ğ","G", $text);
    $text = str_replace("ñ","n", $text);
    $text = str_replace("Ñ","N", $text);
    $text = str_replace('&', 'and', $text);
    $text = preg_replace("/[^a-zA-Z0-9 _-]/", "", $text);
    $text = preg_replace("/[ ]+/u", " ", $text);
    $text = str_replace(' ', '-', $text);

    return strtolower($text);
}

/**
 * Parse SEO info globally
 * Parsed variables are as follows (in brackets keys from $cms, if different):
 * - SEO: siteTitle (site_title) / siteDescription (site_description) / siteCanonical / relPrev / relNext / noIndex (is_noindex)
 * - Facebook: fbType / fbURL / fbTitle / fbDescription / fbImage / fbImageWidth / fbImageHeight / fbAuthor / fbPublishedTime / fbModifiedTime
 * - AMP: ampURL
 *
 * @param array $cms Page data used to build SEO info
 * @param string|array $titleKey Key(s) used to find title tag info. First one that has data in $cms will be used.
                                 'site_title' will automatically be present as the first key.
 * @param array $descriptionKey Key(s) used to find description metadata info.
                                'site_description' will automatically be present as the first key.
 */
function parseSEO($cms, $titleKey, $descriptionKey = array())
{
    // Title
    $title = array('site_title');
    if (!is_array($titleKey)) {
        array_push($title, $titleKey);
    } else {
        $title = array_merge($title, $titleKey);
    }

    foreach ($title as $key) {
        if (strlen($cms[$key])) {
            parseVar('siteTitle', $cms[$key]);
            break;
        }
    }

    // Description
    $desc = array('site_description');
    $desc = array_merge($desc, $descriptionKey);

    foreach ($desc as $key) {
        if (strlen($cms[$key])) {
            parseVar('siteDescription', $cms[$key]);
            break;
        }
    }

    parseVar('fbType', $cms['fbType']);
    parseVar('fbURL', $cms['fbURL']);
    parseVar('fbTitle', $cms['fbTitle']);
    parseVar('fbDescription', $cms['fbDescription']);
    parseVar('fbImage', $cms['fbImage']);
    parseVar('fbImageWidth', $cms['fbImageWidth']);
    parseVar('fbImageHeight', $cms['fbImageHeight']);
    parseVar('fbAuthor', $cms['fbAuthor']);
    parseVar('fbPublishedTime', $cms['fbPublishedTime']);
    parseVar('fbModifiedTime', $cms['fbModifiedTime']);
    parseVar('siteCanonical', trim($cms['siteCanonical']));
    parseVar('ampURL', $cms['ampURL']);
    parseVar('noIndex', $cms['is_noindex']);
}

/**
 * Return short text
 *
 * @param string $str The long text
 * @param int $nr_chars Maximum number of characters in returned text
 * @param false $is_dots Append $dots to returned text
 * @param string $allowedTags Allowed tags in returned text. Default, all tags are stripped
 * @param string $dots String to append when $is_dots = true
 * @return string
 */
function shortText($str, $nr_chars, $is_dots = false, $allowedTags = '', $dots = '...')
{
    $str = trim(str_replace('&nbsp;', ' ', strip_tags($str, $allowedTags)));
    if (strlen($str) && strlen($str) > $nr_chars) {
        $chr = substr($str, $nr_chars, 1);
        while ($chr != ' ') {
            $nr_chars--;
            $chr = substr($str, $nr_chars, 1);
        }
        return substr($str, 0, $nr_chars) . (($is_dots) ? $dots : '');
    } else {
        return $str;
    }
}

/**
 * Get page info as configured via Admin interface
 *
 * @param string $key Identifier key
 * @param string $value Identifier value
 * @param bool $status True if page must be active (status = 1 in database) or false otherwise (status = 0).
 *                     Defaults to true
 * @param null|string $returnKey If value for a certain key should be returned instead of all page info.
 *                               Defaults to null
 * @param string $table DB table from where to retrieve data. Defaults to 'cms_pages'
 * @return array|string All page info as an array or string if $returnKey is specified
 */
function getPageByKey($key, $value, $status = true, $returnKey = null, $table = 'cms_pages')
{
    $where = array();
    $where[] = $key . '=' . dbEscape($value);

    if ($status) {
        $where[] = 'status = 1';
    }

    $page = dbShift(dbSelect('*', $table, implode(' AND ', $where)));

    if (!$returnKey) {
        return $page;
    } else {
        return $page[$returnKey];
    }
}

/**
 * Get various info as configured via Admin interface
 *
 * @param string $key Identifier for the data stored in various table
 * @param bool $active True if page must be active (status = 1 in database) or false otherwise (status = 0).
 *                     Defaults to true
 * @param bool $list True if data must be returned as a list of rows (multiple entries for the same identifier).
 *                   False if data must be returned as a simple row
 *                   Defaults to true
 * @return array
 */
function variousGet($key, $active = true, $list = true)
{
    $where = array();
    $where[] = 'name = ' . dbEscape($key);
    if ($active) {
        $where[] = 'status = 1';
    }

    $rows = dbSelect('*', 'cms_various', implode(' AND ', $where));

    if ($list) {
        return $rows;
    } else {
        return dbShift($rows);
    }
}

/**
 * Returns a http query built using an array of params.
 *
 * @param array $httpQuery An array of key, value pairs.
 * @param array $replaceQuery (Optional.) Values that need to be replaced inside current query (key, value).
 * @param bool $appendQuery (Optional.) If query should be appended to another existing or is stand alone (proceeded by ?).
 * @return string
 */
function buildHttpQuery($httpQuery, $replaceQuery = array(), $appendQuery = false)
{
    if (is_array($httpQuery) && is_array($replaceQuery) && ($httpQuery || $replaceQuery)) {
        foreach ($replaceQuery as $k => $v) {
            if ($v) {
                $httpQuery[$k] = $v;
            } else {
                unset($httpQuery[$k]);
            }
        }

        ksort($httpQuery);

        if ($httpQuery) {
            return ($appendQuery ? '&' : '?') . http_build_query($httpQuery);
        }
    }
}

/**
 * Check if site is visited by a mobile device
 *
 * @return bool Returns true if device is a phone or tablet, false otherwise
 */
function isMobile($tablet = false)
{
    global $cfg__;

    static $isMobile, $isTablet;

    if ($_GET['mobilePreview'] && userGet($cfg__['session']['key_admin'])) {
        $isMobile = true;
    }

    if (!isset($isMobile) || !isset($isTablet)) {

        $detect = new Mobile_Detect;

        // Any mobile device (phones or tablets).
        $isMobile = $detect->isMobile();

        $isTablet = $detect->isTablet();
    }

    if ($tablet) {
        return $isTablet;
    }

    return $isMobile;
}

/**
 * @param int $entityType Entity type, from constants
 * @param int $entityId Entity id
 * @param string $html HTML that may contain entity blocks
 * @return array Array of elements that can be either modules with 'type' (from constants) and 'id' keys or plain HTML
 */
function entityToHtml($entityType, $entityId, $html)
{
    global $cfg__;

    // Debug timer
    $qStart = microtime(true);

    // Get current relations
    $modules = entityGetRelations($entityType, $entityId);

    // Initialize node search
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?><html><body>' . $html . '</body></html>', LIBXML_HTML_NODEFDTD);

    $xpath = new DOMXPath($doc);
    $xpathNodes = $xpath->query("//p[contains(@data-cmsblocks, '1')]");

    // List of root nodes, one by one
    $domNodes = [];

    // If cms block exist, then extract entities
    if ($xpathNodes->count()) {
        $i = 0;
        $body = $doc->getElementsByTagName('body')[0];
        foreach ($body->childNodes as $node) {
            // If node is cms block, extract entity type and id
            if (
                $node->nodeType == XML_ELEMENT_NODE
                && $node->getAttribute('data-cmsblocks') == 1
            ) {
                // Module info
                $moduleType = $node->getAttribute('data-type');
                $moduleId = $node->getAttribute('data-id');

                // Check if node is in relation with current entity
                if (
                    $moduleType
                    && $moduleId
                    && in_array($moduleId, $modules[$moduleType])
                ) {
                    if ($domNodes) {
                        $i++;
                    }

                    $domNodes[$i++] = [
                        'type' => $moduleType,
                        'id' => $moduleId
                    ];
                }
            // Exclude whitespace text node (ex: new line)
            } elseif (
                !(
                    $node->nodeType == XML_TEXT_NODE
                    && ctype_space($node->nodeValue)
                )
            ) {
                $domNodes[$i]['html'] .= $doc->saveHTML($node) . PHP_EOL;
            }
        }
    } else {
        $domNodes[] = [
            'html' => $html ?: '<span></span>'
        ];
    }

    // Debug timer
    $qEnd = microtime(true);

    if ($cfg__['debug']['on']) {
        parseDebug('Blocks processing: ' . round($qEnd - $qStart, 4));
    }

    return $domNodes;
}

/**
 * Get current entity-block relations
 *
 * @param int $entityType Entity type, from constants
 * @param int $entityId Entity id
 * @return array Array of modules with keys as entity types (from constants) and array of module ids as values
 */
function entityGetRelations($entityType, $entityId)
{
    // List of associated modules by type
    $modules = [];

    // List of associated modules from DB
    $modulesDB = dbSelect(
        '*',
        'cms_relation',
        'entity = ' . dbEscape($entityType) . ' AND entity_id = ' . dbEscape($entityId)
    );

    // Extract modules ids
    foreach (ENTITY_MODULES_TABLES as $moduleType => $moduleTable) {
        $modules[$moduleType] = array_column(
            array_filter($modulesDB, function($row) use ($moduleType) {
                return $row['module'] == $moduleType;
            }),
            'module_id'
        );
    }

    return $modules;
}

/**
 * Add loading="lazy" attribute to every <img> tag
 *
 * @param string $html HTML code
 * @return string
 */
function lazyLoadImg($html){

    $html = str_ireplace('<img ', '<img loading="lazy" ', $html);

    return $html;
}

/**
 * Redirect visitor as configured in $dbRedirects (defined in /platform/config/db.redirects.php)
 */
function redirectSite()
{
    global $dbRedirects;

    if ($dbRedirects) {
        $url = $_SERVER['REQUEST_URI'];
        $urlDecoded = urldecode($url);

        if (substr($url, -1) == '/') {
            $url = substr($url, 0, -1);
            $urlDecoded = substr($urlDecoded, 0, -1);
        }

        if ($dbRedirects['normal'][$url]) {
            $redirect = $dbRedirects['normal'][$url];

            redirectURL($redirect['url_to'], $redirect['redirect_type']);
        } elseif ($dbRedirects['normal'][$urlDecoded]) {
            $redirect = $dbRedirects['normal'][$urlDecoded];

            redirectURL($redirect['url_to'], $redirect['redirect_type']);
        } elseif ($dbRedirects['flexible']) {
            foreach ($dbRedirects['flexible'] as $key => $row) {
                if (strpos($url, $key) === 0 || strpos($urlDecoded, $key) === 0) {

                    if (strpos($urlDecoded, $key) === 0) {
                        $url = $urlDecoded;
                    }

                    $redirect = $dbRedirects['flexible'][$key];
                    $redirect['url_to'] = str_replace('#', str_replace($key, '', $url), $redirect['url_to']);

                    redirectURL($redirect['url_to'], $redirect['redirect_type']);
                }
            }
        }
    }
}
