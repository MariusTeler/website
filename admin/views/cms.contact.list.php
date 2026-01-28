<table class="table" id="datatable" cellspacing="0" style="width:100%">
    <thead>
    <tr>
        <th class="w-65" data-priority="1">Informatii</th>
        <th class="not-mobile">Data</th>
        <th class="not-mobile">Tip / IP</th>
        <th class="text-center" data-priority="1">Status</th>
        <? if (!$isHome) : ?>
            <th class="not-mobile"></th>
        <? endif; ?>
    </tr>
    </thead>
    <tbody id="sortable">
    <? foreach($list AS $row) : ?>
        <tr id="sort_<?= $row['id'] ?>">
            <td>
                <div class="row row-404 row-404-160">
                    <div class="col-sm-2 font-weight-normal">Nume:</div>
                    <div class="col-sm-10"><?= $row['name'] ?></div>
                    <div class="col-sm-2 font-weight-normal">Email:</div>
                    <div class="col-sm-10"><?= $row['email'] ?></div>
                    <div class="col-sm-2 font-weight-normal">Telefon:</div>
                    <div class="col-sm-10"><?= $row['phone'] ?></div>
                    <? if ($row['type'] == FORM_CONTACT) : ?>
                        <div class="col-sm-2 font-weight-normal">Subiect:</div>
                        <div class="col-sm-10"><?= $row['metadata']['subject'] ?></div>
                    <? endif; ?>
                    <? if ($row['type'] == FORM_CONTACT_BUSINESS) : ?>
                        <div class="col-sm-2 font-weight-normal">Volum zilnic de transport:</div>
                        <div class="col-sm-10"><?= $row['metadata']['volume'] ?></div>
                    <? endif; ?>
                    <div class="col-sm-2 font-weight-normal">Mesaj:</div>
                    <div class="col-sm-10"><?= nl2br($row['message']) ?></div>
                </div>
            </td>
            <td><?= date('d.m.Y H:i', $row['date']) ?></td>
            <td>
                <?= FORM_TYPES[$row['type']] ?><br />
                <?= $row['ip'] ?>
            </td>
            <td class="td-actions text-center <?= COLOR_CLASSES[$statusById[$row['status_id']]['color']] ?>">
                <? if ($row['status_id']) : ?>
                    <a href="<?= $curPage . '.edit&edit=' . $row['id'] . backVar() ?>" class="<?= COLOR_CLASSES[$statusById[$row['status_id']]['color']] ?>"><?= $statusById[$row['status_id']]['name'] ?></a>
                <? else : ?>
                    <? if (!$isHome) : ?>
                        <a href="<?= $curPage . '.edit&edit=' . $row['id'] . backVar() ?>" class="btn btn-sm btn-success">Rezolva</a>
                    <? else : ?>
                        <button class="btn btn-sm btn-success ajax-button" data-id="<?= $row['id'] ?>">Rezolva</button>
                    <? endif; ?>
                <? endif; ?>
            </td>
            <? if (!$isHome) : ?>
                <td class="td-actions text-right">
                    <a href="<?= $curPage . '.edit&edit=' . $row['id'] . backVar() ?>" class="btn btn-success float-right btn-sm btn-link btn-list-add" title="Vizualizeaza">
                        <span class="material-icons">visibility</span>
                    </a>
                </td>
            <? endif; ?>
        </tr>
    <? endforeach ?>
    </tbody>
</table>

<? parseVar('isDesktop', true, '@init.tables.mobile') ?>
<?= parseView('@init.tables.mobile') ?>

<? captureJavaScriptStart(); ?>
<style type="text/css">
    .w-65 {
        width: 65% !important;
    }
</style>
<? captureJavaScriptEnd(); ?>

<? if ($isAjax) : ?>
    <?= parseJavaScript() ?>
<? endif; ?>
