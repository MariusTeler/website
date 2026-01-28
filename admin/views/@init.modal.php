<? captureJavaScriptStart() ?>
<script>
    function showModal(id) {
        if ($('#' + id)) {
            $('#' + id).modal('show');
        }
    }

    function hideModal(id) {
        if ($('#' + id)) {
            $('#' + id).modal('hide');
        }
    }
</script>

<!-- Classic Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="<?= $minWidth ? "min-width: {$minWidth}px;" : '' ?>">
        <div class="modal-content" id="ajaxContainer" style="background-color: transparent;">
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<!--  End Modal -->
<? captureJavaScriptEnd() ?>