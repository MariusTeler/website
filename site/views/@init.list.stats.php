<!-- Box - Stats -->
<div class="bg-primary py-4 py-md-4">
    <div class="container position-relative overflow-hidden overflow-lg-visible">
        <div class="pt-4 pb-5">
            <div class="row">
                <div class="col-xl-11 offset-xl-1">
                    <div class="d-flex justify-content-around pt-3 pt-lg-5 overflow-x-auto overflow-lg-visible">
                        <? foreach($listInfo['rows'] AS $i => $row) : ?>
                            <div class="d-flex align-items-center position-relative min-w-75 min-w-sm-40 min-w-lg-auto ms-5 ms-lg-0">
                                <span class="position-absolute top-0 left-0 mt-0 mt-lg-n4 ms-n4 ms-lg-n5 ps-lg-2 icon icon-dsc-down display-3 opacity-25"></span>
                                <span class="display-4 fw-bold lh-1"><?= $row['title'] ?></span>
                                <div class="d-flex flex-column justify-content-between ms-2">
                                    <span class="icon <?= $row['metadata']['icon'] ?> text-danger fs-5"></span>
                                    <span><?= $row['metadata']['subtitle'] ?></span>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>