<? $httpQuery = getVar('httpQuery', getPage()) ?>
<? if ($pages > 1) : ?>
    <hr class="my-4 opacity-100" />
    <nav class="pagenav">
        <ul class="pagination justify-content-center" style="--bs-border-width: 0;">
            <? if ($page_nr > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pageLink . ($page_nr > 2 ? '/pagina/' . ($page_nr - 1) : '') . buildHttpQuery($httpQuery) ?>">
                        <span class="icon icon-arrow-left-bold text-danger fs-5"></span>
                    </a>
                </li>
            <? endif; ?>
            <? for ($i=1; $i <= $pages; $i++) : ?>
                <?
                    if (
                        ($i == 1) ||
                        ($i > $page_nr - 3 && $i < $page_nr + 3) ||
                        ($i == $pages)
                    ) :
                ?>
                    <li class="page-item <?= $page_nr == $i ? 'active' : '' ?>">
                        <a class="page-link" <?= ($i != $page_nr) ? 'href="' . $pageLink . ($i != 1 ? '/pagina/' . $i : '') . buildHttpQuery($httpQuery) . '"' : '' ?>><?= $i ?></a>
                    </li>
                <? elseif ($page_nr >= 5 && $i == 2) : ?>
                    <li class="page-item">
                        <a class="page-link">...</a>
                    </li>
                <? elseif ($page_nr <= $pages - 4 && $i == $pages - 1) : ?>
                    <li class="page-item">
                        <a class="page-link">...</a>
                    </li>
                <? endif; ?>
            <? endfor; ?>
            <? if ($page_nr < $pages) : ?>
                <li class="page-item">
                    <a class="page-link lh-1"
                       href="<?= $pageLink . '/pagina/' . ($page_nr + 1) . buildHttpQuery($httpQuery) ?>"
                       style="transform: rotate(180deg);">
                        <span class="icon icon-arrow-left-bold text-danger fs-5"></span>
                    </a>
                </li>
            <? endif; ?>
        </ul>
    </nav><!-- pagenav -->
<? endif; ?>