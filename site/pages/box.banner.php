<?php

// Inline banner
$isInline = getVar('isInline', $p__);

// Get active banners
$banner = dbSelect(
    '*',
    'cms_banner',
    'status = 1 AND date_start <= UNIX_TIMESTAMP() AND (date_end = 0 OR date_end >= ' . strtotime('midnight') . ')',
    'date_start DESC, date_end DESC'
);

// Show first banner
$banner = array_shift($banner);

// Parse variable for popover banner
if ($isInline) {
    setView($p__, 'box.banner.inline');
}
