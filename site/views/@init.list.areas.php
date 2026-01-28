<!-- List - Areas -->
<div class="container my-5 py-4">
    <div class="position-relative fw-light">
        <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                <h2 class="ls-wide"><?= $listInfo['title'] ?></h2>
                <div class="mb-5 fs-5">
                    <?= $listInfo['text'] ?>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row w-75 w-md-100 mx-auto mx-md-0 flex-wrap align-items-md-stretch justify-content-around">
                    <? foreach($listInfo['rows'] AS $i => $row) : ?>
                        <div class="col-md-3 mx-3 mb-4 px-5 pt-4 corner text-center"
                             style="--background-color: var(--bs-danger-rgb); --border-color: var(--bs-danger);">
                            <span class="h2"><?= $row['title'] ?></span>
                            <?= $row['text'] ?>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>