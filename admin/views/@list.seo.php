<? if (!$row['site_title']) : ?>
    <br />
    <span class="btn btn-sm btn-link btn-danger my-0 py-0 px-0"><i class="material-icons">clear</i></span>
    <span class="text-danger">SEO Title</span>
<? endif; ?>
<? if (!$row['site_description']) : ?>
    <br />
    <span class="btn btn-sm btn-link btn-danger my-0 py-0 px-0"><i class="material-icons">clear</i></span>
    <span class="text-danger">SEO Description</span>
<? elseif (strlen($row['site_description']) < 50) : ?>
    <br />
    <span class="btn btn-sm btn-link btn-warning my-0 py-0 px-0"><i class="material-icons">short_text</i></span>
    <span class="text-warning">SEO Description Scurt</span>
<? endif; ?>