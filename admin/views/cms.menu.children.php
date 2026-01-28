<table class="table">
    <tbody id="sortable-<?= $parentId ?>">
        <? listSortable($parentId) ?>
        <? foreach($listChildren[$parentId] AS $childId) : $row = $list[$childId]; ?>
            <tr data-id="sort_<?= $row['id'] ?>">
                <td><?= listOrder($row, true, false, 'drag-' . $parentId) ?></td>
                <td class="w-75">
                    <a href="<?= $row['link'] ?>"
                       target="_blank"
                       class="<?= ($row['page_id'] && !$row['status']) ? 'text-danger' : 'text-success' ?>"
                    >
                        <?= $row['link_name'] ?: $row['p_link_name'] ?>
                    </a>
                </td>
                <td class="w-25 td-actions text-right">
                    <?= listEdit($row) ?>
                    <?= listDelete($row) ?>
                </td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>
