<h4 class="offset-md-2 mt-3">Optiuni</h4>
<hr class="mt-0 offset-md-2" />
<div class="row">
    <label class="col-sm-2 col-form-label" for="hero_tracking_awb">Formular Tracking AWB:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <select id="hero_tracking_awb" name="metadata[hero_tracking_awb]" class="custom-select custom-select-filter">
                <?= formSelectOptions(['Nu', 'Da'], '', 'hero_tracking_awb', true, false) ?>
            </select>
        </div>
    </div>
</div>

<h4 class="offset-md-2 mt-3">Imagine background</h4>
<hr class="mt-0 offset-md-2" />
<div class="row">
    <label class="col-sm-2 col-form-label" for="hero_bg_transparent">Cu background transparent:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <select id="hero_bg_transparent" name="metadata[hero_bg_transparent]" class="custom-select custom-select-filter">
                <?= formSelectOptions(['Nu', 'Da'], '', 'hero_bg_transparent', true, false) ?>
            </select>
        </div>
    </div>
</div>
<?= formUploadFile() ?>