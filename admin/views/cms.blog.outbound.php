<? if ($outboundLinks && is_array($outboundLinks)) : ?>
    <ul class='pl-2'>
        <? foreach($outboundLinks AS $l) : ?>
            <li class='text-truncate'><a href='<?= $l ?>' target='_blank'><?= htmlspecialchars($l) ?></a></li>
        <? endforeach; ?>
    </ul>
<? endif; ?>