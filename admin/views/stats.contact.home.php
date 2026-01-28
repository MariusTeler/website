<div id="contactContainer">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">show_chart</i>
                    </div>
                    <h3 class="card-title">Statistici Contact</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive-no table-hover">
                        <div id="curve_chart" style="width: 100%; height: 350px;"></div>
                    </div>
                    <a href="<?= $curPage ?>" class="btn btn-success">Vezi toate statisticile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<? parseVar('legend', $legend, 'stats.graph') ?>
<? parseVar('legendPosition', $legendPosition, 'stats.graph') ?>
<? parseVar('graphPoints', $graphPoints, 'stats.graph') ?>
<?= parseView('stats.graph') ?>
