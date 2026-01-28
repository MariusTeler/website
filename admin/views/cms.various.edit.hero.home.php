<? parseVar('title', '', '@init.form.button') ?>
<? parseVar('prefix', 'button_', '@init.form.button') ?>
<? parseVar('pages', $pages, '@init.form.button') ?>
<? parseVar('pagesChildren', $pagesChildren, '@init.form.button') ?>
<?= parseView('@init.form.button') ?>

<h4 class="offset-md-2 mt-4">Box Tracking AWB</h4>
<hr class="mt-0 offset-md-2">
<div class="row mb-4">
    <label class="col-sm-2 col-form-label" for="hero_home_awb_title">Titlu:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="hero_home_awb_title" name="metadata[hero_home_awb_title]" value="<?= $_POST['metadata']['hero_home_awb_title'] ?>" class="form-control" />
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="hero_home_awb_text">Text:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <textarea id="hero_home_awb_text" name="metadata[hero_home_awb_text]" class="form-control"><?= $_POST['metadata']['hero_home_awb_text'] ?></textarea>
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="hero_tracking_page_id-row">Pagina:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <select name="metadata[hero_tracking_page_id]" id="hero_tracking_page_id-row" class="custom-select">
                <?= formSelectOptions($pages, 'link_name', 'hero_tracking_page_id', true, true, $pagesChildren) ?>
            </select>
        </div>
    </div>
</div>

<h4 class="offset-md-2 mt-4">Box mic secundar</h4>
<hr class="mt-0 offset-md-2">
<div class="row mb-4">
    <label class="col-sm-2 col-form-label" for="hero_home_secondary_title">Titlu:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="hero_home_secondary_title" name="metadata[hero_home_secondary_title]" value="<?= $_POST['metadata']['hero_home_secondary_title'] ?>" class="form-control" />
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="hero_home_secondary_text">Text:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <textarea id="hero_home_secondary_text" name="metadata[hero_home_secondary_text]" class="form-control"><?= $_POST['metadata']['hero_home_secondary_text'] ?></textarea>
        </div>
    </div>
</div>


<? parseVar('title', 'box mic secundar', '@init.form.button') ?>
<? parseVar('prefix', 'button2_', '@init.form.button') ?>
<? parseVar('pages', $pages, '@init.form.button') ?>
<? parseVar('pagesChildren', $pagesChildren, '@init.form.button') ?>
<?= parseView('@init.form.button') ?>

<?= formUploadFile() ?>

<? captureJavaScriptStart(); ?>
<script>
    $(document).ready(function() {
        $('#title').replaceWith('<textarea id="title" name="title" class="form-control"></textarea>');
        $('#title').val(`<?= $_POST['title'] ?>`);
    });
</script>
<? captureJavaScriptEnd(); ?>
