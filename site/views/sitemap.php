<?
    header("Content-type: text/xml; charset=utf-8");
    header('Pragma: public');
    header('Cache-control: public, maxage=' . 60 * 60 * 24 * 7);
    header('Expires: ' . gmdate('D, d M Y H:i:s', strtotime('+7 days') . ' GMT'));
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>

<? if(!$items) : ?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <? foreach($sitemaps AS $row) : ?>
            <sitemap>
                <loc><?= $websiteURL . $row ?></loc>
                <lastmod><?= date('c', strtotime('-1 day')) ?></lastmod>
            </sitemap>
        <? endforeach; ?>
    </sitemapindex>
<? else : ?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
        <? foreach($items AS $row) : ?>
            <url>
                <loc><?= $row['loc'] ?></loc>
                <changefreq><?= $row['changefreq'] ?></changefreq>
                <priority><?= $row['priority'] ?></priority>
                <? if($row['lastmod']) : ?>
                    <lastmod><?= $row['lastmod'] ?></lastmod>
                <? endif; ?>
                <? if($row['image']) : ?>
                    <? foreach($row['image'] AS $image) : ?>
                        <image:image>
                            <image:loc><?= $image['loc'] ?></image:loc>
                            <? if($image['caption']) : ?>
                                <image:caption><?= $image['caption'] ?></image:caption>
                            <? endif; ?>
                        </image:image>
                    <? endforeach; ?>
                <? endif; ?>
            </url>
        <? endforeach; ?>
    </urlset>
<? endif ;?>