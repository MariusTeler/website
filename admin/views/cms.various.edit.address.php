<h4 class="offset-md-2 mt-4">Adresa</h4>
<hr class="mt-0 offset-md-2">
<div class="row mb-4">
    <label class="col-sm-2 col-form-label" for="address_title">Titlu:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="address_title" name="metadata[address_title]" value="<?= $_POST['metadata']['address_title'] ?>" class="form-control" />
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="address_text">Text:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <textarea id="address_text" name="metadata[address_text]" class="form-control"><?= $_POST['metadata']['address_text'] ?></textarea>
        </div>
    </div>
</div>