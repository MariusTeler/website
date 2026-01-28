<?php
/**
 * PHP CMS Platform
 *
 * @category
 * @package
 * @copyright Horatiu Andrei (horatiu.andrei@gmail.com)
 */

/**
 * Parse all HTML code for current request
 *
 * @return string HTML code after parsing template
 */
function parseAll()
{
    global $cfg__, $timeStart__;

    $page = str_replace(['/', '..'], '', $_GET['page']);

    if (file_exists(PLATFORM_PAGES . 'pages/' . $page . '.php')) {
        setPage($page);
    }

    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN) {
        // Validate CSRF token for delete
        if (isset($_GET['del']) && !userCsrfValidate($_GET['csrf'])) {
            unset($_GET['del']);
            alertsAdd('Link-ul de stergere este invalid! Incercati din nou.', 'warning');
        }
    }

    parsePage(getPage());

    $html = parseView(getTemplate(), PLATFORM_PAGES . 'templates/');

    if ($cfg__['lazyLoad'] && PLATFORM_MODULE != PLATFORM_MODULE_ADMIN) {
        $html = lazyLoadImg($html);
    }

    if ($cfg__['compressHtml']) {
        $html = PHPWee\Minify::html($html);
    }

    echo $html;

    if ($cfg__['debug']['on'] && userGet($cfg__['session']['key_admin'])) {
        $timeEnd__ = microtime(true);
        echo '<div class="main-panel">';
        parseDebug($_GET, 'GET');
        echo array_pop($cfg__['debug']['mess']);
        echo implode('', $cfg__['debug']['mess']);
        echo '<center>Generated in: ' . round($timeEnd__ - $timeStart__, 4) . ' seconds.<br /> Memory used: ' .
            number_format((memory_get_peak_usage() / (1024 * 1024)), 3) . ' MB </center>';
        echo '</div>';
    }
}

/**
 * Parse page file
 *
 * @param string $p__ Page to be parsed (without extension)
 * @param string $path__ (optional) File path. If not specified defaults to pages/, relative to the current module
 */
function parsePage($p__, $path__ = '')
{
    global $cfg__, $websiteURL;

    if (!$path__) {
        $path__ = PLATFORM_PAGES . 'pages/';
    }

    $definedBefore__ = array_keys(get_defined_vars());

    ob_start();

    include($path__ . $p__ . '.php');
    if ($cfg__['debug']['on']) {
        parseDebug(ob_get_contents(), $p__);
    }

    ob_end_clean();

    $definedAfter__ = array_keys(get_defined_vars());
    unset($definedAfter__[array_search('definedBefore__', $definedAfter__)]);
    $definedDiff__ = array_diff($definedAfter__, $definedBefore__);
    foreach ($definedDiff__ as $var__) {
        $cfg__['vars'][$p__][$var__] = ${$var__};
    }
}

/**
 * Parse view file
 *
 * @param string $p__ Correspondent page name / View to be parsed, if stand-alone (without extension)
 * @param string $path__ (optional) File path. If not specified defaults to views/, relative to the current module
 * @return string HTML code after parsing
 */
function parseView($p__, $path__ = '')
{
    global $cfg__;

    if ($cfg__['vars'][$p__]) {
        foreach ($cfg__['vars'][$p__] as $varName__ => $varValue__) {
            ${$varName__} = $varValue__;
        }

        unset($cfg__['vars'][$p__]);
    }

    if ($cfg__['varsPage'][$p__]) {
        foreach ($cfg__['varsPage'][$p__] as $varName__ => $varValue__) {
            ${$varName__} = $varValue__;
        }

        if ($p__ != getPage()) {
            unset($cfg__['varsPage'][$p__]);
        }
    }

    foreach ($cfg__['varsGlobal'] as $varName__ => $varValue__) {
        ${$varName__} = $varValue__;
    }

    if ($view__ = getView($p__)) {
        unset($cfg__['parse']['view'][$p__]);

        $p__ = $view__['view'];
        $path__ = $view__['path'];
    }

    if (!$path__) {
        $path__ = PLATFORM_PAGES . 'views/';
    }

    ob_start();

    include($path__ . $p__ . '.php');
    $HTML__ = ob_get_contents();

    ob_end_clean();

    return $HTML__;
}

/**
 * Parse block (page file + view file)
 *
 * @param string $p Page to be parsed (without extension)
 * @param string $path__ (optional) File path. If not specified defaults to pages/ and views/, relative to the current module
 * @return string HTML code after parsing page and view
 */
function parseBlock($p, $path__ = '')
{
    parsePage($p, $path__ ? $path__ . 'pages/' : '');
    return parseView($p, $path__ ? $path__ . 'views/' : '');
}

/**
 * Start JavaScript code capture
 * To end code capture use captureJavaScriptEnd()
 * To output captured code use parseJavaScript()
 */
function captureJavaScriptStart()
{
    ob_start();
}

/**
 * End JavaScript code capture
 * To start code capture use captureJavaScriptStart()
 * To output captured code use parseJavaScript()
 */
function captureJavaScriptEnd()
{
    global $cfg__;

    $cfg__['parseJavaScript'] .= ob_get_contents();

    ob_end_clean();
}

/**
 * Output captured JavaScript code at desired location
 * To start code capture use captureJavaScriptStart()
 * To end code capture use captureJavaScriptEnd()
 *
 * @return string
 */
function parseJavaScript()
{
    global $cfg__;

    return $cfg__['parseJavaScript'];
}

/**
 * Parse variable to scope (block, page, view or global)
 *
 * @param string $varName Variable name to be defined in scope
 * @param mixed $var Variable value
 * @param string $p (optional) Scope name. If not specified defaults to global scope.
 */
function parseVar($varName, $var, $p = '')
{
    global $cfg__;

    if ($p) {
        $cfg__['varsPage'][$p][$varName] = $var;
    } else {
        $cfg__['varsGlobal'][$varName] = $var;
    }
}

/**
 * Get variable from scope (block, page, view or global)
 *
 * @param string $varName Variable name to be retrieved from scope
 * @param string $p (optional) Scope name. If not specified defaults to global scope.
 * @return mixed Variable value
 */
function getVar($varName, $p = '')
{
    global $cfg__;

    if ($p) {
        return $cfg__['varsPage'][$p][$varName];
    } else {
        return $cfg__['varsGlobal'][$varName];
    }
}

/**
 * Parse debug message as HTML
 *
 * @param mixed $mess Variable to be parsed to debugger
 * @param string $tag Debugger scope name
 */
function parseDebug($mess, $tag = '')
{
    global $cfg__;
    static $noBlock = '';

    if (!$tag) {
        ob_start();

        print_v($mess);
        $mess = ob_get_contents();

        ob_end_clean();

        $noBlock .= $mess;
    } else {
        ob_start();

        echo '<div style="border: 1px solid green; margin-bottom: 10px;">';
        print_v('<i>### Block "' . $tag . '" processing ###</i>');
        print_v($mess);
        echo $noBlock;
        print_v('<i>### Block "' . $tag . '" processing(end) ###</i>');
        echo '</div>';

        $mess = ob_get_contents();

        ob_end_clean();

        $cfg__['debug']['mess'][] = $mess;
        $noBlock = '';
    }
}

/**
 * Get requested page
 *
 * @return string Requested page
 */
function getPage()
{
    global $cfg__;

    return $cfg__['parse']['page'];
}

/**
 * Set requested page
 *
 * @param string $p The page to be requested
 */
function setPage($p)
{
    global $cfg__;

    $cfg__['parse']['page'] = $p;
}

/**
 * Get template
 *
 * @return string Current template
 */
function getTemplate()
{
    global $cfg__;

    return $cfg__['parse']['template'];
}

/**
 * Set template
 *
 * @param string $t Template file (without extension)
 */
function setTemplate($t)
{
    global $cfg__;

    $cfg__['parse']['template'] = $t;
}

/**
 * Get view
 *
 * @param string $p Correspondent page name
 * @return null|array If it was set by setView(), it returns an array with two keys: view, path
 */
function getView($p)
{
    global $cfg__;

    return $cfg__['parse']['view'][$p];
}

/**
 * Set view
 *
 * @param string $p Correspondent page name
 * @param string $view View name parsed (without extension)
 * @param string $path (optional) File path. If not specified, defaults to views/, relative to the current module
 */
function setView($p, $view, $path = '')
{
    global $cfg__;

    $cfg__['parse']['view'][$p] = array('view' => $view, 'path' => $path);
}

/**
 * Initialize form validation with specific validation rules and options using jQuery Validate plugin
 * on client side, and formValid() function on server side
 *
 * @param string $name Form name, the same as $_POST['formId']
 * @param array $rules Validation rules as multidimensional array, with key as field name and value as array of rules
 * @param array $messages Custom error messages for each field
 * @param array $options Options as defined in jQuery Validate plugin, with key as option name and value as option value
 * @param false $errorsOnTop All filed errors are shown at the beginning of the form. Defaults to false
 * @param false $hideErrors Hide all field text errors and only show generic error on top and field highlight. Defaults to false
 */
function formInit($name, $rules, $messages = array(), $options = array(), $errorsOnTop = false, $hideErrors = false)
{
    global $cfg__;

    $optionsDefault = array(
        'onkeyup' => false,
        'ignoreTitle' => true,
        'ignore' => '',
        'errorClass' => 'text-danger has-danger',
        'errorElement' => 'em',
        'errorContainer' => "#{$name}_errors_top, #{$name}_errors_bottom",
        'highlight' => 'function(element, errorClass, validClass) {
                $(element).closest(".form-group").addClass(errorClass).removeClass(validClass);
                $(element.form).find("label[for=\'" + element.id + "\']").addClass(errorClass);
                $(element).addClass("is-invalid").removeClass(validClass);
            }',
        'unhighlight' => 'function(element, errorClass, validClass) {
                $(element).closest(".form-group").removeClass(errorClass).addClass(validClass);
                $(element.form).find("label[for=\'" + element.id + "\']").removeClass(errorClass);
                $(element).removeClass("is-invalid").addClass(validClass);
            }',
        'submitHandler' => 'function(form) {
                form.submit();
            }'
    );

    if ($errorsOnTop || $hideErrors) {
        $optionsDefault['errorLabelContainer'] = "#{$name}_errors_top ul";
        $optionsDefault['wrapper'] = 'li';
        if ($hideErrors) {
            $optionsDefault['invalidHandler'] = 'function(form, validator) {
                    $(validator.settings.errorLabelContainer).remove();
                }';
        }
    }

    $cfg__['forms'][$name] = array(
        'rules' => $rules,
        'messages' => $messages,
        'options' => array_merge($optionsDefault, $options)
    );
}

/**
 * Make each formInit option value JavaScript friendly, in order to initialize it using jQuery Validate plugin
 *
 * @param bool|int|string $option
 * @return int|string
 */
function formInitOption($option)
{
    if (is_bool($option)) {
        return $option ? 'true' : 'false';
    } elseif (is_numeric($option)) {
        return $option;
    } elseif (strpos($option, 'function(') !== false || strpos($option, 'jQuery.validator.format(') !== false) {
        return $option;
    } else {
        return '"' . $option . '"';
    }
}

/**
 * Check if form has been posted
 *
 * @param string $name Form name, the same as $_POST['formId']
 * @return bool
 */
function formPost($name)
{
    // Check user rights
    if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN) {
        if (getPage() != 'login') {
            if ($_GET['edit']) {
                if (!userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI'])) {
                    return false;
                }
            } else {
                if (!userGetRight(ADMIN_RIGHT_ADD, $_SERVER['REQUEST_URI'])) {
                    return false;
                }
            }
        }
    }

    if ($_POST['formId'] == $name) {
        return true;
    }

    return false;
}

/**
 * Check if form is valid. Validation rules must be previously defined using formInit() function
 *
 * @param string $name Form name, the same as $_POST['formId']
 * @return bool
 */
function formValid($name)
{
    global $cfg__;

    if ($cfg__['forms'][$name] && formPost($name)) {
        foreach ($cfg__['forms'][$name]['rules'] as $field => $rules) {
            $field = formField($field);
            $fieldValue = formFieldValue($field);

            foreach ($rules as $rule => $val) {
                switch ($rule) {
                    case 'required':
                        if (is_bool($val) && $val == true) {
                            if (!isset($fieldValue)) {
                                return false;
                            }

                            if (is_string($fieldValue) && !strlen($fieldValue)) {
                                return false;
                            } elseif (is_array($fieldValue) && !count($fieldValue)) {
                                return false;
                            }
                        }
                        break;

                    case 'minlength':
                        if (is_numeric($val)) {
                            if (is_string($fieldValue) && strlen($fieldValue) && strlen($fieldValue) < $val) {
                                return false;
                            } elseif (is_array($fieldValue) && count($fieldValue) && count($fieldValue) < $val) {
                                return false;
                            }
                        }
                        break;

                    case 'maxlength':
                        if (is_numeric($val)) {
                            if (is_string($fieldValue) && strlen($fieldValue) && strlen($fieldValue) > $val) {
                                return false;
                            } elseif (is_array($fieldValue) && count($fieldValue) && count($fieldValue) > $val) {
                                return false;
                            }
                        }
                        break;

                    case 'email':
                        if (is_bool($val) && $val == true) {
                            if ((!filter_var($fieldValue, FILTER_VALIDATE_EMAIL) || strtolower(substr($fieldValue,
                                        0, 4)) == 'www.') && strlen($fieldValue)) {
                                return false;
                            }
                        }
                        break;


                    case 'url':
                        if (is_bool($val) && $val == true) {
                            if ((!filter_var($fieldValue, FILTER_VALIDATE_URL)) && strlen($fieldValue)) {
                                return false;
                            }
                        }
                        break;

                    case 'equalTo':
                        if ($fieldValue != $_POST[formFieldValue(formField($val))]) {
                            return false;
                        }
                        break;

                    default:
                        break;
                }
            }
        }
    }

    return true;
}

/**
 * Find the correct field name for each formInit option in order to validate it using formValid() function
 *
 * @param string $field
 * @return false|string
 */
function formField($field)
{
    if (substr($field, 0, 1) == '#') {
        return substr($field, 1);
    }

    if (substr($field, strlen($field) - 2) == '[]') {
        return substr($field, 0, strlen($field) - 2);
    }

    return $field;
}

/**
 * Extract the value of field from $_POST
 *
 * @param string $fieldName Name of the field, as it is after using formField() function
 * @return string|array|null Returns value of the $_POST for field, or null if undefined
 */
function formFieldValue($fieldName)
{
    $fieldValue = null;
    $countMatches = preg_match_all("/(?<field>[^\[\]]+)? \[(?<keys>[^\]\[]+)\] /x", $fieldName, $matches);

    if ($countMatches) {
        $valueTemp = $_POST[$matches['field'][0]];

        if (isset($valueTemp) && $matches['keys']) {
            $fieldValue = array_reduce(
                $matches['keys'],
                function ($carry, $item) {
                    return $carry[$item] ?? null;
                },
                $valueTemp
            );
        }
    } else {
        $fieldValue = $_POST[$fieldName];
    }

    if (isset($fieldValue) && !is_array($fieldValue)) {
        $fieldValue = trim($fieldValue);
    }

    return $fieldValue;
}

/**
 * Initialize select2 for field
 *
 * @param array $fieldId Array with 'id' key of field from HTML DOM, and 'options' key for additional options
 */
function formSelect2($fieldId)
{
    global $cfg__;

    $cfg__['varsGlobal']['initSelect2'][] = $fieldId;
}

/**
 * Generates `<option>` tags for select.
 *
 * @param array $options
 * @param string $optionName
 * @param string $selectName
 * @param array $optionsChildren
 * @param string $parentField
 * @param bool $blankOption
 * @param bool $isPost
 * @param array $dataFields
 * @param array $optionsDisabled
 * @return string
 */
function formSelectOptions(
    $options,
    $optionName,
    $selectName,
    $isPost = false,
    $blankOption = true,
    $optionsChildren = [],
    $parentField = 'parent_id',
    $dataFields = [],
    $optionsDisabled = []
) {
    $view = '@form.select.options';

    parseVar('options', $options, $view);
    parseVar('optionName', $optionName, $view);
    parseVar('selectName', $selectName, $view);
    parseVar('optionsChildren', $optionsChildren, $view);
    parseVar('parentField', $parentField, $view);
    parseVar('blankOption', $blankOption, $view);
    parseVar('isPost', $isPost, $view);
    parseVar('dataFields', $dataFields, $view);
    parseVar('optionsDisabled', $optionsDisabled, $view);

    return parseView($view, defined('ADMIN_PATH') ? ADMIN_PATH . 'views/' : '');
}

/**
 * Add alert message
 * Alerts will be kept in session, until the target page is loaded, and alerts block is called
 * Alerts template is defined in site.alerts block
 *
 * @param string $alert Alert text
 * @param string $type Alert type, one of: info, success, error, warning
 * @param string $page Target page to assign the alert to
 *                     If not specified, it will be getPage()
 *                     Defaults to ''
 */
function alertsAdd($alert, $type = 'success', $page = '')
{
    if (!$page) {
        $page = getPage();
    }

    $alert = array(
        'alert' => $alert,
        'type' => $type,
        'page' => $page
    );

    $alerts = sessionGet('alerts');
    if (!$alerts) {
        $alerts = array();
    }

    array_push($alerts, $alert);
    sessionSet('alerts', $alerts);
}

/**
 * Get value from session
 *
 * @param string $key Identifier for the value stored in session
 * @param string $sessionKey Session scope key. If not specified, defaults to scope of the curent module
 * @return mixed
 */
function sessionGet($key, $sessionKey = '')
{
    global $cfg__;

    if (!$sessionKey) {
        $sessionKey = $cfg__['session'][$cfg__['session']['default']];
    }

    return $_SESSION[$sessionKey][$key];
}

/**
 * Set value to session
 *
 * @param string $key Identifier for the value to be stored in session
 * @param mixed $value Value to be stored in session
 * @param string $sessionKey Session scope key. If not specified, defaults to scope of the curent module
 * @return mixed
 */
function sessionSet($key, $value, $sessionKey = '')
{
    global $cfg__;

    if (!$sessionKey) {
        $sessionKey = $cfg__['session'][$cfg__['session']['default']];
    }

    return $_SESSION[$sessionKey][$key] = $value;
}

/**
 * Redirect to URL
 *
 * @param string $url Redirect url
 * @param int $code Redirect code
 * @param bool $replace Replace similar header
 */
function redirectURL($url, $code = 301, $replace = true)
{
    header('Location: ' . $url, $replace, $code);
    die();
}

/**
 * Do a user login<br>
 * Username and password are passed via $_POST, and keys are defined in $cfg__['login']['settings']<br>
 * Login attempts (successful or not), will automatically be logged using userLoginLog() function<br>
 * If 'status' is not active or 'ban' flag is set for user, the login will not be successful<br>
 * Multiple login attempts (abuse) will be automatically limited using userLoginSuspend() function<br>
 * Error messages can be configured in $cfg__['login']['errorCode'] by error code
 *
 *
 * @param string $redirectSuccess Page to redirect to if login is successful
 *                               If not defined, the value from $_POST['loginRedirectSuccess'] will be used<br>
 *                               If not defined, the value from sessionGet('loginRedirectSuccess') will be used<br>
 *                               If not defined, $websiteURL will be used
 * @param string $redirectError Page to redirect to if login is not successful
 *                               If not defined, the value from $_POST['loginRedirectError'] will be used<br>
 *                               If not defined, the value from sessionGet('loginRedirectError') will be used<br>
 *                               If not defined, $websiteURL will be used
 * @param array $googleUser Google user info for login. This gets called automatically from userLoginGoogle()
 * @param array $facebookUser Facebook user info for login. This gets called automatically from userLoginFacebook()
 * @param array $microsoftUser Microsoft user info for login. This gets called automatically from userLoginMicrosoft()
 */
function userLogin(
    $redirectSuccess = '',
    $redirectError = '',
    $googleUser = array(),
    $facebookUser = array(),
    $microsoftUser = array()
) {
    global $cfg__, $websiteURL;

    // Set error flag
    // $errCode = 1;

    // Users table in DB
    $usersTable = $cfg__['login']['settings']['table'];

    // Get login credentials
    $username = $_POST[$cfg__['login']['settings']['username']];
    $password = $_POST[$cfg__['login']['settings']['password']];
    $ip = $_SERVER['REMOTE_ADDR'];
    $where = $cfg__['login']['settings']['username'] . ' = ' . dbEscape($username);

    // Set login log
    $loginLog = array(
        'user' => $username,
        'ip' => $ip,
        'date' => time()
    );

    // Get Google / Facebook login credentials
    $email = '';
    if ($googleUser || $facebookUser || $microsoftUser) {
        if ($googleUser['email']) {
            $email = $googleUser['email'];
        }

        if ($facebookUser['email']) {
            $email = $facebookUser['email'];
        }

        if ($microsoftUser['email']) {
            $email = $microsoftUser['email'];
        }

        $where = $cfg__['login']['settings']['email'] . ' = ' . dbEscape($email);
        $loginLog['email'] = $email;
    }

    // Restrict login tries from same IP (max 10 errors in 5 minutes)
    $errCode = userLoginSuspend($ip);

    if ($errCode != 5 && (strlen($username) || strlen($email))) {
        // Check for user in DB
        $user = dbShift(dbSelect(
            '*',
            $usersTable,
            $where
        ));

        if ($user) {

            // Restrict login tries for same user (max 3 errors in 5 minutes)
            $errCode = userLoginSuspend(false, $user);

            // Check if login is temporary restricted
            if ($errCode != 4) {

                // Set login log
                $loginLog['user_id'] = $user['id'];

                if (
                    (
                        strlen(trim($password))
                        && password_verify(trim($password), $user[$cfg__['login']['settings']['password']])
                    )
                    || $email
                ) {
                    if ($user['status'] == 1 && $user['ban'] == 0) {
                        // Login
                        userDoLogin($user);

                        // Set login log
                        $loginLog['success'] = 1;
                        userLoginLog($loginLog);

                        // Update credentials & user info for Google / Facebook user
                        if ($email) {
                            $userData = array(
                                'id' => $user['id'],
                                'g_id' => $googleUser['sub'],
                                'g_token' => $googleUser['id_token'],
                                'fb_id' => $facebookUser['id'],
                                'fb_token' => $facebookUser['id_token'],
                                'ms_id' => $microsoftUser['id'],
                                'ms_token' => $microsoftUser['id_token'],
                                '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
                            );

                            if (PLATFORM_MODULE == PLATFORM_MODULE_ADMIN) {
                                /*if ($googleUser) {
                                    $userData['name'] = $googleUser['name'];
                                } elseif ($facebookUser) {
                                    $userData['name'] = $facebookUser['first_name'] . ' ' . $facebookUser['last_name'];
                                } elseif ($microsoftUser) {
                                    $userData['name'] = $microsoftUser['name'];
                                }*/
                            } else {
                                if ($googleUser) {
                                    $userData['first_name'] = $googleUser['given_name'];
                                    $userData['last_name'] = $googleUser['family_name'];
                                } elseif ($facebookUser) {
                                    $userData = array_merge($userData, [
                                        'first_name' => $facebookUser['first_name'],
                                        'last_name' => $facebookUser['last_name']
                                    ]);
                                } elseif ($microsoftUser) {
                                    $userData = array_merge($userData, [
                                        'first_name' => $microsoftUser['givenName'],
                                        'last_name' => $microsoftUser['surname']
                                    ]);
                                }
                            }

                            dbInsert($usersTable, $userData);
                        }

                        // Redirect after login
                        if (strlen($redirectSuccess)) {
                            $redirect = $redirectSuccess;
                        } elseif (strlen($_POST['loginRedirectSuccess'])) {
                            $redirect = $_POST['loginRedirectSuccess'];
                        } elseif (strlen(sessionGet('loginRedirectSuccess'))) {
                            $redirect = sessionGet('loginRedirectSuccess');
                            sessionSet('loginRedirectSuccess', '');
                        } else {
                            $redirect = $websiteURL;
                        }

                        // Unset login error code to pe used after redirect
                        sessionSet('loginRedirectError', '');

                        // Redirect for Google / Facebook user
                        if ($email && $_GET['ajax']) {
                            $functions[] = array('id' => 'redirectTimeout', 'params' => [$redirect, 0]);
                            ajaxResponse(array(), array(), array(), array(), array(), $functions);
                        }

                        // Return redirect
                        if ($_GET['return_redirect']) {
                            return $redirect;
                        }

                        // Return HTML page if login via AJAX
                        if ($_GET['ajax']) {
                            parsePage('account.login');
                        }

                        redirectURL($redirect);
                    } elseif ($user['ban'] == 1) {
                        $errCode = 3;
                    } else {
                        $errCode = 2;
                    }
                } else {
                    $errCode = 1;
                }
            }
        } else {
            $errCode = 1;
        }
    }

    if ($errCode) {
        // Set login log
        if ($errCode != 4 && $errCode != 5) {
            $loginLog['error_code'] = $errCode;
            userLoginLog($loginLog);
        }

        // Redirect after login error
        if (strlen($redirectError)) {
            $redirect = $redirectError;
        } elseif (strlen($_POST['loginRedirectError'])) {
            $redirect = $_POST['loginRedirectError'];
        } elseif (strlen(sessionGet('loginRedirectError'))) {
            $redirect = sessionGet('loginRedirectError');
        } else {
            $redirect = $websiteURL;
        }

        // Error for Google / Facebook user
        if ($email && $_GET['ajax'] && ($googleUser || $facebookUser)) {
            $contents = $fields = $options = $css = $attributes = $functions = array();

            $errorElement = $googleUser ? 'googleLoginError' : 'facebookLoginError';

            $contents[] = array('id' => $errorElement, 'value' => $cfg__['login']['errorCode'][$errCode]);
            $css[] = array('id' => $errorElement, 'property' => 'display', 'value' => 'block');

            ajaxResponse($contents, $fields, $options, $css, $attributes, $functions);
        }

        // Set login error code to pe used after redirect
        sessionSet('loginErrorCode', $errCode);

        // Return redirect
        if ($_GET['return_redirect']) {
            return $redirect;
        }

        // Return HTML page if login via AJAX
        if ($_GET['ajax']) {
            parsePage('account.login');
        }

        redirectURL($redirect);
    }
}

/**
 * Check for multiple login attempts (abuse) and suspend user or IP for a defined period of time
 *
 * @param false $ip IP address. Defaults to false
 * @param false|array $user User info that must contain 'id' key. Defaults to false
 * @return int Error code
 */
function userLoginSuspend($ip = false, $user = false)
{
    global $cfg__;

    $errCode = 1;
    $logTable = $cfg__['login']['settings']['table_log'];

    if ($ip) {
        $where = 'ip = ' . dbEscape($ip);
    } elseif ($user['id']) {
        $where = 'user_id = ' . dbEscape($user['id']);
    } else {
        return $errCode;
    }

    // Get number of recent logins by IP / user
    $logins = dbShift(dbSelect(
        "*, (SELECT COUNT(id)
                    FROM {$logTable}
                    WHERE {$where} AND date > " . dbEscape(strtotime('-5 minutes')) . " AND success = 0
            ) AS tries",
        $logTable,
        $where,
        'date DESC',
        '',
        '0, 1'
    ));

    if ($ip) {
        // Check if login by IP is temporary restricted
        if ($logins['suspended_until_by_ip'] > time()) {
            $errCode = 5;
        }

        // Restrict login for 5 minutes
        if ($errCode != 5 && $logins['tries'] >= 10) {
            dbInsert($logTable, array(
                'id' => $logins['id'],
                'suspended_until_by_ip' => strtotime('+5 minutes')
            ));

            $errCode = 5;
        }
    }

    if ($user['id']) {
        // Check if login is temporary restricted
        if ($logins['suspended_until_by_user'] > time()) {
            $errCode = 4;
        }

        // Restrict login for 5 minutes
        if ($errCode != 4 && $logins['tries'] >= 3) {
            dbInsert($logTable, array(
                'id' => $logins['id'],
                'suspended_until_by_user' => strtotime('+5 minutes')
            ));

            $errCode = 4;
        }
    }

    return $errCode;
}

/**
 * Log login attempt in DB<br>
 * DB table can be defined in $cfg__['login']['settings']['table_log']
 * Login attempts can be viewed in admin
 *
 * @param array $log Log data with the following keys:<br>
 *                      - user (username)<br>
 *                      - ip (IP address)<br>
 *                      - date (time() of login attempt)
 */
function userLoginLog($log)
{
    global $cfg__;

    $logTable = $cfg__['login']['settings']['table_log'];
    if ($logTable) {
        dbInsert($logTable, $log);
    }
}

/**
 * Set user login in session
 *
 * @param array $user User info that must contain 'id' key
 * @param string $sessionKey Session key to store login. Defaults to empty string<br>
 *                           Should be set only if to target a different module than the current one
 */
function userDoLogin($user, $sessionKey = '')
{
    // Site login
    sessionSet('key_site', session_id(), $sessionKey);
    sessionSet('user_id', $user['id'], $sessionKey);

    // Cookie login
    //if($_POST['loginRemember'])
    //userSetCookie($user['id']);
}

/**
 * Set cookie for persistent login/logout
 *
 * @param int $userId User id
 * @param bool $login True for login, false for logout
 */
function userSetCookie($userId, $login = true)
{
    global $cfg__;

    $exp = time() + 30 * 24 * 3600;

    if (!$login) {
        $exp = 0;
    }

    setcookie('domain_site_', serialize(array('sid' => session_id(), 'uid' => $userId)), $exp, '/',
        $cfg__['login']['settings']['domain'], 0);
    dbInsert($cfg__['login']['settings']['table'],
        array('id' => $userId, 'site_cookie' => session_id(), 'site_expires' => $exp));
}

/**
 * Send reset password link via email for front module user
 *
 * @param array $accountInfo User info from DB
 * @param false $fromAdmin If sent via admin interface
 * @return bool True if email was sent, false on failure
 */
function userResetPassword($accountInfo, $fromAdmin = false)
{
    global $websiteURL;

    // Create reset link
    $resetKey = md5($accountInfo['id'] . microtime() . mt_rand());
    $resetLink = makeLink(
            $fromAdmin ? LINK_FRONT : LINK_ABSOLUTE,
            getPageByKey('type', CATEGORIE_USER),
            getPageByKey('type', CATEGORIE_USER_RESET_PASSWORD)
        ) . "?key={$resetKey}";
    if ($fromAdmin) {
        parseVar('websiteURL', makeLink(LINK_FRONT), '');
    }

    dbInsert('es_user', array(
        'id' => $accountInfo['id'],
        'reset_key' => $resetKey,
        'reset_expires' => strtotime('+4 hour')
    ));

    // Send password reset email
    $resetEmail = variousGet('account-password-email', true, false);
    $resetEmail['text'] = str_replace(
        ['{first_name}', '{reset_link}'],
        [$accountInfo['first_name'], '<a href="' . $resetLink . '">Reseteaza Parola</a>'],
        $resetEmail['text']
    );

    return mailSend(
        $accountInfo['email'],
        $resetEmail['title'],
        mailFormat($resetEmail['text']),
        settingsGet('email-reply-to-address')
    );
}

/**
 * Generate key for password reset
 *
 * @param array $accountInfo User info from DB
 * @return false|string Reset key if it was saved in DB or false on failure
 */
function userResetKeyAdmin($accountInfo)
{
    global $cfg__;

    // Create reset key
    $resetKey = md5($accountInfo['id'] . microtime() . mt_rand());

    $r = dbInsert($cfg__['login']['settings']['table'], array(
        'id' => $accountInfo['id'],
        'reset_key' => $resetKey,
        'reset_expires' => strtotime('+24 hour')
    ));

    if ($r === false) {
        $resetKey = false;
    }

    return $resetKey;
}

/**
 * Send reset password link via email for admin module user
 *
 * @param array $accountInfo User info from DB
 * @return bool True if email was sent, false on failure
 * @throws Exception
 */
function userResetPasswordAdmin($accountInfo)
{
    global $websiteURL;

    parseVar('websiteURL', makeLink(LINK_FRONT));

    // Create reset key
    $resetKey = userResetKeyAdmin($accountInfo);
    if ($resetKey === false) {
        throw new Exception('Nu au putut fi stabilite datele pentru resetarea parolei.');
    }

    // Create reset link
    $resetLink = makeLink(LINK_ABSOLUTE, 'index.php') . buildHttpQuery(['key' => $resetKey]);

    // Send password reset email
    $resetEmail = variousGet('account-password-admin-email', true, false);
    $resetEmail['text'] = str_replace(
        ['{name}', '{reset_link}'],
        [$accountInfo['name'], '<a href="' . $resetLink . '">Reseteaza Parola</a>'],
        $resetEmail['text']
    );

    return mailSend(
        $accountInfo['email'],
        $resetEmail['title'],
        mailFormat($resetEmail['text']),
        settingsGet('email-reply-to-address')
    );
}

/**
 * Send user welcome email for front user
 *
 * @param string $email User email address
 * @param string $firstName User first name
 * @return bool True if email was sent, false on failure
 */
function userWelcomeEmail($email, $firstName)
{
    $registerEmail = variousGet('account-register-email', true, false);
    $registerEmail['text'] = str_replace(['{first_name}'], [$firstName], $registerEmail['text']);

    return mailSend(
        $email,
        $registerEmail['title'],
        mailFormat($registerEmail['text']),
        settingsGet('email-reply-to-address')
    );
}

/**
 * Send user welcome email for front user
 *
 * @param array $accountInfo User info from DB
 * @return bool True if email was sent, false on failure
 * @throws Exception
 */
function userWelcomeEmailAdmin($accountInfo)
{
    global $websiteURL;

    parseVar('websiteURL', makeLink(LINK_FRONT));

    // Create reset key
    $resetKey = userResetKeyAdmin($accountInfo);
    if ($resetKey === false) {
        throw new Exception('Nu au putut fi stabilite datele pentru resetarea parolei.');
    }

    // Create reset link
    $resetLink = makeLink(LINK_ABSOLUTE, 'index.php') . buildHttpQuery(['key' => $resetKey]);

    $registerEmail = variousGet('account-register-admin-email', true, false);
    $registerEmail['text'] = str_replace(
        ['{name}', '{reset_link}', '{login_link}'],
        [
            $accountInfo['name'],
            '<a href="' . $resetLink . '">Reseteaza Parola</a>',
            '<a href="' . $websiteURL . '">Intra in Cont</a>'
        ],
        $registerEmail['text']
    );

    return mailSend(
        $accountInfo['email'],
        $registerEmail['title'],
        mailFormat($registerEmail['text']),
        settingsGet('email-reply-to-address')
    );
}

/**
 * Get user id
 *
 * @param string $sessionKey Session key to retrieve login. Defaults to empty string<br>
 *                           Should be set only if to target a different module than the current one
 * @return false|int Return logged in user id or false if no user is logged in
 */
function userGet($sessionKey = '')
{
    global $cfg__;

    if ($sessionKey) {
        if (sessionGet('key_site', $sessionKey) == session_id()) {
            return sessionGet('user_id', $sessionKey);
        }

        return false;
    }

    /*if($cfg__['login']['settings']['facebook'])
    {
        static $userId = 0;

        if ($userId !== FALSE)
        {
            if ($cfg__['FB']['userId'] && $userId) {
                return $userId;
            }

            try {
                $FB = initFBSDK();
                $cfg__['FB']['userId'] = $FB->getUser();
                $cfg__['FB']['user'] = $FB->api('/me');

                if ($cfg__['FB']['userId'] && $userId = userGetInfo('id', $cfg__['FB']['userId'])) {
                    return $userId;
                } else {
                    $userId = false;
                }

            } catch (Exception $e) {
                $userId = false;
            }
        }
    }*/

    if (
        sessionGet('key_site') == session_id()
        && userGetInfo('status', false, false, sessionGet('user_id')) == 1
        && userGetInfo('ban', false, false, sessionGet('user_id')) == 0
    ) {
        return sessionGet('user_id');
    }

    if ($cfg__['login']['settings']['domain'] && $_COOKIE['domain_site_']) {
        $cookie = unserialize(stripslashes($_COOKIE['domain_site_']), ['allowed_classes' => false]);
        $userId = dbShiftKey(dbSelect(
            'id',
            $cfg__['login']['settings']['table'],
            "site_cookie=" . dbEscape($cookie['sid']) . " AND site_expires > " . time(),
            '',
            '',
            '0,1'
        ));
        //print_v($userId,true);
        if ($userId == $cookie['uid']) {
            userSetCookie($userId);
            userDoLogin(array('id' => $userId));

            return userGet();
        } else {
            setcookie('domain_site_', '', time() - 3600, '/', $cfg__['login']['settings']['domain'], 0);
        }
    }

    return false;
}

/**
 * Get user data for a specified field<br>
 * If none of the id params are specified, user data from the logged in user will be returned
 *
 * @param string $field Field name as can be found in DB
 * @param false $idFB Facebook id. Defaults to false
 * @param false $idG Google id. Defaults to false
 * @param false $id User id. Defaults to false
 * @return string|mixed User data
 */
function userGetInfo($field, $idFB = false, $idG = false, $id = false)
{
    global $cfg__;
    static $userList;

    if (!$id) {
        $id = userGet();
    }

    $user = [];
    if ($userList && $userList[$id]) {
        $user = $userList[$id];
    }

    if (!$user) {
        $where = 'id = ' . dbEscape($id);

        if ($idFB) {
            $where = 'id_fb = ' . dbEscape($idFB);
        } elseif ($idG) {
            $where = 'id_g = ' . dbEscape($idG);
        }

        $user = dbShift(dbSelect('*', $cfg__['login']['settings']['table'], $where));

        if ($user) {
            $userList[$user['id']] = $user;
        }
    }

    return $user[$field];
}

/**
 * Get error message after login attempt
 *
 * @param bool $reset Reset error message. Defaults to true
 * @return string Error message
 */
function userGetError($reset = true)
{
    global $cfg__;

    $err = $cfg__['login']['errorCode'][sessionGet('loginErrorCode')];

    if ($reset) {
        sessionSet('loginErrorCode', '');
    }

    return $err;
}

/**
 * Do a user logout
 *
 * @param string $redirect Page to redirect to after logout. Defaults to empty string
 *                         If not defined, $websiteURL will be used
 * @param string $sessionKey Session key for logout. Defaults to empty string<br>
 *                           Should be set only if to target a different module than the current one
 */
function userLogout($redirect = '', $sessionKey = '')
{
    global $cfg__, $websiteURL;

    // Where to redirect after logout
    if (!$redirect) {
        $redirect = $websiteURL;
    }

    // Cookie logout
    if ($cfg__['login']['settings']['domain'] && $_COOKIE['domain_site_']) {
        userSetCookie(userGet(), false);
    }

    // Google logout
    if ($cfg__['login']['settings']['google'] && userGetInfo('g_token')) {
        try {
            $client = new Google_Client();
            $client->setAuthConfig(PLATFORM_PATH . 'config/client_secret.json');
            $client->fetchAccessTokenWithRefreshToken(userGetInfo('g_token'));

            if (!$client->revokeToken()) {
                throw new Exception('Could not revoke.');
            }
        } catch (Exception $e) {
            error_log('Error on Google Logout: ' . $e->getMessage());
        }

        dbInsert($cfg__['login']['settings']['table'], array(
            'id' => userGet(),
            'g_token' => '',
            '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
        ));
    }

    // Facebook Logout
    if ($cfg__['login']['settings']['facebook'] && userGetInfo('fb_token')) {
        try {
            $fb = initFBSDK();
            $helper = $fb->getRedirectLoginHelper();
            $redirectLogout = $helper->getLogoutUrl(userGetInfo('fb_token'), $redirect);

            if (!$redirectLogout) {
                throw new Exception('Could not generate logout URL.');
            }

            $redirect = $redirectLogout;
        } catch (Exception $e) {
            error_log('Error on Facebook Logout: ' . $e->getMessage());
        }

        dbInsert($cfg__['login']['settings']['table'], array(
            'id' => userGet(),
            'fb_token' => '',
            '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
        ));
    }

    // Microsoft Logout
    if ($cfg__['login']['settings']['microsoft'] && userGetInfo('ms_token')) {
        dbInsert($cfg__['login']['settings']['table'], array(
            'id' => userGet(),
            'ms_token' => '',
            '_no_admin_log' => $cfg__['session'][$cfg__['session']['default']]
        ));
    }

    // Site logout
    sessionSet('key_site', '', $sessionKey);
    sessionSet('user_id', '', $sessionKey);
    sessionSet('csrf_token', '', $sessionKey);
    sessionSet('csrf_expires', '', $sessionKey);

    redirectURL($redirect);
}

function userAction($entityId, $entityType, $dataNew, $dataOld, $entitiesById = [])
{
    // Check if action exists
    $actionId = dbShiftKey(dbSelect(
        'id',
        'user_action',
        'entity_id = ' . dbEscape($entityId) . ' AND entity_type = ' . dbEscape($entityType)
    ));

    // Add initial user action OR generate action by configured fields
    if (!$actionId) {
        // Save action
        userActionAdd($entityId, $entityType);

        // Save text message
        userActionText(
            $entityId,
            $entityType,
            MESSAGE_ADD
        );
    } else {
        $entityAction = ENTITY_ACTIONS[$entityType];
        $entityAction['fields'] = array_column($entityAction['fields'], null, 'name');

        // Check MESSAGE_STATUS action
        if ($entityAction['status_field']) {
            $field = $entityAction['status_field'];

            if ($dataNew[$field] != $dataOld[$field]) {
                userActionText(
                    $entityId,
                    $entityType,
                    MESSAGE_STATUS,
                    $entitiesById[$field][$dataNew[$field]]
                );
            }

            unset(
                $entityAction['fields'][$field],
                $dataNew[$field],
                $dataOld[$field]
            );
        }

        // Check MESSAGE_TEXT action
        if ($entityAction['comment_field']) {
            $field = $entityAction['comment_field'];

            if ($dataNew[$field]) {
                // Compare fields
                $dataDiff = userActionCompare(
                    [$field => $dataNew[$field]],
                    [],
                    $entityAction['fields'],
                    $entitiesById
                );

                // Save differences
                userActionText(
                    $entityId,
                    $entityType,
                    MESSAGE_TEXT,
                    '',
                    $dataDiff
                );
            }

            unset(
                $entityAction['fields'][$field],
                $dataNew[$field],
                $dataOld[$field]
            );
        }

        // Check MESSAGE_IMAGE action
        if ($entityAction['image_fields']) {

            // Get data for image fields
            $imageNew = $imageOld = $imageFields = [];
            foreach ($entityAction['image_fields'] as $field) {
                $imageNew[$field] = $dataNew[$field];
                $imageOld[$field] = $dataOld[$field];
                $imageFields[] = $entityAction['fields'][$field];

                unset(
                    $entityAction['fields'][$field],
                    $dataNew[$field],
                    $dataOld[$field]
                );
            }

            // Compare fields
            $dataDiff = userActionCompare($imageNew, $imageOld, $imageFields, $entitiesById);

            // Save fields differences
            if ($dataDiff) {
                userActionText(
                    $entityId,
                    $entityType,
                    MESSAGE_IMAGE,
                    '',
                    $dataDiff
                );
            }
        }

        // Check MESSAGE_UPDATE action
        $dataDiff = userActionCompare($dataNew, $dataOld, $entityAction['fields'], $entitiesById);

        // Save field differences
        if ($dataDiff) {
            userActionText(
                $entityId,
                $entityType,
                MESSAGE_UPDATE,
                '',
                $dataDiff
            );
        }
    }
}

/**
 * Log user action on entity
 *
 * @param int $entityId Entity id from entity table
 * @param int $entityType Entity type as configured via constants
 * @return bool|int|mysqli_result|string
 */
function userActionAdd($entityId, $entityType)
{
    $actionId = dbInsert('user_action', [
        'back_user_id' => PLATFORM_MODULE == PLATFORM_MODULE_ADMIN ? userGet() : 0,
        'entity_id' => $entityId,
        'entity_type' => $entityType
    ]);

    if ($actionId === false) {
        alertsAdd('Actiunea nu a putut fi salvata in istoric!', 'error');
    }

    return $actionId;
}

function userActionStatus($entityId, $entityType, $entityTable, $statusField, $statusById)
{
    $status = dbShiftKey(dbSelect(
        $statusField,
        $entityTable,
        'id = ' . dbEscape($entityId)
    ));

    // Save text message
    userAction(
        $entityId,
        $entityType,
        [$statusField => $status],
        [],
        [$statusField => $statusById]
    );
}

/**
 * Log user action summary text and updated fields on entity
 *
 * @param int $entityId Entity id from entity table
 * @param int $entityType Entity type as configured via constants
 * @param int $messageType Message type as configured via constants
 * @param string $message Action summary text. Defaults to empty string
 * @param array $fields List of updated fields, with 'title' and 'value' as keys. Defaults to empty string
 * @return bool|int Id of the corresponding message. Returns false if an error has occurred
 */
function userActionText($entityId, $entityType, $messageType, $message = '', $fields = [])
{
    $messageId = false;

    $actionId = dbShiftKey(dbSelect(
        'id',
        'user_action',
        'entity_id = ' . dbEscape($entityId) . ' AND entity_type = ' . dbEscape($entityType)
    ));

    if ($actionId) {
        $messageId = dbInsert('user_action_text', [
            'user_action_id' => $actionId,
            'back_user_id' => PLATFORM_MODULE == PLATFORM_MODULE_ADMIN ? userGet() : 0,
            'type' => $messageType,
            'metadata' => ['message' => $message, 'fields' => $fields],
            'date' => time()
        ]);
    }

    if ($messageId === false) {
        alertsAdd('Actiunea nu a putut fi salvata in istoric!', 'error');
    }

    return $messageId;
}

/**
 * Compare old and new data in order to get field differences that will be used via userActionText() function
 *
 * @param array $newData Associative array of new data for comparison
 * @param array $oldData Associative array of old data for comparison
 * @param array $fields Associative array of field keys and human readable field names and format
 *                      as configured via ENTITY_ACTIONS constant
 * @return array Associative array of differences with 'title' key for field name and 'value' key for new field value
 */
function userActionCompare($newData, $oldData, $fields, $entitiesById = [])
{
    // Store differences
    $diff = array();

    // For each field, compare new data to old data
    foreach ($fields as $field) {
        // Difference for current field
        $isDiff = false;

        // Field key
        $fieldKey = $field['name'];

        // For array fields and text fields
        if (is_array($newData[$fieldKey])) {
            if (
                count(
                    array_intersect($newData[$fieldKey], $oldData[$fieldKey])
                ) != count($newData[$fieldKey])
                || count($newData[$fieldKey]) != count($oldData[$fieldKey])
            ) {
                $isDiff = true;
            }
        } elseif (
            strcmp(
                htmlspecialchars_decode($newData[$fieldKey]),
                htmlspecialchars_decode($oldData[$fieldKey])
            ) !== 0
        ) {
            $isDiff = true;
        }

        if ($isDiff) {
            // Skip value or return field title + value
            if ($field['skip_value']) {
                $diff[] = [
                    'title' => $field['title']
                ];
            } else {
                // Diff value
                $diffValue = '';

                // Check formatting
                switch ($field['format']) {
                    case ENTITY_FORMAT_DATE:
                        $diffValue = date('d.m.Y', $newData[$fieldKey]);
                        break;

                    case ENTITY_FORMAT_DATETIME:
                        $diffValue = date('d.m.Y H:i', $newData[$fieldKey]);
                        break;

                    case ENTITY_FORMAT_BY_ID:
                        if (!is_array($newData[$fieldKey])) {
                            $diffValue = $entitiesById[$fieldKey][$newData[$fieldKey]];
                        } else {
                            $diffValue = [];
                            foreach ($newData[$fieldKey] as $key) {
                                $diffValue[] = $entitiesById[$fieldKey][$key];
                            }
                        }
                        break;

                    default:
                        $diffValue = $newData[$fieldKey];
                        break;
                }

                if (!is_array($diffValue)) {
                    $diffValue = htmlspecialchars($diffValue);

                    if (!$field['is_html']) {
                        $diffValue = nl2br($diffValue);
                    }
                } else {
                    $diffValue = array_map('htmlspecialchars', $diffValue);

                    if (!$field['is_html']) {
                        $diffValue = array_map('nl2br', $diffValue);
                    }
                }

                $diff[] = [
                    'title' => !$field['skip_title'] ? $field['title'] : '',
                    'value' => $diffValue,
                    'value_old' => $field['is_html'] ? htmlspecialchars($oldData[$fieldKey]) : '',
                    'is_html' => $field['is_html']
                ];
            }
        }
    }

    return $diff;
}

/**
 * Initialize Facebook Graph SDK
 *
 * @return mixed Initialized SDK object
 * @throws \Facebook\Exceptions\FacebookSDKException
 */
function initFBSDK()
{
    global $cfg__;

    if (!($cfg__['FB']['api'] instanceof \Facebook\Facebook)) {
        $cfg__['FB']['api'] = new \Facebook\Facebook(array(
            'app_id' => settingsGet('facebook-app-id'),
            'app_secret' => settingsGet('facebook-app-secret'),
            'default_graph_version' => 'v7.0'
        ));
    }

    return $cfg__['FB']['api'];
}

/**
 * Get settings from DB
 *
 * @param string $key Identifier for the value stored in settings table
 * @param bool $noChache Reset cache
 * @return mixed
 */
function settingsGet($key, $noChache = false)
{
    static $settings;

    if (!$settings || $noChache) {
        $settingsDb = dbSelect('name, value', 'back_settings');
        foreach ($settingsDb as $row) {
            $settings[$row['name']] = $row['value'];
        }
    }

    return $settings[$key];
}

/**
 * Set settings to DB
 *
 * @param string $key Identifier for the value stored in settings table
 * @param string $val Value stored in settings table
 * @return bool
 */
function settingsSet($key, $val)
{
    $r = dbRunQuery('
            UPDATE back_settings 
            SET value = ' . dbEscape($val) . '
            WHERE name = ' . dbEscape($key)
    );

    settingsGet('dummy', true);

    return (bool)$r;
}

/**
 * Used for outputting mostly debug data in a nice formatted way (prints $var).
 *
 * @param mixed $var Can be of type object, array, boolean & others.
 * @param bool $die Dies after printing $var
 */
function print_v($var, $die = false)
{
    echo '<div style="background-color: #bed1e4; width: 100%;"><pre style="margin: 0; padding: 5px; white-space: pre-wrap;">';

    if (is_object($var) || is_array($var)) {
        print_r($var);
    } elseif (is_resource($var)) {
        var_dump($var);
    } elseif (is_bool($var)) {
        var_dump($var);
    } else {
        echo $var;
    }

    echo "</pre></div>";

    if ($die) {
        die();
    }
}

// ======================================== Mail functions ========================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Send email
 *
 * @param string $to One or more email addresses separated by comma
 * @param string $subject Email subject
 * @param string $message Email message. Can be HTML
 * @param string $replyTo Email address to reply to
 * @param array $attachments Array of attachments with 'path' (file path) and 'name' (file name in email) as keys
 * @param string $bcc One or more email addresses separated by comma
 * @return bool True if email was sent, false on failure
 */
function mailSend($to, $subject, $message, $replyTo = '', $attachments = array(), $bcc = '')
{
    $mailSent = false;
    $mail = new PHPMailer(true);

    try {
        $mail->From = settingsGet('email-from-address');
        $mail->FromName = settingsGet('email-from-name');

        $to = explode(',', $to);
        foreach ($to as $a) {
            if ($a) {
                $mail->AddAddress(trim($a));
            }
        }

        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->CharSet = 'utf-8';

        if ($replyTo) {
            $mail->AddReplyTo($replyTo);
        }

        $bcc = explode(',', $bcc);
        foreach ($bcc as $a) {
            if ($a) {
                $mail->AddBCC(trim($a));
            }
        }

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment['path'], $attachment['name']);
            }
        }

        if (
            settingsGet('smtp-host')
            && settingsGet('smtp-port')
            && settingsGet('smtp-user')
            && settingsGet('smtp-pass')
        ) {
            $mail->Host = settingsGet('smtp-host');
            $mail->Port = settingsGet('smtp-port');
            $mail->Username = settingsGet('smtp-user');
            $mail->Password = settingsGet('smtp-pass');
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            if (settingsGet('smtp-debug')) {
                $mail->SMTPDebug = 4;
                $mail->Debugoutput = 'error_log';
            }

            $mailSent = ($mail->Send());
        }

        /*if (!$mailSent) {
            $mail->Mailer = 'mail';
            $mailSent = $mail->Send();
        }*/
    } catch (Exception $e) {
        $backTrace = debug_backtrace();
        $backTrace = $backTrace[0]['file'];

        error_log("\nMail send failed!\nError: " . $mail->ErrorInfo . "\nFile: " . $backTrace . "\n");
    }

    //$mail->__destruct();

    return $mailSent;
}

/**
 * Format email using @email.template
 *
 * @param string $message Email message that will be formatted with header and footer. Can be HTML
 * @return string A formatted HTML message
 */
function mailFormat($message, $css = '')
{
    parseVar('message', $message, '@email.template');
    parseVar('css', $css, '@email.template');
    $html = parseView('@email.template');

    return $html;
}

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * Inline CSS code in email HTML
 *
 * @param string $html HTML code
 * @param string $css CSS code
 * @return string Inlined HTML and CSS
 */
function mailCssToInlineStyles($html, $css)
{
    $cssToInlineStyles = new CssToInlineStyles();

    return $cssToInlineStyles->convert(
        $html,
        $css
    );
}

// ======================================== Mail functions(end) ===================================
