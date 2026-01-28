<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Administrare > Setari : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">
                <?= formReturn() ?>
                <div class="clear"></div>
                <form method="POST" action="" id="editForm" enctype="multipart/form-data" class="form-horizontal my-4">
                    <input type="hidden" name="formId" value="editForm" />
                    <input type="hidden" name="formRedirect" value="0" />
                    <input type="hidden" id="id" name="id" value="<?= $_GET['edit'] ?>" />
                    <div class="row">
                        <div id="editForm_errors_top" class="col-sm-10 offset-sm-2 text-danger <?= $eClass ?>">
                            Va rugam sa completati toate campurile necesare.
                            <ul></ul>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="name">Identificator:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="value">Valoare:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="value" name="value" class="form-control" rows="10"><?= $_POST['value'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="description">Descriere:</label></td>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea id="description" name="description" class="form-control" rows="5"><?= $_POST['description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>
            </div>
        </div>
    </div>
</div>

<? captureJavaScriptStart() ?>
<link rel="stylesheet" href="/public/site/js/vendor/codemirror-5.65.0/lib/codemirror.css">
<style type="text/css">
    .CodeMirror {
        height: auto;
        padding: 4px;
        border: 1px solid #bed1e4;
        box-shadow: 1px 1px 4px 0 #ddd inset;

    }
    .CodeMirror-scroll {
        overflow-y: hidden;
        overflow-x: auto;
    }
</style>
<script src="/public/site/js/vendor/codemirror-5.65.0/lib/codemirror.js"></script>
<script src="/public/site/js/vendor/codemirror-5.65.0/mode/javascript/javascript.js"></script>
<script src="/public/site/js/vendor/codemirror-5.65.0/addon/edit/matchbrackets.js"></script>
<script>
    var editor = CodeMirror.fromTextArea($('#value')[0], {
        lineNumbers: true,
        lineWrapping: true,
        //viewportMargin: 'Infinity',
        mode:  'javascript',
        matchBrackets: true
    });
    //editor.setSize(950, null);
</script>
<? captureJavaScriptEnd() ?>

