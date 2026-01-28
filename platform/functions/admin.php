<?php
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */


/**
 * Get admin menu from 'back_pages' table
 * Active menu for current user is defined in global scope as $activeMenu
 *
 * @return array List of pages
 */
function adminMenu()
{
    $adminMenu = array();
    $categories = dbSelect("id, name, page, icon, (SELECT GROUP_CONCAT(CONCAT(name, '::', page) ORDER BY ord ASC) FROM back_pages WHERE id_parent = bk.id AND status = 1) AS pages",
        'back_pages bk', 'status = 1 AND id_parent = 0', 'ord ASC');
    foreach ($categories as $cat) {
        if (strlen($cat['page'])) {
            $otherPages[$cat['page']] = $cat['name'];
        } else {
            $pages = array();
            $subcats = explode(',', $cat['pages']);
            foreach ($subcats as $subcat) {
                $subcat = explode('::', $subcat);
                $pages[$subcat[1]] = $subcat[0];
            }
            $adminMenu[] = array('cat' => $cat['name'], 'icon' => $cat['icon'], 'pages' => $pages, 'id' => $cat['id']);
        }
    }

    if ($otherPages) {
        $adminMenu[] = array('cat' => 'Alte pagini', 'hidden' => true, 'pages' => $otherPages);
    }

    sessionSet('activeMenu', userGetInfo('metadata')['active_menu']);

    return $adminMenu;
}

/**
 * Get active menu
 *
 * @return array|mixed List of ids from menu
 */
function activeMenu()
{
    $activeMenu = sessionGet('activeMenu');

    if (!is_array($activeMenu)) {
        $activeMenu = array();
    }

    return $activeMenu;
}

/**
 * Initialize access rights to pages, help and WYSIWYG for current user
 * Full menu is defined in global scope as $adminMenu
 * Restricted menu for current user is defined in global scope as $adminAccess
 * Session variables 'access' and 'username' are set for WYSIWYG
 * @ validated.unique and @ init.upload are available for all logged-in users
 *
 */
function adminAccess()
{
    $page = $_GET['page'];
    if (!userGetAccess(ADMIN_SUPERADMIN)) {
        $accessPages = [];
        foreach (userGetInfo('metadata')['rights'] as $pageName => $pageRights) {
            if (in_array(ADMIN_RIGHT_VIEW, $pageRights)) {
                $accessPages[] = $pageName;
            }
        }

        parseVar('adminAccess', $accessPages);

        if (substr($page, 0, 5) != 'ajax.' && $page != '@validate.unique' && $page != '@init.upload' && strlen($page)) {
            if (substr($page, -5) == '.edit') {
                $editPage = substr($page, 0, -5);
            }

            if (!in_array($page, $accessPages) && !in_array($editPage, $accessPages)) {
                $_GET['page'] = 'home';
            }
        }
    } else {
        // Support for help
        formEditor('helpEditor');
    }

    parseVar('adminMenu', adminMenu());
}

/**
 * Check if current user is of a certain type
 * User types are defined as follows:
 * - ADMIN_NORMAL: has acces to configured pages
 * - ADMIN_SUPERADMIN: has access to all the pages
 *
 * @param int $type Type of access
 * @return bool
 */
function userGetAccess($type)
{
    return userGetInfo('access') == $type;
}

/**
 * Check if current user has right to a page
 *
 * @param int $right Right type as configured via constants
 * @param string $pageURL URL of page including query params
 * @return bool True if user has right, false otherwise
 */
function userGetRight($right, $pageURL)
{
    static $pagesByURL;

    if (userGetAccess(ADMIN_SUPERADMIN)) {
        return true;
    }

    // Get page
    $pageKey = md5($pageURL);
    if (is_array($pagesByURL) && $pagesByURL[$pageKey]) {
        $page = $pagesByURL[$pageKey];
    } else {
        $pageURL = parse_url($pageURL);
        parse_str($pageURL['query'], $pageQuery);
        $page = $pageQuery['page'];

        if (substr($page, -5) == '.edit') {
            $page = substr($page, 0, -5);
        }

        if ($page) {
            $pagesByURL[$pageKey] = $page;
        }
    }

    if ($page) {
        // Get user rights for page
        $pageRights = userGetInfo('metadata')['rights'][$page];

        if ($pageRights && in_array($right, $pageRights)) {
            return true;
        }
    }

    return false;
}

/**
 * Do a login with Google
 * Settings key 'google-api-redirect-uri' must be defined
 * /platform/config/client_secret.json must be defined
 * $cfg__['login']['settings']['google'] must be true in general configuration array
 *
 */
function userLoginGoogle()
{
    global $cfg__;

    $error = $cfg__['login']['errorCode'][6];

    try {
        Firebase\JWT\JWT::$leeway = 5;

        $client = new Google_Client();
        $client->setAuthConfig(PLATFORM_PATH . 'config/client_secret.json');
        $client->setRedirectUri(settingsGet('google-api-redirect-uri'));
        $token = $client->fetchAccessTokenWithAuthCode($_POST['code']);
        $client->setAccessToken($token);
        $payload = $client->verifyIdToken();

        if ($payload) {
            // Users table in DB
            $usersTable = $cfg__['login']['settings']['table'];

            // Check for user in DB
            $user = dbShift(dbSelect(
                '*',
                $usersTable,
                $cfg__['login']['settings']['email'] . ' = ' . dbEscape($payload['email'])
            ));

            if ($user) {
                // Set refresh token for future use
                $payload['id_token'] = $token['refresh_token'];

                // Login user
                userLogin('', '', $payload);
            } else {
                $errCode = 7;
                $error = $cfg__['login']['errorCode'][$errCode];
                throw new Exception($error);
            }
        }
    } catch (Exception $e) {
        // Log error in error_log
        error_log('Error on Google Login: ' . $e->getMessage());

        // Log login try in DB
        $loginLog = array(
            'email' => $payload['email'] ?: 'Google error',
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => time(),
            'error_code' => $errCode ?: 6
        );

        userLoginLog($loginLog);

        // Send reponse via AJAX
        $contents = $fields = $options = $css = $attributes = $functions = array();

        $contents[] = array('id' => 'googleLoginError', 'value' => $error);
        $css[] = array('id' => 'googleLoginError', 'property' => 'display', 'value' => 'block');

        ajaxResponse($contents, $fields, $options, $css, $attributes, $functions);
    }
}

/**
 * Do a login with Facebook
 * Settings keys 'facebook-app-id' and 'facebook-app-secret' must be defined
 * $cfg__['login']['settings']['facebook'] must be true in general configuration array
 *
 */
function userLoginFacebook()
{
    global $cfg__;

    $errCode = 6;
    $error = $cfg__['login']['errorCode'][$errCode];
    $user = array();

    try {
        $fb = initFBSDK();

        $helper = $fb->getJavaScriptHelper();
        $accessToken = $helper->getAccessToken();

        if (!isset($accessToken)) {
            throw new Exception('No cookie set or no OAuth data could be obtained from cookie.');
        }

        $response = $fb->get('/me?fields=id,first_name,last_name,email', $accessToken);
        $payload = $response->getGraphUser();

        if ($payload) {
            // Users table in DB
            $usersTable = $cfg__['login']['settings']['table'];

            // Check for user in DB
            $user = dbShift(dbSelect(
                '*',
                $usersTable,
                $cfg__['login']['settings']['email'] . ' = ' . dbEscape($payload['email'])
            ));

            if ($user) {
                // Set refresh token for future use
                $payload['id_token'] = $accessToken;

                // Login user
                userLogin('', '', [], $payload);
            } else {
                $errCode = 8;
                $error = $cfg__['login']['errorCode'][$errCode];
                throw new Exception($error);
            }
        }
    } catch (Exception $e) {
        // Log error in error_log
        error_log('Error on Facebook Login: ' . $e->getMessage());

        // Log login try in DB
        $loginLog = array(
            'email' => $payload['email'] ?: 'Facebook error',
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => time(),
            'error_code' => $errCode ?: 6
        );

        userLoginLog($loginLog);

        // Send response via AJAX
        $contents = $fields = $options = $css = $attributes = $functions = array();

        $contents[] = array('id' => 'facebookLoginError', 'value' => $error);
        $css[] = array('id' => 'facebookLoginError', 'property' => 'display', 'value' => 'block');

        ajaxResponse($contents, $fields, $options, $css, $attributes, $functions);
    }
}

/**
 * Do a login with Microsoft
 * Settings keys 'microsoft-app-id' and 'microsoft-app-secret' must be defined
 * $cfg__['login']['settings']['microsoft'] must be true in general configuration array
 *
 */
function userLoginMicrosoft()
{
    global $cfg__;

    $errCode = 6;
    $error = $cfg__['login']['errorCode'][$errCode];
    $user = array();

    try {
        // Validate state
        $expectedState = sessionGet('userLoginMicrosoftState');
        sessionSet('userLoginMicrosoftState', '');

        if (
            !$expectedState
            || !$_GET['state']
            || $expectedState != $_GET['state']
            || !$_GET['code']
        ) {
            throw new Exception('Login invalid');
        }

        // Initialize the OAuth client
        $oauthClient = userLoginMicrosoftUrl(true);

        // Make the token request
        $accessToken = $oauthClient->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        $graph = new Microsoft\Graph\Graph();
        $graph->setAccessToken($accessToken->getToken());

        $user = $graph->createRequest('GET', '/me?$select=id,givenName,surname,displayName,mail,userPrincipalName')
            ->setReturnType(Microsoft\Graph\Model\User::class)
            ->execute();

        $payload = [
            'id' => $user->getId(),
            'name' => $user->getDisplayName(),
            'surname' => $user->getsurname(),
            'givenName' => $user->getgivenName(),
            'email' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName(),
        ];

        if ($payload['email']) {
            // Users table in DB
            $usersTable = $cfg__['login']['settings']['table'];

            // Check for user in DB
            $user = dbShift(dbSelect(
                '*',
                $usersTable,
                $cfg__['login']['settings']['email'] . ' = ' . dbEscape($payload['email'])
            ));

            if ($user) {
                // Set refresh token for future use
                $payload['id_token'] = $accessToken->getToken();

                // Login user
                userLogin('', '', [], [], $payload);
            } else {
                $errCode = 9;
                $error = $cfg__['login']['errorCode'][$errCode];
                throw new Exception($error);
            }
        }
    } catch (Exception $e) {
        // Log error in error_log
        error_log('Error on Microsoft Login: ' . $e->getMessage());

        // Log login try in DB
        $loginLog = array(
            'email' => $payload['email'] ?: 'Microsoft error',
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => time(),
            'error_code' => $errCode ?: 6
        );

        userLoginLog($loginLog);

        // Set login error code to pe used after redirect
        sessionSet('loginErrorCode', $errCode ?: 6);
    }
}

/**
 * Get authentication URL for Microsoft
 *
 * @param bool $returnClient If OAuth client object should be returned instead of URL
 * @return string | \League\OAuth2\Client\Provider\GenericProvider Authentication URL or Oauth client object
 */
function userLoginMicrosoftUrl($returnClient = false)
{
    global $websiteURL;

    // Initialize the OAuth client
    $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => settingsGet('microsoft-app-id'),
        'clientSecret'            => settingsGet('microsoft-app-secret'),
        'redirectUri'             => $websiteURL,
        'urlAuthorize'            => 'https://login.microsoftonline.com/common' . '/oauth2/v2.0/authorize',
        'urlAccessToken'          => 'https://login.microsoftonline.com/common' . '/oauth2/v2.0/token',
        'urlResourceOwnerDetails' => '',
        'scopes'                  => 'openid profile offline_access user.read email'
    ]);

    if ($returnClient) {
        return $oauthClient;
    }

    // Authorization URL
    $authUrl = $oauthClient->getAuthorizationUrl();

    // Save client state so we can validate in callback
    sessionSet('userLoginMicrosoftState', $oauthClient->getState());

    return $authUrl;
}

/**
 * Generate a CSRF token
 *
 * @param int $expiryHours Number of hours before the token expires. Defaults to 24
 * @return mixed|string Generated token that can be used with userCsrfValidate() function
 * @throws Exception
 */
function userCsrfToken($expiryHours = 24)
{
    $token = sessionGet('csrf_token');
    $tokenExpires = sessionGet('csrf_expires');

    if (!$token || $tokenExpires <= time()) {
        $token = bin2hex(random_bytes(32));
        $tokenExpires = strtotime("+{$expiryHours} hours");

        sessionSet('csrf_token', $token);
        sessionSet('csrf_expires', $tokenExpires);
    }

    return $token;
}

/**
 * Validate user token
 *
 * @param string $userToken User token generated using userCsrfToken() function
 * @return bool Returns true if token is valid, false otherwise
 */
function userCsrfValidate($userToken)
{
    $token = sessionGet('csrf_token');
    $tokenExpires = sessionGet('csrf_expires');
    $tokenValid = false;

    if (
        $token
        && $tokenExpires >= time()
        && !empty($userToken)
        && hash_equals($token, $userToken)
    ) {
        $tokenValid = true;
    }

    return $tokenValid;
}

/**
 * Update status in table for a specific row
 * The status will be 0 or 1
 *
 * @param string $table Table in database
 * @param int $status Row id
 * @param string $field Status field in table. Defaults to 'status'
 * @param string $conn Database connection. Defaults to 'main'
 * @return bool
 */
function dbStatus($table, $status, $field = 'status', $conn = 'main')
{
    // Check user rights
    if (!userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI'])) {
        return false;
    }

    // Data for user log
    $data = array();
    $data['row'] = dbShift(dbSelect('*', $table, 'id = ' . dbEscape($status)));
    $data['field'] = $field;

    $result = dbRunQuery("UPDATE {$table} SET {$field} = 1 - {$field} WHERE id = " . dbEscape($status), $conn);

    if ($result === false) {
        alertsAdd('Modificarea nu a putut fi efectuata!', 'error');

        // User log
        dbLog($table, ADMIN_ACTION_STATUS, false, $data);

        return false;
    }

    alertsAdd('Modificarea a fost realizata cu success!');

    // User log
    dbLog($table, ADMIN_ACTION_STATUS, true, $data);

    return true;
}

/**
 * Create redirect from old link to new link, with some integrity check-ups:
 * - $newLink and $oldLink are identical
 * - there is more than one redirect that uses $newLink and $oldLink
 * - there is already a redirect that points to $oldLink and could not be deleted
 * - there is already a redirect that points to $newLink
 *
 * @param string $newLink New link, ideally relative
 * @param string $oldLink Old link, ideally relative
 * @param int $entityType Entity type as defined in constants (ENTITY_PAGE, etc.)
 * @param int $redirectType HTTP redirect type. Defaults to 301
 * @return bool True on success, false on failure. On success / failure, also sets alerts
 */
function dbRedirectAdd(string $newLink, string $oldLink, int $entityType, int $redirectType = 301): bool
{
    $success = false;
    $redirectExists = false;
    $tableRedirects = 'cms_redirects';

    // Links are the identical
    if ($oldLink == $newLink) {
        alertsAdd(
            'Redirect-ul nu fost creat deoarece URL-urile sunt identice!',
            'info'
        );
    } else {
        // Search for existing redirect
        $oldRedirect = dbSelect(
            '*',
            $tableRedirects,
            'url_from = ' . dbEscape($newLink) . ' OR url_from = ' . dbEscape($oldLink)
        );

        if ($oldRedirect) {
            if (count($oldRedirect) > 1) {
                $redirectExists = true;
            } else {
                if ($oldRedirect[0]['url_to'] == $oldLink) {
                    if (dbDelete($tableRedirects, ['id' => $oldRedirect[0]['id']]) === false) {
                        $redirectExists = true;
                    }
                } else {
                    $redirectExists = true;
                }
            }
        }

        if (!$redirectExists) {
            $r = dbInsert($tableRedirects, array(
                'url_from' => $oldLink,
                'url_to' => $newLink,
                'redirect_type' => $redirectType,
                'status' => 1
            ));

            if ($r === false) {
                alertsAdd('Redirect-ul nu au putut fi creat!', 'error');
            } else {
                // Add success flag
                $success = true;

                // Update $dbRedirects array
                updateDbRedirects();

                // Show alert
                alertsAdd('Redirect-ul a fost creat cu success!');

                // Save user action
                userActionText(
                    $_POST['id'],
                    $entityType,
                    MESSAGE_REDIRECT,
                    $oldLink . ' > ' . $newLink
                );
            }
        } else {
            alertsAdd(
                'Redirect-ul nu a fost creat deoarece exista deja un redirect similar. 
                Operatiunea trebuie efectuata manual.',
                'warning'
            );
        }
    }

    return $success;
}

/**
 * Check for existing rows in table before delete
 * The SQL where condition has the format of $fld = $id
 *
 * @param string $table Table in database
 * @param string $fld Field name in table
 * @param int $id Value for $fld
 * @param string $where Additional where condition to check against
 * @param string $conn Database connection. Defaults to 'main'
 * @return bool Returns true if no rows are found, false otherwise
 */
function dbCheckDelete($table, $fld, $id, $where = '', $conn = 'main')
{
    $dbWhere = $fld . '=' . dbEscape($id);
    if ($where) {
        $dbWhere .= ' AND ' . $where;
    }
    $count = dbShiftKey(dbSelect('COUNT(id)', $table, $dbWhere, '', '', '', '', $conn));

    if ($count) {
        return false;
    } else {
        return true;
    }
}

/**
 * Reorder rows in table using order from client-side drag & drop
 *
 * @param string $table Table in database
 * @param array $sort Reordered array of row ids
 * @param string $ordField Order field in table
 * @param string $conn Database connection. Defaults to 'main'
 */
function dbSort($table, $sort, $ordField = 'ord', $conn = 'main')
{
    // Check user rights
    if (!userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI'])) {
        return false;
    }

    // Success for user log
    $success = true;

    $list = dbSelect('id, ' . $ordField, $table, 'id IN (' . dbEscapeIn($sort) . ')', $ordField . ' ASC');
    foreach ($list as $i => $row) {
        if ($sort[$i] != $row['id']) {
            $r = dbInsert($table, array('id' => $sort[$i], 'ord' => $row['ord']));

            if ($r === false) {
                $success = false;
            }
        }
    }

    // User log
    dbLog($table, ADMIN_ACTION_ORDER, $success);
}

/**
 * Get next order index
 *
 * @param string $table Table in database
 * @param string $where Additional where condition in SQL. Defaults to empty string
 * @param string $ordField Order field in table
 * @return int
 */
function dbOrderIndex($table, $where = '', $ordField = 'ord')
{
    return dbShiftKey(dbSelect("MAX({$ordField}) + 1", $table, $where));
}

/**
 * Construct SQL part for LIMIT using $_GET['page_nr'] as current pagination number
 *
 * @param int $nrOnPage Number of rows on page
 * @return string
 */
function dbLimit($nrOnPage)
{
    return (($_GET['page_nr'] - 1) * $nrOnPage) . ',' . $nrOnPage;
}

/**
 * Get list of rows & list of rows + children ids for each row
 * Use these as params for formSelectOptions()
 *
 * @param array $list List of all rows, indexed by row id
 * @param array $listChildren List of children for each row, indexed by row id
 * @param string $dbFields List of SELECT fields for heach row
 * @param string $dbTable SELECT table
 * @param string $dbWhere SELECT where condition
 * @param string $dbOrd SELECT ord condition
 * @param string $dbGroup SELECT group condition
 * @return void
 */
function dbGetWithChildren(
    array &$list,
    array &$listChildren,
    string $dbFields = 'id, parent_id, link_name, url_key',
    string $dbTable = 'cms_pages',
    string $dbWhere = '',
    string $dbOrd = 'ord ASC',
    string $dbGroup = ''
) {
    $list = dbSelect(
        $dbFields,
        $dbTable,
        $dbWhere,
        $dbOrd,
        $dbGroup
    );

    $listChildren = array();
    foreach ($list as $i => $row) {
        $listChildren[$row['parent_id']][] = $row;
    }
    $list = array_column($list, null, 'id');
}

/**
 * Log user action in database
 *
 * Action types are as follows:
 * - ADMIN_ACTION_CREATE
 * - ADMIN_ACTION_UPDATE
 * - ADMIN_ACTION_DELETE
 * - ADMIN_ACTION_STATUS
 * - ADMIN_ACTION_ORDER
 *
 * @param string $table Table that was actioned in database
 * @param int $type Action type
 * @param false $success True if action was successful, false otherwise. Defaults to false
 * @param array $data Array with details about action, has the following keys:<br>
 *                    - field: the field targeted by action<br>
 *                    - rows: number of rows affected by action (for delete)<br>
 *                    - where: SQL condition (for delete)<br>
 *                    - row: data for current row (for delete / insert / update)<br>
 *                    - row_old: data for old row (for update)<br>
 *                    Defaults to array()
 */
function dbLog($table, $type, $success = false, $data = array())
{
    dbInsert('back_users_log', array(
        'user_id' => userGet(),
        'user' => userGetInfo('email'),
        'table_' => $table,
        'type' => $type,
        'success' => $success,
        'metadata' => $data,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'date' => time(),
    ));
}

/**
 * Initialize orderable table
 *
 * @param string $tableId Id for HTML table
 */
function listSortable($tableId, $page = '')
{
    global $cfg__;

    $cfg__['varsGlobal']['initSortable'][] = [
        'table' => $tableId,
        'page' => $page
    ];
}

/**
 * Create a HTML link for a row, that is used when reordering a table initialized by listSortable() function
 *
 * @param array $row Data with 'id' key from database row
 * @param false $isDrag True if it will use drag and drop, false for simple arrow-links otherwise. Defaults to false
 * @param bool $isRows True for simple arrow-links, false for drag and drop. Defaults to true
 * @param string $dragKey Identifier for sortable table inside another sortable table.
 *                        Must be in the form of 'drag-{$tableId}', where $tableId param was used to initialize listSortable() function.
 *                        Defaults to empty string
 * @return string HTML code for link
 */
function listOrder($row, $isDrag = false, $isRows = true, $dragKey = '')
{
    global $curPage;

    // Check user rights
    if (!userGetRight(ADMIN_RIGHT_EDIT, $curPage)) {
        return '<i class="material-icons">swap_vert</i>';
    }

    $order = '';
    if ($isDrag) {
        $order = '<a href="#" class="text-secondary b_drag ' . $dragKey . '"><i class="material-icons">swap_vert</i></a>';
    }

    if ($isRows) {
        $order .= '<a href="' . $curPage . '&ord_id=' . $row['id'] . '&ord=up" class="b_up"><i class="material-icons">arrow_upward</i></a>
    <a href="' . $curPage . '&ord_id=' . $row['id'] . '&ord=down" class="b_down"><i class="material-icons">arrow_downward</i></a>';
    }

    return $order;
}

/**
 * Create a HTML status button using $curPage, that must be defined as a global variable
 *
 * @param array $row Data with 'id' key from database row
 * @param string $field Status field in table
 * @param array $options Array of possible states containing text and CSS class.
 *                       If not specified it will default to:
                            array(
                                '0' => array(
                                    'class' => 'text_rosu',
                                    'key' => 'Inactiv'
                                ),
                                '1' => array(
                                    'class' => 'text_verde',
                                    'key' => 'Activ'
                                )
                            )
 * @param false $noLink If set to true, button is read-only, and does not contain a link. If set to false, button will contain a link.
 *                      Defaults to false
 * @return string HTML code for button
 */
function listStatus($row, $field, $options = array(), $noLink = false)
{
    global $curPage;

    if (!$options) {
        $options = array(
            '0' => array(
                'class' => 'text-danger',
                'key' => 'Inactiv'
            ),
            '1' => array(
                'class' => 'text-success',
                'key' => 'Activ'
            )
        );
    }

    $class = $options[$row[$field]]['class'];
    $status = $options[$row[$field]]['key'];

    // Check user rights
    if (!$noLink && userGetRight(ADMIN_RIGHT_EDIT, $curPage)) {
        return '<a href="' . $curPage . '&set_' . $field . '=' . $row['id'] . backVar() . '" class="btn-status ' . $class . '">' . $status . '</a>';
    } else {
        return "<span class='{$class}'>{$status}</span>";
    }
}

/**
 * Create a HTML add button using $curPage, that must be defined as a global variable
 *
 * @return string HTML code for button
 */
function listAdd()
{
    global $curPage;

    // Check user rights
    if (userGetRight(ADMIN_RIGHT_ADD, $curPage)) {
        return '<a class="btn btn-success float-right btn-sm btn-list-add" href="' . $curPage . '.edit&edit=0' . backVar() . '"><i class="material-icons">add</i> Adauga</a>';
    }
}

/**
 * Create a HTML edit button using $curPage, that must be defined as a global variable
 *
 * @param array $row Data with 'id' key from database row
 * @return string HTML code for button
 */
function listEdit($row)
{
    global $curPage;

    // Check user rights
    if (userGetRight(ADMIN_RIGHT_EDIT, $curPage)) {
        return '<a class="btn btn-success btn-link" href="' . $curPage . '.edit&edit=' . $row['id'] . backVar() . '" title="Modifica"><i class="material-icons">edit</i></a>';
    } else {
        return '<a class="btn btn-success btn-link" href="' . $curPage . '.edit&edit=' . $row['id'] . backVar() . '" title="Vizualizeaza"><i class="material-icons">visibility</i></a>';
    }
}

/**
 * Create a HTML delete button using $curPage, that must be defined as a global variable
 *
 * @param array $row Data with 'id' key from database row
 * @return string HTML code for button
 */
function listDelete($row)
{
    global $curPage;

    // Check user rights
    if (userGetRight(ADMIN_RIGHT_DELETE, $curPage)) {
        return '<a class="btn btn-danger btn-link" href="' . $curPage . '&del=' . $row['id'] . backVar() . '&csrf=' . userCsrfToken() . '" title="Sterge" onclick="return confirm(\'Confirmati stergerea?\');"><i class="material-icons">close</i></a>';
    } else {
        return '';
    }
}

/**
 * Create a HTML export button using $curPage, that must be defined as a global variable
 *
 * @return string HTML code for button
 */
function listExport($text = 'Exporta')
{
    global $curPage;

    $_GET['backvar'] = str_replace('&backvar=', '', backVar());
    $filters = returnVar(false, array('page_nr'));
    unset($_GET['backvar']);

    return '<a class="btn btn-info btn-sm btn-list-export float-right" href="' . $curPage . '&export=1' . $filters . '"><i class="material-icons">cloud_download</i> &nbsp;' . $text . '<i></i></a>';
}

/**
 * Create a HTML print button using $curPage, that must be defined as a global variable
 *
 * @param string $text Button text
 * @param string $url Button url, defaults to empty string
 * @return string HTML code for button
 */
function listPrint($text = 'Printeaza', $url = '')
{
    global $curPage;

    if (!$url) {
        $url = $curPage . '&print=1';
    }

    $_GET['backvar'] = str_replace('&backvar=', '', backVar());
    $filters = returnVar(false, array('page_nr'));
    unset($_GET['backvar']);

    $url .= $filters;

    captureJavaScriptStart();
    echo parseView('@init.print');
    captureJavaScriptEnd();

    return '<a href="javascript: printPage(\'' . $url . '\')" class="b_print float-right"><i></i>' . $text . '</a>';
}

/**
 * Create HTML pagination using @ init.pagination template<br>
 * Global variables that will be used:
 * - $curPage: current page URL
 * - $listRows: total number of rows
 * - $nrOnPage: number of items on page
 * - $_GET['page_nr']: current pagination number
 *
 * @return string HTML code for pagination
 */
function listPages()
{
    global $curPage, $listRows, $nrOnPage;
    static $iInit;

    if (is_null($iInit)) {
        $iInit = 0;
    } else {
        $iInit++;
    }

    $pagination = '';
    if ($listRows > $nrOnPage) {
        $pages = ceil($listRows / $nrOnPage);
        $_GET['backvar'] = str_replace('&backvar=', '', backVar());
        $filters = returnVar(false, array('page_nr'));
        unset($_GET['backvar']);

        formSelect2(array(
            'id' => 'pagination' . $iInit,
            'options' => array(
                //'placeholder_text_single' => 'Selectati pagina',
                'width' => '70px',
                'allowClear' => ''
            )
        ));

        $paginationTemplate = '@init.pagination';

        parseVar('paginationLink', $curPage . $filters . '&page_nr=', $paginationTemplate);
        parseVar('listRows', $listRows, $paginationTemplate);
        parseVar('nrOnPage', $nrOnPage, $paginationTemplate);
        parseVar('pages', $pages, $paginationTemplate);
        parseVar('pageNr', $_GET['page_nr'], $paginationTemplate);
        parseVar('iInit', $iInit, $paginationTemplate);

        $pagination = parseView($paginationTemplate);
    }

    return $pagination;
}

/**
 * Show SEO health snippet for title and meta description
 *
 * @param array $row Data with 'site_title' and 'site_description' keys from database row
 * @return string HTML template with SEO health status as defined in '@list.seo' view
 */
function listSEO ($row = array())
{
    $view = '@list.seo';

    parseVar('row', $row, $view);

    return parseView($view);
}

/**
 * Create a HTML return button using $retPage, that must be defined as a global variable
 *
 * @return string HTML code for button
 */
function formReturn($anchor = '', $text = 'Inapoi la lista')
{
    global $retPage;

    return '<a class="btn btn-success btn-sm btn-form-return float-left" href="' . $retPage . returnVar() . $anchor . '"><i class="material-icons">arrow_back</i> ' . $text . '</a>';
}

/**
 * Create a HTML preview button
 *
 * @param string $link Preview link
 * @param bool $show If button should be generated or not
 * @param string $text Button text
 * @return string HTML code for button
 */
function formPreview($link, $show, $text = 'Previzualizare', $icon = 'visibility')
{
    if ($show) {
        return '<a class="btn btn-info btn-sm" href="' . $link . '" target="_blank"><i class="material-icons">' . $icon . '</i> ' . $text . '</a>';
    }
}

/**
 * Initialize WYSIWYG editor
 *
 * @param string $fieldId Id for HTML container
 * @param array $options
 * @param string $plugins
 * @param array|bool $templates
 * @return void
 */
function formEditor($fieldId, $options = array(), $plugins = '', $templates = [])
{
    global $cfg__;

    if ($templates === false) {
        $templates = [];
    } else {
        $templates = array_merge($cfg__['varsGlobal']['initEditorTemplates'], $templates);
    }

    $cfg__['varsGlobal']['initEditor'][] = [
        'fieldId' => $fieldId,
        'options' => $options,
        'plugins' => $plugins,
        'templates' => $templates
    ];
}

/**
 * Initialize date picker
 *
 * @param string $fieldId Id for HTML input element
 */
function formDatepicker($fieldId)
{
    global $cfg__;

    $cfg__['varsGlobal']['initDatepicker'][] = $fieldId;
}

/**
 * Initialize file upload
 *
 * @param array $fieldId Configuration array with the following keys:<br />
 *                       - fieldId (string): id for HTML input element<br />
 *                       - formId (string): id for HTML<br />
 *                       - formLabel (string): label for HTML input element (optional)<br />
 *                       - multi (bool): true if multiple files can be selected, false otherwise (optional)
 *                       - imagesUpload (array): configuration array for resize with the following keys:<br />
 *                            - dir (string): target directory under /public/uploads/<br />
 *                            - thumbs (array): list of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 */
function formUpload($fieldId)
{
    global $cfg__;

    $cfg__['varsGlobal']['initUploadify'][] = $fieldId;
}

/**
 * @param string $fieldId Field id for file upload as defined via formUpload() function
 * @return string HTML code for file upload
 */
function formUploadFile($fieldId = 'image')
{
    parseVar('fieldId', $fieldId, '@init.images');

    return parseView('@init.images');
}

/**
 * Resize uploaded image and associate it to an entity
 *
 * @param string $table Table to store image name for an entity
 * @param int $id Id of entity row
 * @param array $imagesUpload Configuration array for resize with the following keys:<br />
 *                            - dir: target directory under /public/uploads/<br />
 *                            - thumbs: array of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 * @param string $POSTKey Field name from $_POST, where session key is stored for upload data. Defaults to 'imageKey'
 * @param string $tableKey Field name to store image name inside $table. Defaults to 'image'<br />
 *                         If existent in the table schema, the following fields will also be populated:<br />
 *                         -  {$tableKey}_timestamp: Upload timestamp<br />
 *                         -  {$tableKey}_filename: Original name of the file<br />
 *                         -  {$tableKey}_file_ext: File extension<br />
 *                         -  {$tableKey}_filesize: File size<br />
 * @param bool $dbLog Log update to DB
 * @return string|false Return filename if file upload was successful, or false otherwise
 */
function formUploadResize($table, $id, $imagesUpload, $POSTKey = 'imageKey', $tableKey = 'image', $dbLog = true)
{
    global $cfg__;

    if ($_POST[$POSTKey]) {
        if (is_array(sessionGet($_POST[$POSTKey]))) {
            $file = sessionGet($_POST[$POSTKey]);
            sessionSet($_POST[$POSTKey], '');

            $fileParts = pathinfo($file['name']);
            $fileParts['extension'] = strtolower($fileParts['extension']);
            $fileName = sha1($id . serialize($imagesUpload)) . '.' . array_shift(explode('?', $fileParts['extension']));
            //$fileName = $id . '.' . $fileParts['extension'];
            $filePath = UPLOAD_PATH . $imagesUpload['dir'];
            $filePathOriginal = $filePath . '/original/';
            $fileOriginal = $filePathOriginal . $fileName;

            if (in_array($fileParts['extension'], $cfg__['varsGlobal']['extUploadify']['extensions'])) {
                if (!is_dir($filePath)) {
                    mkdir($filePath);
                }

                if (!is_dir($filePathOriginal)) {
                    mkdir($filePathOriginal);
                }

                if (rename($file['tmp_name'], $fileOriginal)) {
                    dbInsert($table, array(
                        'id' => $id,
                        $tableKey => $fileName,
                        $tableKey . '_timestamp' => time(),
                        $tableKey . '_filename' => $fileParts['filename'],
                        $tableKey . '_file_ext' => $fileParts['extension'],
                        $tableKey . '_filesize' => filesize($fileOriginal),
                        '_no_admin_log' => $dbLog ? '' : $cfg__['session'][$cfg__['session']['default']]
                    ));
                    $size = getimagesize($fileOriginal);

                    foreach ($imagesUpload['thumbs'] as $thumbDir => $thumb) {
                        if (!is_dir($filePath . '/' . $thumbDir)) {
                            mkdir($filePath . '/' . $thumbDir);
                        }

                        if (!$thumb[0]) {
                            $thumb[0] = 20000;
                        } elseif (!$thumb[1]) {
                            $thumb[1] = 20000;
                        } else {
                            $rW = $size[0] / $thumb[0];
                            $rH = $size[1] / $thumb[1];
                            if ($rW != $rH) {
                                if ($rW > $rH) {
                                    $thumb[0] = 20000;
                                } else {
                                    $thumb[1] = 20000;
                                }
                            }
                        }

                        $compress = 0;
                        if ($fileParts['extension'] == 'png') {
                            $compress = 9;
                        } elseif (in_array($fileParts['extension'], array('jpg', 'jpeg'))) {
                            $compress = 20;
                        } elseif($fileParts['extension'] == 'webp') {
                            $compress = 85;
                        }

                        if ($fileParts['extension'] != 'svg') {
                            __img_resize($fileOriginal, $filePath . '/' . $thumbDir . '/' . $fileName, $thumb[0],
                                $thumb[1], $compress);
                        } else {
                            copy($fileOriginal, $filePath . '/' . $thumbDir . '/' . $fileName);
                        }
                    }

                    return $fileName;
                }
            }
        }
    }

    return false;
}

/**
 * Crop image after module was initialized using formUploadDelete() function
 *
 * @param array $imagesUpload Configuration array for resize with the following keys:<br />
 *                            - dir: target directory under /public/uploads/<br />
 *                            - thumbs: array of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 * @param string $image Image name
 * @param string $POSTKey Field name from $_POST, where session key is stored for upload data. Defaults to 'imageKey'
 */
function formUploadCrop($imagesUpload, $image, $POSTKey = 'imageKey', $table = '', $id = '', $tableKey = 'image', $dbLog = true)
{
    global $cfg__;

    if (!$_POST[$POSTKey]
        && ($_GET['upload']
            || !$imagesUpload['cropIsOptional']
            || ($imagesUpload['cropIsOptional'] && $_POST['crop_' . $imagesUpload['dir']]))
    ) {
        foreach ($imagesUpload['thumbs'] as $thumbDir => $thumb) {
            if ($_POST[$imagesUpload['dir'] . '_' . $thumbDir . '_' . md5($image) . '_w']) {
                $isCrop = true;
                $file = UPLOAD_PATH . $imagesUpload['dir'] . '/' . $thumbDir . '/' . $image;

                __img_crop(
                    $file,
                    $file,
                    $_POST[$imagesUpload['dir'] . '_' . $thumbDir . '_' . md5($image) . '_x'],
                    $_POST[$imagesUpload['dir'] . '_' . $thumbDir . '_' . md5($image)  . '_y'],
                    $_POST[$imagesUpload['dir'] . '_' . $thumbDir . '_' . md5($image) . '_w'],
                    $_POST[$imagesUpload['dir'] . '_' . $thumbDir . '_' . md5($image) . '_h']
                );
            }
        }

        if ($isCrop && $table && $id) {
            dbInsert($table, [
                'id' => $id,
                $tableKey . '_timestamp' => time(),
                '_no_admin_log' => $dbLog ? '' : $cfg__['session'][$cfg__['session']['default']]
            ]);
            dbInsert($table, array('id' => $id, $tableKey => $image));
        }
    }
}

/**
 * Add centered watermark on image
 *
 * @param string $image Image name
 * @param string $imageWatermark Full path to watermark image
 * @param array $imagesUpload Configuration array for image sizes with the following keys:<br />
 *                            - dir: target directory under /public/uploads/<br />
 *                            - thumbs: array of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 * @param array $imagesTarget Configuration array for new image location (optional), with the following keys:<br />
 *                            - dir: target directory under /public/uploads/<br />
 *                            - thumbs: array of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 *                            Defaults to array()
 */
function formUploadAddWatermark($image, $imageWatermark, $imagesUpload, $imagesTarget = array())
{
    try {
        // Check if watermark image exists
        if (!is_file($imageWatermark)) {
            throw new Exception("Nu a fost gasit un watermark '{$imageWatermark}'.");
        }

        // Counter in order to match thumbDir in $imagesUpload with the one in $imagesTarget
        $i = 0;

        // Go through thumbs and apply watermark
        foreach ($imagesUpload['thumbs'] as $thumbDir => $thumb) {

            // Image source
            $imageSource = UPLOAD_PATH . $imagesUpload['dir'] . '/' . $thumbDir . '/' . $image;

            // Image target
            $imageTarget = $imageSource;
            if ($imagesTarget['thumbs'][$i]) {
                $imageTarget = UPLOAD_PATH . $imagesTarget['dir'] . '/' . $imagesTarget['thumbs'][$i] . '/' . $image;
            }

            // Verify if source file exists
            if (!is_file($imageSource)) {
                throw new Exception("Nu a fost gasit fisierul sursa '{$imageSource}'.");
            }

            $old_size = getimagesize($imageSource);
            $water_size = getimagesize($imageWatermark);

            $old = imagecreatefromjpeg($imageSource);

            if (!$old) {
                throw new Exception("Nu a putut fi creat fisierul intermediar vechi din '{$imageSource}'.");
            }

            if ($water_size['mime'] == 'image/png') {
                $water = imagecreatefrompng($imageWatermark);
            } elseif ($water_size['mime'] == 'image/gif') {
                $water = imagecreatefromgif($imageWatermark);
            } elseif ($water_size['mime'] == 'image/jpeg') {
                $water = imagecreatefromjpeg($imageWatermark);
            }

            if (!$water) {
                throw new Exception("Nu a putut fi creat fisierul intermediar watermerk '{$imageWatermark}'.");
            }

            $new = imagecreatetruecolor($old_size[0], $old_size[1]);

            if (!$new) {
                throw new Exception("Nu a putut fi creat fisierul intermediar nou pentru '{$imageSource}'.");
            }

            if (
                !imagecopyresized($new, $old, 0, 0, 0, 0, $old_size[0], $old_size[1], $old_size[0], $old_size[1]) ||
                !imagecopy($new, $water, round(($old_size[0] - $water_size[0]) / 2),
                    round(($old_size[1] - $water_size[1]) / 2), 0, 0, $water_size[0], $water_size[1])
            ) {
                throw new Exception("Nu a putut fi aplicat watermark-ul pentru '{$imageSource}'.");
            }

            if ($old_size['mime'] == 'image/png') {
                $finalFile = imagepng($new, $imageTarget, 9);
            } elseif ($old_size['mime'] == 'image/gif') {
                $finalFile = imagegif($new, $imageTarget);
            } elseif ($old_size['mime'] == 'image/jpeg') {
                $finalFile = imagejpeg($new, $imageTarget, 75);
            }

            if (!$finalFile) {
                throw new Exception("Nu a putut fi creat fisierul destinatie '{$imagesTarget}'.");
            }

            chmod($imageTarget, 0777);

            $i++;
        }
    } catch (Exception $e) {
        alertsAdd($e->getMessage(), 'error', getPage());
    }
}

/**
 * Initialize crop for existing image
 *
 * @param array $imagesUpload Configuration array for resize with the following keys:<br />
 *                            - dir: target directory under /public/uploads/<br />
 *                            - thumbs: array of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 * @param string $POSTKey Field name from $_POST, where image name is stored. Defaults to 'image'
 * @param bool $alert Show warning message if the image needs cropping
 */
function formUploadCropInit($imagesUpload, $POSTKey = 'image', $alert = true)
{
    if (!userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI'])) {
        return false;
    }

    $initJcrop = getVar('initJcrop');
    if (!$initJcrop) {
        $initJcrop = array();
    }

    $basePath = UPLOAD_PATH . $imagesUpload['dir'] . '/';
    foreach ($imagesUpload['thumbs'] as $thumbDir => $thumb) {
        if (count($thumb) == 2 && $thumb[0] && $thumb[1] && file_exists($basePath . $thumbDir . '/' . $_POST[$POSTKey])) {
            $size = getimagesize($basePath . $thumbDir . '/' . $_POST[$POSTKey]);
            if (($size[0] > $thumb[0] || $size[1] > $thumb[1]) && !($size[0] < $thumb[0]) && !($size[1] < $thumb[1])) {
                $x = $y = 0;
                if ($size[0] > $thumb[0]) {
                    $x = floor(($size[0] - $thumb[0]) / 2);
                } elseif ($size[1] > $thumb[1]) {
                    $y = floor(($size[1] - $thumb[1]) / 2);
                }

                $initJcrop[] = array(
                    'parent_dir' => $imagesUpload['dir'],
                    'dir' => $thumbDir,
                    'w' => $thumb[0],
                    'h' => $thumb[1],
                    'x' => $x,
                    'y' => $y,
                    'image' => $_POST[$POSTKey]
                );
            }
        }
    }

    if ($initJcrop && $alert) {
        alertsAdd('Imaginea necesita crop. Pentru a efectua aceasta operatiune <a href="#crop_dialog_' . $imagesUpload['dir'] . '" class="crop-dialog-scroll"><u>click aici</u></a> si apoi click pe butonul "Salveaza".', 'warning');
    }

    parseVar('initJcrop', $initJcrop);
}

/**
 * Delete and image associated to an entity
 *
 * @param array $imagesUpload Configuration array for resize with the following keys:<br />
 *                            - dir: target directory under /public/uploads/<br />
 *                            - thumbs: array of thumbs with key as target subdirectory and value as
 *                              array with two values as width and height
 * @param string $table Table that stores image name for an entity
 * @param int $id Id of entity row
 * @param string $imageKey Field name to store image name inside $table. Defaults to 'image'
 */
function formUploadDelete($imagesUpload, $table, $id, $imageKey = 'image')
{
    // Check user rights
    if (!userGetRight(ADMIN_RIGHT_DELETE, $_SERVER['REQUEST_URI'])) {
        return false;
    }

    $image = dbShiftKey(dbSelect($imageKey, $table, 'id = ' . dbEscape($id)));
    if (!is_array($image) && strlen($image)) {
        if (file_exists(UPLOAD_PATH . $imagesUpload['dir'] . '/original/' . $image)) {
            unlink(UPLOAD_PATH . $imagesUpload['dir'] . '/original/' . $image);
        }

        foreach ($imagesUpload['thumbs'] as $thumbDir => $thumb) {
            if (file_exists(UPLOAD_PATH . $imagesUpload['dir'] . '/' . $thumbDir . '/' . $image)) {
                unlink(UPLOAD_PATH . $imagesUpload['dir'] . '/' . $thumbDir . '/' . $image);
            }
        }
    }
}

/**
 * Redirect page after form submit
 *
 * If (bool)$_POST['formRedirect'] is true, target page will be $retPage and with filters from returnVar()
 * If (bool)$_POST['formRedirect'] is false, target page will be {$retPage}.edit with query params edit={$id}, and backvar for filters
 *
 * @param string $retPage URL of target page
 * @param int $id Id of row to edit
 */
function formRedirect($retPage, $id, $anchor = '')
{
    if ($_POST['formRedirect']) {
        redirectURL($retPage . returnVar() . $anchor);
    } else {
        $query = [
            'edit' => $id
        ];

        if ($_GET['backvar']) {
            $query['backvar'] = fixVar($_GET['backvar']);
        }

        if ($_GET['datatable']) {
            $query['datatable'] = $_GET['datatable'];
        }

        redirectURL($retPage . '.edit&' . http_build_query($query) . $anchor);
    }
}

/**
 * Generate encoded query param 'backvar' for active $_GET filters
 * The following query params are excluded: page, edit, ajax, ord, ord_id, back_var
 * To restore filters as individual query params, returnVar() function is used
 *
 * @return string Query param '&backvar={encodedFilters}'
 */
function backVar()
{
    $bk = array_filter($_GET, function($key) {
        return !in_array(
            $key,
            array('page', 'edit', 'ajax', 'ord', 'ord_id', 'back_var', 'alerts', 'datatable', 'csrf')
        );
    }, ARRAY_FILTER_USE_KEY);

    array_walk_recursive($bk, function (&$item, $key) {
        $item = stripslashes($item);
    });

    return '&backvar=' . urlencode(serialize($bk));
}

/**
 * Restore filters as individual query params from $_GET['backvar']
 *
 * @param bool $isAjax True if inside AJAX call, false otherwise. Defaults to false
 * @param array $exclude Array of keys to exclude from query params. Defaults to array()
 * @return string Query params separated and preceded by '&'
 */
function returnVar($isAjax = false, $exclude = array())
{
    $lnk = [];

    if ($_GET['backvar']) {
        $re = urldecode($_GET['backvar']);

        if (get_magic_quotes_gpc()) {
            $re = stripslashes($re);
        }

        $re = unserialize($re, ['allowed_classes' => false]);
        if ($re) {
            foreach ($re as $key => $val) {
                if (!in_array($key, $exclude)) {
                    $lnk[$key] = $val;
                    if ($isAjax) {
                        $_GET[$key] = urlencode($val);
                    }
                }
            }
        }

        if ($isAjax) {
            unset($_GET['backvar']);
        }
    }

    if ($_GET['datatable']) {
        $lnk['datatable'] = $_GET['datatable'];
    }

    return '&' . http_build_query($lnk);
}

/**
 * Re-encode 'backvar' query param after form submit
 *
 * @param string $var Current value to re-encode
 * @return string Value for query param
 */
function fixVar($var)
{
    $var = urldecode($var);
    if (get_magic_quotes_gpc()) {
        $var = stripslashes($var);
    }
    $var = unserialize($var, ['allowed_classes' => false]);
    $var = urlencode(serialize($var));

    return $var;
}

/**
 * Export data as .csv (does not add HTTP headers)
 *
 * @param array $header Column headers with key for column in each $list row and text as column title
 * @param array $list List of rows, each row with keys as defined in header for each column
 * @return string
 */
function printCSV($header, $list = array())
{
    ob_start();
    $df = fopen("php://output", 'w');

    // Add header
    fputcsv($df, $header);

    // Add rows from list
    foreach ($list as $row) {
        $csvRow = [];
        foreach ($header as $key => $val) {
            $csvRow[] = $row[$key];
        }

        fputcsv($df, $csvRow);
    }

    fclose($df);
    return ob_get_clean();
}

/**
 * Set custom error handler using set_error_handler(), usually before using file_get_contents() function
 *
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 * @throws Exception
 */
function warningHandler($errno, $errstr, $errfile, $errline)
{
    throw new Exception($errstr . "[File: {$errfile}:{$errline}]", $errno);
}

/* Image functions */

/**
 * Resize image helper used in formUploadResize() function
 *
 * @param $sourcefile
 * @param $destfile
 * @param $forcedwidth
 * @param $forcedheight
 * @param int $imgcomp
 * @return bool|string
 */
function __img_resize($sourcefile, $destfile, $forcedwidth, $forcedheight, $imgcomp = 0)
{
    global $cfg__;

    if (!$sourcefile) {
        return false;
    }
    $g_imgcomp = 100 - $imgcomp;
    $g_srcfile = $sourcefile;
    $g_dstfile = $destfile;
    $g_fw = $forcedwidth;
    $g_fh = $forcedheight;
    $g_type = "";
    if (strpos($g_srcfile, ".jpg")) {
        $g_type = "jpg";
    } elseif (strpos($g_srcfile, ".jpeg")) {
        $g_type = "jpg";
    } elseif (strpos($g_srcfile, ".gif")) {
        $g_type = "gif";
    } elseif (strpos($g_srcfile, ".png")) {
        $g_type = "png";
    } elseif (strpos($g_srcfile, ".webp")) {
        $g_type = "webp";
    } elseif (strpos($g_srcfile, ".JPG")) {
        $g_type = "jpg";
    } elseif (strpos($g_srcfile, ".JPEG")) {
        $g_type = "jpg";
    } elseif (strpos($g_srcfile, ".GIF")) {
        $g_type = "gif";
    } elseif (strpos($g_srcfile, ".PNG")) {
        $g_type = "png";
    } elseif (strpos($g_srcfile, ".WEBP")) {
        $g_type = "webp";
    } else {
        return "invalid file type!" . $sourcefile;
    }

    if (file_exists($g_srcfile)) {
        $g_is = getimagesize($g_srcfile);
        if (($g_is[0] - $g_fw) >= ($g_is[1] - $g_fh)) {
            $g_iw = $g_fw;
            $g_ih = ($g_fw / $g_is[0]) * $g_is[1];
        } else {
            $g_ih = $g_fh;
            $g_iw = ($g_ih / $g_is[1]) * $g_is[0];
        }

        if ($g_type == "jpg") {
            $img_src = @imagecreatefromjpeg($g_srcfile);
        }
        if ($g_type == "gif") {
            $img_src = @imagecreatefromgif($g_srcfile);
        }
        if ($g_type == "png") {
            $img_src = @imagecreatefrompng($g_srcfile);
        }
        if ($g_type == "webp") {
            $img_src = @imagecreatefromwebp($g_srcfile);
        }
        if (!$img_src) {
            @imagedestroy($img_src);
            @imagedestroy($img_dst);
            return false;
        }

        /* Script updates */
        $img_dst = imagecreatetruecolor($g_iw, $g_ih);

        // preserve transparency
        if ($g_type == "gif" || $g_type == "png" || $g_type == "webp") {
            imagecolortransparent($img_dst, imagecolorallocatealpha($img_dst, 0, 0, 0, 127));
            imagealphablending($img_dst, false);
            imagesavealpha($img_dst, true);
        }

        imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $g_iw, $g_ih, $g_is[0], $g_is[1]);
        /* Script updates (end) */

        /* Old script */
        /*if ($g_type=="gif") {
                $img_dst=imagecreate($g_iw,$g_ih);

                imagecopyresized($img_dst, $img_src, 0, 0, 0, 0, $g_iw, $g_ih, $g_is[0], $g_is[1]);
        } else {
                $img_dst=imagecreatetruecolor($g_iw,$g_ih);

                imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $g_iw, $g_ih, $g_is[0], $g_is[1]);
        }*/
        /* Old script (end) */

        // Orientation
        if (!$cfg__['debug']['on']) {
            $exif = @exif_read_data($sourcefile);
        } else {
            $exif = exif_read_data($sourcefile);
        }

        switch($exif['Orientation']) {
            /*case 2: // horizontal flip
                $image->flipImage($public,1);
                break;*/

            case 3: // 180 rotate left
                $img_dst = imagerotate($img_dst, 180, 0);
                break;

            /*case 4: // vertical flip
                $image->flipImage($public,2);
                break;

            case 5: // vertical flip + 90 rotate right
                $image->flipImage($public, 2);
                imagerotate($public, -90, 0);
                break;*/

            case 6: // 90 rotate right
                $img_dst = imagerotate($img_dst, -90, 0);
                break;

            /*case 7: // horizontal flip + 90 rotate right
                $image->flipImage($public,1);
                $image->rotateImage($public, -90);
                break;*/

            case 8:    // 90 rotate left
                $img_dst = imagerotate($img_dst, 90, 0);
                break;

            default:
                break;
        }

        if ($g_type == "jpg") {
            imagejpeg($img_dst, $g_dstfile, $g_imgcomp);
        }
        if ($g_type == "gif") {
            imagegif($img_dst, $g_dstfile);
        }
        if ($g_type == "png") {
            if ($imgcomp) {
                imagepng($img_dst, $g_dstfile, $imgcomp);
            } else {
                imagepng($img_dst, $g_dstfile);
            }
        }
        if ($g_type=="webp")  {
            if($imgcomp) {
                imagewebp($img_dst, $g_dstfile, $imgcomp);
            } else {
                imagewebp($img_dst, $g_dstfile);
            }
        }
        @imagedestroy($img_src);
        @imagedestroy($img_dst);
        return true;
    } else {
        @imagedestroy($img_src);
        @imagedestroy($img_dst);
        return false;
    }
}

/**
 * Crop image helper used in formUploadCrop() function
 *
 * @param $src
 * @param $dst
 * @param $x
 * @param $y
 * @param $w
 * @param $h
 * @return bool|string
 */
function __img_crop($src, $dst, $x, $y, $w, $h)
{
    $g_type = "";
    if (strpos($src, ".jpg")) {
        $g_type = "jpg";
    } elseif (strpos($src, ".jpeg")) {
        $g_type = "jpg";
    } elseif (strpos($src, ".gif")) {
        $g_type = "gif";
    } elseif (strpos($src, ".png")) {
        $g_type = "png";
    } elseif (strpos($src, ".webp")) {
        $g_type = "webp";
    } elseif (strpos($src, ".JPG")) {
        $g_type = "jpg";
    } elseif (strpos($src, ".JPEG")) {
        $g_type = "jpg";
    } elseif (strpos($src, ".GIF")) {
        $g_type = "gif";
    } elseif (strpos($src, ".PNG")) {
        $g_type = "png";
    } elseif (strpos($src, ".WEBP")) {
        $g_type = "webp";
    } else {
        return "invalid file type!" . $src;
    }

    if (file_exists($src)) {
        $g_is = getimagesize($src);

        //SOURCE RESOURCE (img_src)
        if ($g_type == "jpg") {
            $img_src = imagecreatefromjpeg($src);
        }
        if ($g_type == "gif") {
            $img_src = imagecreatefromgif($src);
        }
        if ($g_type == "png") {
            $img_src = imagecreatefrompng($src);
        }
        if ($g_type == "webp") {
            $img_src = imagecreatefromwebp($src);
        }

        /* Script updates */
        $img_dst = imagecreatetruecolor($w, $h);

        // preserve transparency
        if ($g_type == "gif" || $g_type == "png" || $g_type == "webp") {
            imagecolortransparent($img_dst, imagecolorallocatealpha($img_dst, 0, 0, 0, 127));
            imagealphablending($img_dst, false);
            imagesavealpha($img_dst, true);
        }

        imagecopyresampled($img_dst, $img_src, 0, 0, $x, $y, $w, $h, $w, $h);
        /* Script updates (end) */

        /* Old script */
        //DESTINATION RESOURCE (img_dst)
        /*if ($g_type=="gif")
                $img_dst=imagecreate($w,$h);
        else
                $img_dst=imagecreatetruecolor($w,$h);

             imagecopyresized($img_dst, $img_src, 0, 0, $x, $y, $w, $h, $w, $h);*/
        /* Old script (end) */

        if ($g_type == "jpg") {
            imagejpeg($img_dst, $dst, 80);
        }
        if ($g_type == "gif") {
            imagegif($img_dst, $dst);
        }
        if ($g_type == "png") {
            imagepng($img_dst, $dst, 9);
        }
        if ($g_type == "webp") {
            imagewebp($img_dst, $dst, 85);
        }
        imagedestroy($img_dst);
        return true;
    } else {
        return false;
    }
}

/**
 * Get human readable size of file
 *
 * @param int $bytes Size in bytes
 * @param int $decimals Number of decimals to be used in human readable size. Defaults to 2
 * @return string Human readable size
 */
function filesizeHuman($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

/* Image functions (end) */

/* Util functions */

/**
 * Write redirects from DB table cms_redirects to /config/db.redirects.php
 *
 * @return void
 */
function updateDbRedirects()
{
    $redirects = array();
    $urlsDb = dbSelect('*', 'cms_redirects', 'status = 1');

    foreach ($urlsDb as $row) {
        if (strpos($row['url_from'], '#') !== false) {
            $redirects['flexible'][str_replace('#', '', $row['url_from'])] = $row;
        } else {
            $redirects['normal'][$row['url_from']] = $row;
        }
    }

    $export = '<? $dbRedirects = ' . var_export($redirects, true) . '; ?>';
    $result = file_put_contents(PLATFORM_PATH . '/config/db.redirects.php', $export);

    // Notifications
    if ($result === false) {
        alertsAdd('Noile redirecturi nu au putut fi generate!', 'error');
    } else {
        alertsAdd('Noile redirecturi au fost generate cu success!');
    }
}

/**
 * Update rows counter for list
 *
 * @param int $parentId
 * @param string $childTable
 * @param string $parentTable
 * @param string $parentKey
 * @param string $counterKey
 * @return void
 */
function updateListCounter(
    int    $parentId,
    string $childTable = 'cms_list_row',
    string $parentTable = 'cms_list',
    string $parentKey = 'list_id',
    string $counterKey = 'row_count'
)
{
    $counter = dbShift(dbSelect(
        'COUNT(id) AS count',
        $childTable,
        "{$parentKey} = " . dbEscape($parentId)
    ));

    $r = dbInsert($parentTable, array(
        'id' => $parentId,
        $counterKey => (int)$counter['count']
    ));

    if ($r === FALSE) {
        alertsAdd('Counter-ul nu a putut fi modificat.', 'error');
    }
}

/**
 * Add entity-block relations and log action to entity
 *
 * @param int $entityType Entity type, from constants
 * @param int $entityId Entity id
 * @param string $html HTML that may contain entity blocks
 * @return bool True on success, false otherwise
 */
function entityAddBlocks($entityType, $entityId, $html)
{
    // Get modules
    $modules = entityFromHtml($html);

    // Get current relations
    $modulesOld = entityGetRelations($entityType, $entityId);

    // Delete current relations
    $success = entityDeleteRelations($entityType, $entityId);

    if ($success) {
        // Add new relations
        $success = entityAddRelations($entityType, $entityId, $modules);

        // Log actions
        if ($success) {
            $data = $dataOld = $entitiesById = [];

            foreach (ENTITY_MODULES_TABLES as $moduleType => $moduleTable) {
                $data['relation_' . $moduleType] = $modules[$moduleType] ?: [];
                $dataOld['relation_' . $moduleType] = $modulesOld[$moduleType] ?: [];
                $entitiesById['relation_' . $moduleType] = array_column(
                    dbSelect('id, title', $moduleTable),
                    'title',
                    'id'
                );
            }

            userAction($entityId, $entityType, $data, $dataOld, $entitiesById);
        }
    }

    return $success;
}

/**
 * Remove entity-block relation and log action to entity
 *
 * @param int $moduleType Module type (from entity constants)
 * @param int $moduleId Module id
 * @return bool True on success, false otherwise
 */
function entityRemoveBlocks($moduleType, $moduleId)
{
    // Success flag
    $success = true;

    // Get current relations
    $entities = entityGetModuleRelations($moduleType, $moduleId);

    // Delete module form each entity and log action
    foreach ($entities as $entityType => $entityIds) {
        if ($entityIds) {
            $entitiesDB = dbSelect(
                'id, text',
                ENTITY_MAIN_TABLES[$entityType],
                'id IN (' . dbEscapeIn($entityIds) . ')'
            );

            foreach ($entitiesDB as $entity) {
                // Delete module from HTML
                $html = entityDeleteFromHtml($moduleType, $moduleId, $entity['text']);

                if ($html !== false) {
                    // Save new HTML
                    $r = dbInsert(
                        ENTITY_MAIN_TABLES[$entityType],
                        [
                            'id' => $entity['id'],
                            'text' => $html
                        ]
                    );

                    if ($r !== false) {
                        // Log action
                        userAction(
                            $entity['id'],
                            $entityType,
                            ['text' => $html],
                            ['text' => $entity['text']]
                        );

                        // Associate current content blocks as entities
                        $r = entityAddBlocks($entityType, $entity['id'], $html);
                    }

                    $success = $success && $r;
                } else {
                    $success = false;
                }
            }
        }
    }

    return $success;
}

/**
 * Get entity blocks (types & ids)
 *
 * @param string $html HTML that may contain entity blocks
 * @return array Array of modules with keys as entity types (from constants) and array of module ids as values
 */
function entityFromHtml($html)
{
    // List of found entities
    $modules = [];

    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?><html><body>' . $html . '</body></html>', LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($doc);

    // Search for pattern
    // <p contenteditable="false" draggable="true" data-cmsblocks="1" data-type="{type}" data-id="{id}">{title}</p>
    foreach ($xpath->query("//p[contains(@data-cmsblocks, '1')]") as $block) {
        $modules[$block->getAttribute('data-type')][] = $block->getAttribute('data-id');
    }

    return $modules;
}

/**
 * Remove specified entity block
 *
 * @param int $moduleType Module type (from entity constants)
 * @param int $moduleId Module id
 * @param string $html HTML that may contain entity blocks
 * @return bool|string HTML without specified block or false on failure
 */
function entityDeleteFromHtml($moduleType, $moduleId, $html)
{
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?><html><body>' . $html . '</body></html>', LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($doc);

    // Search for pattern
    // <p contenteditable="false" draggable="true" data-cmsblocks="1" data-type="{type}" data-id="{id}">{title}</p>
    foreach ($xpath->query("//p[contains(@data-cmsblocks, '1')]") as $block) {
        if (
            $block->getAttribute('data-type') == $moduleType
            && $block->getAttribute('data-id') == $moduleId
        ) {
            $block->parentNode->removeChild($block);
        }
    }

    $newHtml = $doc->saveHTML();

    if ($newHtml !== false) {
        $newHtml = str_replace(
            ['<?xml encoding="utf-8" ?><html><body>', '</body></html>'],
            '',
            $newHtml
        );
    } else {
        $newHtml = $html;
    }

    return $newHtml;
}

/**
 * Get current entity-block relations
 *
 * @param int $moduleType Module type (from entity constants)
 * @param int $moduleId Module id
 * @return array Array of modules with keys as entity types (from constants) and array of entity ids as values
 */
function entityGetModuleRelations($moduleType, $moduleId)
{
    // List of associated entities by type
    $entities = [];

    // List of associated modules from DB
    $entitiesDB = dbSelect(
        '*',
        'cms_relation',
        'module = ' . dbEscape($moduleType) . ' AND module_id = ' . dbEscape($moduleId)
    );

    // Extract modules ids
    foreach (ENTITY_MAIN_TABLES as $entityType => $entityTable) {
        $entities[$entityType] = array_column(
            array_filter($entitiesDB, function($row) use ($entityType) {
                return $row['entity'] == $entityType;
            }),
            'entity_id'
        );
    }

    return $entities;
}

/**
 * Add entity relation
 *
 * @param int $entityType Entity type, from constants
 * @param int $entityId Entity id
 * @param array $modules Array of modules with 'module' (entity type, from constants) and 'module_id' as keys
 * @return bool True on success, false otherwise
 */
function entityAddRelations($entityType, $entityId, $modules)
{
    // Success flag
    $success = true;

    // Save module - entity relation
    foreach ($modules as $moduleType => $moduleIds) {
        foreach ($moduleIds as $id) {
            $r = dbInsert('cms_relation', [
                'entity' => $entityType,
                'entity_id' => $entityId,
                'module' => $moduleType,
                'module_id' => $id
            ]);

            $success = $success && $r;
        }
    }

    return $success;
}

/**
 * Delete entity relation
 *
 * @param int $entityType Entity type, from constants. Defaults to null
 * @param int $entityId Entity id. Defaults to null
 * @param int $moduleType Filter delete by module type (from entity constants). Defaults to null
 * @param int $moduleId Filter delete by module id. Defaults to null
 * @return bool True on success, false otherwise
 */
function entityDeleteRelations($entityType = null, $entityId = null, $moduleType = null, $moduleId = null)
{
    // Delete params
    $deleteParams = [];

    if ($entityType) {
        $deleteParams['entity'] = $entityType;
    }

    if ($entityId) {
        $deleteParams['entity_id'] = $entityId;
    }

    if ($moduleType) {
        $deleteParams['module'] = $moduleType;
    }

    if ($moduleId) {
        $deleteParams['module_id'] = $moduleType;
    }

    // Delete previous module - entity relation
    if ($deleteParams) {
        $r = dbDelete('cms_relation', $deleteParams);
    }

    return (bool)$r;
}

/**
 * Get outbound links
 *
 * @param string $text HTML code
 * @param array $domains List of domains do be excluded from count. Defaults to empty array
 * @param bool $includeSocialMedia Include social media domains (youtube, facebook, instagram, twitter). Defaults to true
 * @return array Array with 'outbound' key that contains number of links, and 'outbound_links' key with list of links as array
 */
function getOutboundLinks($text, $domains = array(), $includeSocialMedia = true)
{
    $socialMedia = array(
        'youtube.com',
        'youtu.be',
        'youtube.ro',
        'facebook.com',
        'instagram.com',
        'twitter.com'
    );

    if (!$domains || !is_array($domains)) {
        $domains = array($_SERVER['SERVER_NAME']);
    }

    if ($includeSocialMedia) {
        $domains = array_merge($domains, $socialMedia);
    }

    $links = $outboundLinks = array();
    $nLinks = 0;

    preg_match_all('/<a\s[^>]*href\s*=\s*([\"\']??)(http[^\">]*?)\\1[^>]*>(.*)<\/a>/siU', $text, $links,
        PREG_SET_ORDER);
    foreach ($links as $link) {
        if (!preg_match_all('/.*rel\s*=\s*(\"|\')nofollow(\"|\').*/siU', $link[0], $m)) {
            if (!preg_match_all('/^(http|https):\/\/(www.)?(' . implode('|', $domains) . ').*$/siU', $link[2], $m)) {
                $outboundLinks[] = $link[2];
                $nLinks++;
            }
        }
    }

    return array(
        'outbound' => $nLinks,
        'outbound_links' => $outboundLinks
    );
}

/**
 * Normalize text in order to count words and spaces via countCharsDisplay() function
 *
 * @param string $text Text, can be HTML
 * @return string|string[]|null Normalized text
 */
function countChars($text)
{
    $text = htmlspecialchars_decode(htmlentities(strip_tags($text)));
    $text = str_replace('&nbsp;', ' ', $text);
    $text = str_replace('&Acirc;', ' ', $text);
    $tmpArray = explode("\n", $text);
    if(is_array($tmpArray))
    {
        foreach($tmpArray as $key=>$val)
        {
            $line = trim($val);
            if(!$line)
                unset($tmpArray[$key]);
            else
                $tmpArray[$key] = html_entity_decode($line);
        }
    }
    $result = implode(" ", $tmpArray);
    $result = str_replace("&#39;", "'", $result);
    $result = preg_replace('/\s+/', ' ', $result);

    return $result;
}

/**
 * Count number of chars or words in text
 *
 * @param string $text Text, can be HTML
 * @param string $type Type of counting. Can be 'chars' or 'chars_nospaces' or 'words'
 * @return int|string Number of chars or words
 */
function countCharsDisplay($text, $type = 'chars')
{
    $txt = countChars($text);
    switch($type)
    {
        case 'chars':
        default:
            $result = number_format(strlen($txt), 0, '.', '.');
            break;
        case 'chars_nospaces':
            $result = number_format(strlen(str_replace(' ', '', $txt)), 0, '.', '.');
            break;
        case 'words':
            $words = explode(' ', $txt);
            $result = count($words);
            break;
    }
    return $result;
}

/* Util functions (end) */


/**
 * Format number with two decimals
 *
 * @param string|int|float $number Original number
 * @return float Formatted number
 */
function stringToFloat($number, $decimals = 2)
{
    return (float)number_format((float)$number, $decimals, '.', '');
}
