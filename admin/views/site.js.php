<!--   Core JS Files   -->
<script src="/public/admin/js/core/popper.min.js"></script>
<script src="/public/admin/js/core/bootstrap-material-design.min.js"></script>
<script src="/public/admin/js/plugins/perfect-scrollbar.min.js"></script>

<!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
<script src="/public/admin/js/material-dashboard.min.js?v=<?= settingsGet('version-admin-material-dashboard.min.js') ?>"></script>

<!-- Dashboard scripts -->
<!-- Library for adding dinamically elements -->
<!--<script src="/public/admin/js/plugins/arrive.min.js" type="text/javascript"></script>-->

<script> var websiteURL = '<?= $websiteURL ?>'; </script>
<script src="/public/site/js/platform.min.js?v=<?= settingsGet('version-platform.min.js') ?>"></script>
<script src="/public/admin/js/site.min.js?v=<?= settingsGet('version-admin-site.min.js') ?>"></script>

<style type="text/css">
    .custom-select {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
    }

    body .ui-datepicker .ui-datepicker-title select,
    body .ui-timepicker-div.ui-timepicker-oneLine select {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
    }
</style>