<div class="float-left">
    Pagina
    <? if($pageNr != 1) : ?>
    <span class="ml-2">
        <a href="<?= $paginationLink . ($pageNr - 1) ?>" class="btn btn-sm btn-success pl-3 pr-3"><i class="material-icons">chevron_left</i></a>
    </span>
    <? endif; ?>
    <span class="ml-2">
        <select name="" id="pagination<?= $iInit ?>" style="width: 70px;">
            <? for($i=1; $i <= $pages; $i++) : ?>
                <option value="<?= $i ?>" <?= $i == $pageNr ? 'selected' : '' ?>><?= $i ?></option>
            <? endfor; ?>
        </select>
    </span>
    <span class="mx-2">/ &nbsp;<?= $pages ?></span>
    <? if($pageNr < $pages) : ?>
        <a href="<?= $paginationLink . ($pageNr + 1) ?>" class="btn btn-sm btn-success pl-3 pr-3"><i class="material-icons">chevron_right</i></a>
    <? endif; ?>
</div>
<? captureJavaScriptStart() ?>
<script type="text/javascript">
    $(document).ready(function(evt, params) {
        $('#pagination<?= $iInit ?>').on('change', function() {
            document.location.href = '<?= $paginationLink ?>' + $(this).val();
        });
    });
</script>
<? captureJavaScriptEnd() ?>