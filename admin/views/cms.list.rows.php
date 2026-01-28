<div class="table-responsive-no table-hover">
    <span>[ Inregistrari: <span class="text-success"><?= count($list) ?></span> ]&nbsp;</span>
    <? if ($_GET['edit'] || $_GET['list_id']) : ?>
        <?= listAdd() ?>
        <? if ($listInfo['type'] == LIST_GALLERY) : ?>
            <a class="btn btn-sm btn-primary float-right btn-list-upload" href="<?= $curPage . '.edit&edit=0&upload=1' . backVar() ?>"><i class="material-icons" style="margin-top: -1.2em;">add_a_photo</i> &nbsp;Upload imagini</a>
        <? endif; ?>
    <? endif; ?>
    <div class="clear"></div>
    <table class="table" id="datatable" cellspacing="0" style="width:100%">
        <thead>
        <tr>
            <th data-priority="1">Ord.</th>
            <? if ($hasImage) : ?>
                <th data-priority="1">Imagine</th>
            <? endif; ?>
            <th class="w-25">
                <? if ($listInfo['type'] == LIST_FAQ) : ?>
                    Intrebare
                <? elseif ($listInfo['type'] == LIST_TESTIMONIAL) : ?>
                    Nume
                <? elseif ($listInfo['type'] == LIST_GALLERY) : ?>
                    Titlu
                <? elseif ($listInfo['type'] == LIST_JOBS) : ?>
                    Post
                <? elseif (in_array($listInfo['type'], [LIST_SERVICES_DARK, LIST_SERVICES_LIGHT, LIST_SERVICES_BIG])) : ?>
                    Serviciu
                <? elseif ($listInfo['type'] == LIST_STATS) : ?>
                    Cantitate
                <? elseif ($listInfo['type'] == LIST_CENTERS) : ?>
                    Localitate
                <? else : ?>
                    Titlu
                <? endif; ?>
            </th>
            <th class="not-mobile w-50">
                <? if ($listInfo['type'] == LIST_FAQ) : ?>
                    Raspuns
                <? elseif ($listInfo['type'] == LIST_TESTIMONIAL) : ?>
                    Testimonial
                <? elseif ($listInfo['type'] == LIST_GALLERY) : ?>
                    Descriere
                <? elseif ($listInfo['type'] == LIST_JOBS) : ?>
                    Descriere
                <? elseif (in_array($listInfo['type'], [LIST_SERVICES_DARK, LIST_SERVICES_LIGHT, LIST_SERVICES_BIG])) : ?>
                    Descriere
                <? elseif ($listInfo['type'] == LIST_STATS) : ?>
                    Unitate masura
                <? elseif ($listInfo['type'] == LIST_CENTERS) : ?>
                <? else : ?>
                    Text
                <? endif; ?>
            </th>
            <th class="text-center not-mobile">Home</th>
            <th class="text-center not-mobile">Status</th>
            <th data-priority="1"></th>
        </tr>
        </thead>
        <tbody id="sortable">
        <? foreach($list AS $row) : ?>
            <tr id="sort_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>">
                <td>
                    <?= listOrder($row, true, false) ?>
                </td>
                <? if ($hasImage) : ?>
                    <td>
                        <img width="75"
                             src="<?= imageLink(IMAGES_LIST, $thumbImage, $row['image'], LINK_RELATIVE, $row['image_timestamp']) ?>"
                             alt=""
                        />
                    </td>
                <? endif; ?>
                <td><?= $row['title'] ?></td>
                <td>
                    <div class="row-404 row-404-250">
                        <? if ($listInfo['type'] == LIST_STATS) : ?>
                            <?= $row['metadata']['subtitle'] ?>
                        <? elseif ($listInfo['type'] == LIST_CENTERS) : ?>
                        <? else : ?>
                            <?= $row['text'] ?>
                        <? endif; ?>
                    </div>
                </td>
                <td class="td-actions text-center">
                    <?= listStatus($row, 'is_home', $statusYesNo, true) ?>
                </td>
                <td class="td-actions text-center">
                    <?= listStatus($row, 'status', [], true) ?>
                </td>
                <td class="td-actions d-table-cell">
                    <?= listEdit($row) ?>
                    <?= listDelete($row) ?>
                </td>
            </tr>
        <? endforeach ?>
        </tbody>
    </table>
    <div class="clear"></div>
    <? if ($_GET['edit'] || $_GET['list_id']) : ?>
        <?= listAdd() ?>
        <? if ($listInfo['type'] == LIST_GALLERY) : ?>
            <a class="btn btn-sm btn-primary float-right btn-list-upload" href="<?= $curPage . '.edit&edit=0&upload=1' . backVar() ?>"><i class="material-icons" style="margin-top: -1.2em;">add_a_photo</i> &nbsp;Upload imagini</a>
        <? endif; ?>
    <? endif; ?>
    <?= parseView('@list.sortable.init') ?>
</div>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<? parseVar('isSearch', true, '@init.tables.mobile') ?>
<? parseVar('preserveFilters', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>

<? if (getVar('modal')) : ?>
    <script>
        filterSearch = '<?= json_decode($_GET['datatable'], true)['search'] ?>'
    </script>
    <?= parseJavaScript() ?>
<? else : ?>
    <? captureJavaScriptStart() ?>
    <script>
        $(document).ready(function() {
            // Open form in modal
            $('#list-rows-card-body').on('click', '.btn-list-add, .btn-list-upload, .btn.btn-success.btn-link', function(e) {
                e.preventDefault();
                let $this = $(this);

                ajaxRequest('<?= $curPage ?>.edit&edit='
                    + ($this.hasClass('btn-list-add') || $this.hasClass('btn-list-upload') ? 0 : $this.parents('tr').data('id'))
                    + '&modal=1'
                    + '&datatable=' + encodeURIComponent(JSON.stringify({search: $('#datatable').DataTable().search()}))
                    + '&upload=' + ($this.hasClass('btn-list-upload') ? 1 : 0)
                );

                return false;
            });

            // Prevent Bootstrap dialog from blocking focusin on TinyMCE
            $(document).on('focusin', function(e) {
                if ($(e.target).closest(".mce-window").length) {
                    e.stopImmediatePropagation();
                }
            });
        });
    </script>
    <? if (!isMobile()) : ?>
        <? parseVar('minWidth', '70%;', '@init.modal') ?>
    <? endif; ?>
    <?= parseView('@init.modal') ?>
    <? captureJavaScriptEnd() ?>
<? endif; ?>
