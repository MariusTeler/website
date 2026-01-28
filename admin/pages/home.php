<?php

if ($_GET['optimize']) {
    $dir = UPLOAD_PATH . '../site/images/img.bk/'; // the directory with your files
    $targetDir = $dir . '../img/';

    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            $path = $dir . $file;
            $targetPath = $targetDir . $file;

            if (is_file($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);

                print_v($path);
                print_v($ext);

                if (preg_match('/^(png)$/i', $ext)) {
                    $imageSize = getimagesize($path);

                    __img_resize($path, $targetPath, $imageSize[0], $imageSize[1], 9);
                } elseif (preg_match('/^(jpg|jpeg)$/i', $ext)) {
                    $imageSize = getimagesize($path);

                    __img_resize($path, $targetPath, $imageSize[0], $imageSize[1], 15);
                }
            }
        }
        closedir($handle);
    }
}
