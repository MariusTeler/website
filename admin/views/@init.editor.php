<? if(is_array($initEditor) && count($initEditor)) : ?>
<script src="<?= $websiteURL ?>../public/site/js/vendor/tinymce-4.7.1/tinymce.min.js"></script>
<script>
    <? foreach($initEditor AS $e) : ?>
    tinymce.init({
        selector: "#<?= $e['fieldId'] ?>",
        <? if (
                (!$_GET['edit'] && !userGetRight(ADMIN_RIGHT_ADD, $_SERVER['REQUEST_URI']))
                || ($_GET['edit'] && !userGetRight(ADMIN_RIGHT_EDIT, $_SERVER['REQUEST_URI']))
        ) : ?>
            readonly: 1,
        <? endif; ?>
        plugins: [
            "advlist autolink lists moxiemanager link image charmap print preview anchor hr",
            "searchreplace wordcount visualblocks code fullscreen",
            "media table contextmenu paste textcolor colorpicker charcount template pagebreak",
            "embed_facebook embed_instagram embed_pinterest embed_twitter embed_imgur embed_video <?= $e['plugins'] ?>"
        ],
        pagebreak_separator: "<div style=\"page-break-after: always;\"></div>",
        rel_list: [
            {title: 'None', value: ''},
            {title: 'Nofollow', value: 'nofollow'},
            {title: 'Sponsored', value: 'sponsored'},
            {title: 'User generated content (ugc)', value: 'ugc'}
        ],
        link_class_list: [
            {title: 'None', value: ''},
            {title: 'No underline', value: 'text-decoration-none'},
            {title: 'No underline + Bold', value: 'text-decoration-none fw-bold'}
        ],
        link_context_toolbar: true,
        menubar: 'file edit insert view format table tools',
        toolbar: "styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | template cmsblocks insertfile embed_video link image",
        extended_valid_elements: "script[language|type|type=|async=|defer=|src],blockquote[*],a[data-pin-do|data-pin-lang|data-pin-width|data-pin-terse|href|rel|target|class|title|caption],img[src|alt|title|caption|class|width|height|style]",
        relative_urls: false,
        min_height: 400,
        branding: false,
        visualblocks_default_state: true,
        paste_as_text: true,
        style_formats_merge: true,
        style_formats: [
            {
                title: 'Float left',
                selector: '*',
                classes: 'tinymce_float_left',
                styles: {
                    'float': 'left'
                }
            },
            {
                title: 'Float right',
                selector: '*',
                classes: 'tinymce_float_right',
                styles: {
                    'float': 'right'
                }
            },
            {
                title: 'Image left',
                selector: 'img',
                classes: 'tinymce_image_left',
                styles: {
                    'float': 'left',
                    'margin-right': '.5em'
                }
            },
            {
                title: 'Image right',
                selector: 'img',
                classes: 'tinymce_image_right',
                styles: {
                    'float': 'right',
                    'margin-left': '.5em'
                }
            },
            {
                title: 'Clearfix',
                selector: 'p',
                classes: 'tinymce_clearfix',
                styles: {
                    'clear': 'both',
                    'height': '0',
                    'margin': '0',
                    'padding': '0'
                }
            }
        ],
        templates: <?= json_encode($e['templates']) ?>,
        content_style: 'p[contenteditable="false"] { cursor: move !important; background-color: rgb(0, 172, 193, 0.07);}',
        setup: function(editor) {
            editor.on('drop', function(e) {
                let selection = tinymce.activeEditor.selection,
                    $currentNode = $(selection.getNode());

                // Set highest parent node
                while (!$currentNode.parent().is('body')) {
                    $currentNode = $currentNode.parent();
                }

                // If first child set cursor to beginning, otherwise to the end
                if ($currentNode.is(':first-child')) {
                    selection.setCursorLocation($currentNode[0], 0);
                } else {
                    // If target node is also non-editable
                    if ($currentNode.data('mce-bogus') === 'all') {
                        $currentNode = $currentNode.prev();
                        $currentNode.removeAttr('contenteditable');

                        setTimeout(function($currentNode) {
                            $currentNode.attr('contenteditable', 'false');
                        }, 200, $currentNode);
                    }

                    selection.select($currentNode[0]);
                    selection.collapse();
                }
            });
        },
        <? foreach ($e['options'] AS $key => $value) : ?>
            <?= "{$key}: '{$value}',\n" ?>
        <? endforeach; ?>
    });
    <? endforeach ?>
</script>
<style>
    .mce-menu.mce-fixed {
        max-height: 300px;
    }
</style>
<? endif ?>