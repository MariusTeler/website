<table class="table">
    <tbody id="sortable-<?= $parentId ?>">
        <? listSortable($parentId) ?>
        <? foreach($listChildren[$parentId] AS $childId) : $row = $list[$childId]; ?>
            <tr data-id="sort_<?= $row['id'] ?>">
                <td><?= listOrder($row, true, false, 'drag-' . $parentId) ?></td>
                <td class="w-75">
                    <a href="<?= makeLink(LINK_RELATIVE, $list[$parentId], $row) ?>" target="_blank" class="<?= ($row['status']) ? 'text-success' : 'text-danger' ?>">
                        <?= $row['link_name'] ?>
                        <span class="btn btn-sm btn-link btn-primary my-0 py-0 px-0">
                            <i class="material-icons">desktop_windows</i>
                        </span>
                    </a>
                    <a class="showMobilePreview btn btn-sm btn-link btn-primary my-0 py-0 px-0"
                       target="mobilePreviewFrame"
                       data-href="<?= makeLink(LINK_RELATIVE, $list[$parentId], $row) . '?preview=1&mobilePreview=1' ?>">
                        <i class="material-icons">phone_iphone</i>
                    </a>
                   <?= listSEO($row) ?>
                </td>
                <td class="w-25 td-actions text-right">
                    <?= listEdit($row) ?>
                    <?= listDelete($row) ?>
                </td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>
