<!-- List - Q&A -->
<div class="container my-5 py-4 py-lg-5">
    <div class="position-relative my-lg-4 fw-light">
        <h2 class="mb-4 ls-wider"><?= $listInfo['title'] ?></h2>
        <div class="fs-5">
            <?= $listInfo['text'] ?>
        </div>
        <? foreach($listInfo['rows'] AS $i2 => $row) : ?>
            <? $qId =  $blockId . $i2; ?>
            <a href="javascript: void(0);"
               id="q-<?= $qId ?>"
               class="d-block position-relative h2 fs-3 ms-5 mb-4 fw-light text-decoration-none toggle-view"
               data-target="#q-a-<?= $qId ?>,#q-<?= $qId ?> .icon-plus,#q-<?= $qId ?> .icon-minus"
               data-toggle-target-time="10">
                <span class="position-absolute start-0 top-0 ms-n5 icon icon-plus fs-3 lh-base"></span>
                <span class="position-absolute start-0 top-0 ms-n5 icon icon-minus fs-3 lh-base hide"></span>
                <?= $row['title'] ?>
            </a>
            <div class="ms-5 mb-4 fs-5 hide" id="q-a-<?= $qId ?>">
                <?= $row['text'] ?>
            </div>
        <? endforeach; ?>
    </div>
</div>

<? if ($faqList && $faqCount == 1) : $i = 0; ?>
    <? captureJavaScriptStart(); ?>
    <!-- FAQ -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
        <? foreach($faqList as $row) : ?>
            <? foreach($row['rows'] as $row2) : ?>
                <?= $i++ ? ',' : '' ?>
                    {
                        "@type": "Question",
                        "name": "<?= $row2['title'] ?>",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "<?= htmlspecialchars(strip_tags($row2['text']), ENT_COMPAT, 'UTF-8', false) ?>"
                        }
                    }
                <? endforeach; ?>
        <? endforeach; ?>
        ]
    }
    </script>
    <? captureJavaScriptEnd(); ?>
<? endif; ?>