<div class="row">
    <label class="col-sm-2 col-form-label" for="address">Adresa:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <input type="text" id="address" name="metadata[address]" value="<?= $_POST['metadata']['address'] ?>" class="form-control float-left col-sm-10" autocomplete="off" />
            <button type="button" class="btn btn-sm btn-warning float-right px-2 button-map">
                Cauta pe harta
            </button>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label" for="map">Localizare:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <input type="hidden"
                   id="map"
                   name="metadata[map]"
                   value="<?= $_POST['metadata']['map'] ?>"
                   data-map="<?= $_POST['LatLng'] ?>"
                   data-zoom="<?= $_POST['zoom'] ?>"
            />
            <div id="map-canvas" style="width: 100%; height: 350px;"></div>
        </div>
    </div>
</div>
<?= parseView('@init.map') ?>