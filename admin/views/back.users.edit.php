<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-text">
                <div class="card-text">
                    <h4 class="card-title">Utilizatori > Administratori : <?= (($_GET['edit']) ? 'Modifica' : 'Adauga' ) ?></h4>
                </div>
            </div>
            <div class="card-body px-3">

                <?= formReturn() ?>
                <? if ($_GET['edit']) : ?>
                    <button class="btn btn-sm btn-danger px-2"
                            type="button"
                            onclick="if (confirm('Confirmati trimiterea notificarii?')) { document.location.href = document.location.href + '&new_account=1' }"
                    >Notificare cont nou</button>
                <? endif; ?>
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
                        <label class="col-sm-2 col-form-label" for="name">Nume:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="email">Email:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="email" name="email" value="<?= $_POST['email'] ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="pass">Parola:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" id="pass" name="pass" value="" class="form-control col-12 col-sm-6 float-left" autocomplete="off" />
                                <button class="btn btn-sm btn-danger float-right"
                                        type="button"
                                        onclick="if (confirm('Confirmati resetarea parolei?')) { document.location.href = document.location.href + '&reset_password=1' }"
                                    <?= $_GET['edit'] ? '' : 'disabled' ?>
                                >Reseteaza parola</button>
                                <input type="button" id="passGenerator" class="btn btn-sm btn-fill btn-warning float-right" value="Genereaza" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="access">Tip user:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="access" name="access" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(ADMIN_TYPES, '', 'access', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row hidden" id="companyRow">
                        <label class="col-sm-2 col-form-label" for="company_id">Firma:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="company_id" name="company_id" class="custom-select">
                                    <?= formSelectOptions($companies, 'name', 'company_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="status">Status:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="status" name="status" class="custom-select custom-select-filter">
                                    <?= formSelectOptions(STATUS_TYPES, '', 'status', true, false) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="profile_id">Profil access:</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select id="profile_id" name="profile_id" class="custom-select custom-select-filter">
                                    <?= formSelectOptions($profiles, 'name', 'profile_id', true) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="userRights">
                        <?= parseBlock('back.users.rights') ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-fill btn-success" value="Salveaza" />
                            </div>
                        </div>
                    </div>
                    <? parseVar('entityId', $_GET['edit'], 'user.actions') ?>
                    <? parseVar('entityType', ENTITY_BACK_USER, 'user.actions') ?>
                    <?= parseBlock('user.actions') ?>
                </form>
                <div class="clear"></div>
                <?= formReturn() ?>

            </div>
        </div>
    </div>
</div>

<? captureJavaScriptStart() ?>
<script>
    $(document).ready(function() {
        $('#passGenerator').on('click', function() {
            var $text = $('<input type="text" style="opacity: 0;" />'),
                charcodes = [[65, 90], [97, 122], [48, 57]],
                charCategory,
                pass = '';

            for (var i = 0; i <= 8; i++) {
                charCategory = Math.round(Math.random() * 2);
                pass += String.fromCharCode(Math.round(Math.random() * (charcodes[charCategory][1] - charcodes[charCategory][0]) + charcodes[charCategory][0]));
            }

            $text.val(pass).appendTo('body');
            $text[0].select();

            if (document.execCommand('Copy')) {
                $('#pass').val(pass);
                $text.remove();
                alert('Parola a fost generata si copiata si poate fi vazuta dand "Paste".');
            } else {
                alert('Eroare: Parola nu a putut fi generata si copiata.');
            }
        });

        $('#profile_id').on('change', function() {
            ajaxRequest('<?= $_SERVER['REQUEST_URI'] ?>', ['profile_id']);
        });

        $('#access').on('change', function() {
            showCompanies();
        });

        showCompanies();
    });

    function showCompanies() {
        let $company = $('#companyRow');

        if (
            $('#access').val() !== '<?= ADMIN_SUPERADMIN ?>'
            && $('#access').val() !== '<?= ADMIN_NORMAL ?>'
        ) {
            $company.removeClass('hidden');
        } else {
            $company.addClass('hidden');
        }
    }
</script>
<? captureJavaScriptEnd() ?>
