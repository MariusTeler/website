<div class="row" id="row-subtitle">
    <label class="col-sm-2 col-form-label" for="contact_subtitle">Subtitlu:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <input type="text" id="contact_subtitle" name="metadata[contact_subtitle]" value="<?= $_POST['metadata']['contact_subtitle'] ?>" class="form-control" />
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label" for="contact_email">Email:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="contact_email" name="metadata[contact_email]" value="<?= $_POST['metadata']['contact_email'] ?>" class="form-control" />
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="contact_anchor">Anchor:</label>
    <div class="col-sm-4">
        <div class="form-group d-flex">
            <input type="text" id="contact_anchor" name="" value="#form-<?= $_POST['id'] ?>" class="form-control mr-2" disabled />
            <button type="button" id="btn-copy" class="btn btn-sm btn-outline-secondary">Copiaza</button>
        </div>
    </div>
</div>

<h4 class="offset-md-2 mt-3">Analytics</h4>
<hr class="mt-0 offset-md-2" />
<div class="row">
    <label class="col-sm-2 col-form-label" for="analytics_action">Action:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="analytics_action" name="metadata[analytics_action]" value="<?= $_POST['metadata']['analytics_action'] ?>" class="form-control" />
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="analytics_category">Category:</label>
    <div class="col-sm-4">
        <div class="form-group d-flex">
            <input type="text" id="analytics_category" name="metadata[analytics_category]" value="<?= $_POST['metadata']['analytics_category'] ?>" class="form-control" />
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label" for="analytics_label">Label:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="analytics_label" name="metadata[analytics_label]" value="<?= $_POST['metadata']['analytics_label'] ?>" class="form-control" />
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="analytics_facebook">Facebook:</label>
    <div class="col-sm-4">
        <div class="form-group d-flex">
            <input type="text" id="analytics_facebook" name="metadata[analytics_facebook]" value="<?= $_POST['metadata']['analytics_facebook'] ?>" class="form-control" />
        </div>
    </div>
</div>

<? captureJavaScriptStart(); ?>
<script>
    $(document).ready(function() {
        $('label[for="title"]').parent().after($('#row-subtitle'));

        $('#btn-copy').on('click', async function () {
            try {
                let $anchor = $('#contact_anchor');

                await navigator.clipboard.writeText($anchor.val());
                alert('Textul a fost copiat cu success si poate fi vazut dand "Paste".')
            } catch (error) {
                alert(error.message);
            }
        });
    });
</script>
<? captureJavaScriptEnd(); ?>