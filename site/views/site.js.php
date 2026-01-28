<? /*
<link href='//fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/public/site/js/vendor/jquery_fancybox-v3.0/jquery.fancybox.min.css" type="text/css" media="screen" />
*/ ?>
<?= settingsGet('analytics-codes-footer') ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= $websiteURL ?>public/site/js/vendor/jquery/jquery-3.6.0.min.js"><\/script>')</script>

<? /*
<script src="/public/site/js/vendor/jquery_fancybox-v3.0/jquery.fancybox.min.js"></script>
*/ ?>

<script> var websiteURL = '<?= $websiteURL ?>';</script>
<script src="/public/site/js/platform.min.js?v=<?= settingsGet('version-platform.min.js') ?>"></script>
<script src="/public/site/js/site.min.js?v=<?= settingsGet('version-site.min.js') ?>"></script>

<script src="/public/<?= ASSETS_PATH ?>/js/script.min.js?v=<?= settingsGet('version-site.min.js') ?>"></script>
<? /*
<script src="https://maps.googleapis.com/maps/api/js?key=<?= settingsGet('google-api-key') ?>&language=<?= getLang() ?: LANG_DEFAULT ?>"></script>
<script>
$(document).ready(function() {

    // Add map
    $('.map').each(function() {
        var latLng = $(this).data('map').split(',');
        var myLatlng = new google.maps.LatLng(latLng[0],latLng[1]);

        var mapOptions = {
            zoom: 17,
            center: myLatlng,
            clickableIcons: false,
            streetViewControl: false,
            mapTypeControl: false,
            scrollwheel: false
        };

        var map = new google.maps.Map($(this)[0], mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '',
        });

        var infowindow = new google.maps.InfoWindow({
            maxWidth: 280,
            content: '<div style="margin-right: 5px; margin-bottom: 5px;">'
                + $(this).data('address')
                + '</div>'
        });

        infowindow.open(map,marker);

        google.maps.event.addListener(map, 'click', function(event){
            this.setOptions({
                draggable:true
            });
        });
    });

});
</script>
*/ ?>
