<?php
if ($_POST['token'] == md5(sessionGet('key_site') . $_POST['timestamp'])) {
    // Validate the file type
    $fileTypes = $cfg__['varsGlobal']['extUploadify']; // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    if (in_array(strtolower($fileParts['extension']), $fileTypes['extensions'])) {
        $key = sessionGet('key_site') . $_POST['token'];

        $dir = explode('/', $_FILES['Filedata']['tmp_name']);
        array_pop($dir);
        $dir = implode('/', $dir) . '/';
        $fileName = md5($key . $_FILES['Filedata']['tmp_name']);
        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $dir . $fileName)) {
            $_FILES['Filedata']['tmp_name'] = $dir . $fileName;
            $keySession = md5($key . $fileName);
            sessionSet($keySession, $_FILES['Filedata']);

            if ($_POST['multi']) {
                $keys = sessionGet($key);
                if (!is_array($keys)) {
                    $keys = array();
                }

                $keys[] = $keySession;
                sessionSet($key, $keys);
                sessionSet($keySession . 's', $key);
            }

            echo $keySession;
        }
    } else {
        die('Invalid file type.');
    }
}

die;
