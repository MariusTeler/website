<div id="contactContainer">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">notifications</i>
                    </div>
                    <h3 class="card-title">Contact (<?= $listRows ?>)</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive-no table-hover">
                        <div class="clear"></div>
                        <?= parseView('cms.contact.list') ?>
                    </div>
                    <a href="<?= $curPage ?>" class="btn btn-success">Vezi toate cererile</a>
                </div>
            </div>
        </div>
    </div>
</div>
<? captureJavaScriptStart(); ?>
<script>
    $(document).ready(function() {
        // Add supplier
        $('#contactContainer').on('click', 'button.ajax-button', function() {
            ajaxRequest('<?= $curPage ?>.edit&edit=' + $(this).data('id') + '&modal=1');
        });
    });
</script>
<? if (!isMobile()) : ?>
    <? parseVar('minWidth', 650, '@init.modal') ?>
<? endif; ?>
<?= parseView('@init.modal') ?>
<? captureJavaScriptEnd(); ?>