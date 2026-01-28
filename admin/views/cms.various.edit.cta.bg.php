<? parseVar('title', '', '@init.form.button') ?>
<? parseVar('prefix', 'button_', '@init.form.button') ?>
<? parseVar('pages', $pages, '@init.form.button') ?>
<? parseVar('pagesChildren', $pagesChildren, '@init.form.button') ?>
<?= parseView('@init.form.button') ?>

<? parseVar('title', 'secundar', '@init.form.button') ?>
<? parseVar('prefix', 'button2_', '@init.form.button') ?>
<? parseVar('pages', $pages, '@init.form.button') ?>
<? parseVar('pagesChildren', $pagesChildren, '@init.form.button') ?>
<?= parseView('@init.form.button') ?>

<h4 class="offset-md-2 mt-3">Imagine background</h4>
<hr class="mt-0 offset-md-2" />
<div class="row">
    <label class="col-sm-2 col-form-label" for="cta_bg_position">Pozitionare:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <select id="cta_bg_position" name="metadata[cta_bg_position]" class="custom-select custom-select-filter">
                <?= formSelectOptions($bgPosition, '', 'cta_bg_position', true, false) ?>
            </select>
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="cta_bg_opacity">Opacitate:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <select id="cta_bg_opacity" name="metadata[cta_bg_opacity]" class="custom-select custom-select-filter">
                <?= formSelectOptions($bgOpacity, '', 'cta_bg_opacity', true, false) ?>
            </select>
        </div>
    </div>
</div>
<?= formUploadFile() ?>
