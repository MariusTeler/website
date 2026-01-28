<div class="row">
    <div class="col-md-12">
        <div class="card <?= $modal ? 'my-0' : '' ?>">
            <div class="card-header card-header-success card-header-text">
                <? if (!$modal) : ?>
                    <div class="card-text">
                        <h4 class="card-title">Continut > Liste > Linie</h4>
                    </div>
                <? else : ?>
                    <div class="card-text">
                        <h4 class="card-title">Linie</h4>
                    </div>
                    <button type="button" class="float-right btn-close close close-ajax"
                            data-dismiss="modal"
                            href="#">
                        <i class="material-icons">close</i>
                    </button>
                <? endif; ?>
            </div>
            <div class="card-body px-3">
                <? if (!$modal) : ?>
                    <?= formReturn('#list-rows', 'Inapoi la lista') ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
