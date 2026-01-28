<h4 class="offset-md-2 mt-4">
    Buton <?= $title ?>
    <button type="button"
            class="btn btn-sm btn-fill btn-outline-secondary float-right"
            style="margin-top: -0.5rem;"
            id="<?= $prefix ?>reset">
        Reseteaza
    </button>
</h4>
<hr class="mt-0 offset-md-2">
<div class="row">
    <label class="col-sm-2 col-form-label" for="<?= $prefix ?>text-row">Text buton:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" id="<?= $prefix ?>text-row" name="metadata[<?= $prefix ?>text]" value="<?= $_POST['metadata'][$prefix . 'text'] ?>" class="form-control" />
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label" for="<?= $prefix ?>type-row">Tip buton:</label>
    <div class="col-sm-4">
        <div class="form-group pt-1">
            <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" id="<?= $prefix ?>type-row" name="metadata[<?= $prefix ?>type]" value="page_id" <?= $_POST['metadata'][$prefix . 'page_id'] ? 'checked' : '' ?>> Pagina
                    <span class="circle">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="metadata[<?= $prefix ?>type]" value="link" <?= $_POST['metadata'][$prefix . 'link'] ? 'checked' : '' ?>> Link
                    <span class="circle">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <label class="col-sm-2 col-form-label" for="<?= $prefix ?>is_popup-row">Popup:</label>
    <div class="col-sm-4">
        <div class="form-group">
            <select id="<?= $prefix ?>is_popup-row" name="metadata[<?= $prefix ?>is_popup]" class="custom-select custom-select-filter">
                <?= formSelectOptions(['Nu', 'Da'], '', $prefix . 'is_popup', true, false) ?>
            </select>
        </div>
    </div>
</div>
<div class="row type-container <?= !$_POST['metadata'][$prefix. 'page_id'] ? 'd-none' : '' ?>">
    <label class="col-sm-2 col-form-label" for="<?= $prefix ?>page_id-row">Pagina:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <select name="metadata[<?= $prefix ?>page_id]" id="<?= $prefix ?>page_id-row" class="custom-select">
                <?= formSelectOptions($pages, 'link_name', $prefix . 'page_id', true, true, $pagesChildren) ?>
            </select>
        </div>
    </div>
</div>
<div class="row type-container <?= !$_POST['metadata'][$prefix . 'link'] ? 'd-none' : '' ?>">
    <label class="col-sm-2 col-form-label" for="<?= $prefix ?>link-row">Link:</label>
    <div class="col-sm-10">
        <div class="form-group">
            <input type="text" id="<?= $prefix ?>link-row" name="metadata[<?= $prefix ?>link]" value="<?= $_POST['metadata'][$prefix. 'link'] ?>" class="form-control" /> [ Ex: https://www.google.com , /contact , tel:+40722333444 , # , javascript: void(0); , etc. ]
        </div>
    </div>
</div>
<div class="mb-4"></div>

<? captureJavaScriptStart(); ?>
<script>
    $(document).ready(function () {
        $('#<?= $prefix ?>reset').on('click', function () {
            $('input[name="metadata[<?= $prefix ?>text]"]').val('');
            $('input[name="metadata[<?= $prefix ?>type]"]').prop('checked', false);
            $('select[name="metadata[<?= $prefix ?>is_popup]"]').val(0);
            $('input[name="metadata[<?= $prefix ?>type]"]').each(function () {
                $('#<?= $prefix ?>' + $(this).attr('value') + '-row').
                    val('').
                    trigger('change').
                    parents('.type-container').
                    addClass('d-none');
            });
        });

        $('input[name="metadata[<?= $prefix ?>type]"]').on('click', function () {
            let type = $(this).attr('value');

            $('input[name="metadata[<?= $prefix ?>type]"]').each(function () {
                if ($(this).attr('value') != type) {
                    $('#<?= $prefix ?>' + $(this).attr('value') + '-row').
                        val('').
                        trigger('change').
                        parents('.type-container').
                        addClass('d-none');
                }
            });

            $('#<?= $prefix ?>' + type + '-row').parents('.type-container').removeClass('d-none');
        });
    })
</script>
<? captureJavaScriptEnd(); ?>
