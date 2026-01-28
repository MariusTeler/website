<? if (substr($cms['link_name'], 0, strlen('design-')) == 'Design-') : ?>
    <?= parseView('design.page.' . $cms['name']) ?>
<? else : ?>

<? foreach ($contentBlocks as $i => $block) : ?>
    <? if ($block['html']) : ?>
        <div class="container container-image-fluid my-4 my-lg-5 py-4 fw-light fs-5">
            <? if (!$i) : ?>
                <h1 class="mt-4 mt-lg-5 pt-5 ls-wide"><?= $cms['title'] ?: $cms['link_name'] ?></h1>
            <? endif; ?>
            <?= $block['html'] ?>
        </div>
    <? elseif ($block['type'] == ENTITY_LIST) : ?>
        <!-- List -->
        <? parseVar('isHome', $isHome, '@init.list') ?>
        <? parseVar('blockId', $block['id'], '@init.list') ?>
        <?= parseBlock('@init.list') ?>
    <? elseif ($block['type'] == ENTITY_VARIOUS) : ?>
        <!-- Various -->
        <? parseVar('isHome', $isHome, '@init.various') ?>
        <? parseVar('blockId', $block['id'], '@init.various') ?>
        <?= parseBlock('@init.various') ?>
    <? endif; ?>
<? endforeach; ?>

<? endif; ?>
