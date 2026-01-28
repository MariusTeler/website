<? global $listRows ?>
<div class="d-md-none" id="form-filters-summary"></div>
<div class="text-center d-md-none">
    <a class="btn btn-default btn-sm text-center toggle-view"
       data-target="#form-filters-mobile, #form-filters-hide"
       data-toggle-self="1"
       data-toggle-self-time="0"
       id="form-filters-show"
       href="#">Arata Filtre <i class="material-icons">expand_more</i></a>
    <a class="btn btn-default btn-sm hidden toggle-view"
       data-target="#form-filters-mobile, #form-filters-show"
       data-toggle-self="1"
       data-toggle-self-time="0"
       id="form-filters-hide"
       href="#">Ascunde Filtre <i class="material-icons">expand_less</i></a>
    [ Inregistrari: <span class="text-success"><?= $listRows ?></span> ]
    <div class="dropdown-divider"></div>
</div>