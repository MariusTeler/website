<? if(is_array($initJcrop) && count($initJcrop)) : ?>
<script src="<?= $websiteURL ?>../public/site/js/vendor/jquery_jcrop/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="<?= $websiteURL ?>../public/site/js/vendor/jquery_jcrop/css/jquery.Jcrop.css" type="text/css"/>
<script>
    jQuery(function($) {
        <? foreach($initJcrop AS $j) : ?>
        $('#<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_jcrop').Jcrop({
            allowSelect: 0,
            allowResize: 0,
            minSize: [<?= $j['w'] ?>, <?= $j['h'] ?>],
            maxSize: [<?= $j['w'] ?>, <?= $j['h'] ?>],
            setSelect: [<?= $j['x'] ?>, <?= $j['y'] ?>, <?= $j['w'] ?>, <?= $j['h'] ?>],
            onChange: function(c) {
                $('#<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_x').val(c.x);
                $('#<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_y').val(c.y);
                $('#<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_w').val(c.w);
                $('#<?= $j['parent_dir'] ?>_<?= $j['dir'] ?>_<?= md5($j['image']) ?>_h').val(c.h);
            }
        });
        <? endforeach ?>
    });
</script>
<? endif ?>