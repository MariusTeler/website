<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ro">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css" data-no-min>
        <?= $css ?>
    </style>
</head>
<body>
<div style="max-width: 600px; margin: 0 auto;">
    <table border="0" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF; width: 100%; max-width: 600px;">
        <tr>
            <td style="border-bottom: 1px solid #DCDCDC; text-align: left;">
                <img border="0" style="border: 10px solid #FFF; max-height: 50px;" src="<?= $websiteURL ?>public/<?= ASSETS_PATH ?>/images/<?= settingsGet('admin-logo') ?>" alt=""/>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 10px; height: 150px; font-size: 15px; line-height: 22px; color: #5c596c; text-align: left;" valign="middle"><?= $message ?></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #DCDCDC; padding: 10px; text-align: left;">&nbsp;</td>
        </tr>
    </table>
</div>
</body>
</html>