/* Help Button */
let $helpButton = $('#help-button');

$(document).ready(function() {

    /* Init Help */
    if (
        $helpButton.length
        && (
            $helpButton.data('page').substring($helpButton.data('page').length - 5) === '.edit'
            || $helpButton.data('page') === 'home'
        )
    ) {
        initHelpTooltip();
    }

    $('body').on('click', '#help-button', function(e) {
        e.preventDefault();
        unLoadHelpEditor();
        ajaxRequest('index.php?page=ajax.help&pg=' + $(this).data('page'), '', '');
    });

    $('#boxHelp').on('click', '#help-edit-button', function(e) {
        e.preventDefault();
        ajaxRequest('index.php?page=ajax.help&pg=' + $helpButton.data('page') + '&edit=1', '', '');
    });

    $('#boxHelp').on('click', '#help-close-button', function(e) {
        e.preventDefault();
        $('#boxHelp').fadeOut('fast');
        unLoadHelpEditor();
    });

    $('#boxHelp').on('click', '#help-save-button', function(e) {
        var $helpData = $('#helpData');

        e.preventDefault();
        $('#helpEditor').val(tinyMCE.get('helpEditor').getContent());
        ajaxRequest($helpData.attr('action'), [], 'POST', '#helpData');
        unLoadHelpEditor();
    });

    $('#boxHelp').on('click', '#help-more-button', function(e) {
        e.preventDefault();
        $('#legend-details').fadeToggle('fast');
    });
    /* Init Help (end) */


    /* Active menu */
    $('#sidebarNav .nav-link, #minimizeSidebar').on('click', function() {
        if ($(this).data('id')) {
            ajaxRequest('index.php?page=site.left&id=' + $(this).data('id'));
        }

        return true;
    });

    $('#toggleMenuDesktop').on('click', function() {
        $('#minimizeSidebar').click();

        return true;
    });
    /* Active menu (end) */

    /* Alerts */
    $('body').on('click', '.alert-holder .alert .close', function() {
        $(this).parent().fadeOut();
    });
    /* Alerts (enif) */

    /* Chars counter */
    $.fn.extend({
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });

    addCharLimit();
    /* Chars counter (end) */

    /* Refresh login session */
    setInterval(function() {
        ajaxRequest('index.php?page=ajax.session');
    }, 100000);
    /* Refresh login session (end) */

    // --- Toggle View (start) ---
    $('body').on('click', '.toggle-view', function(e) {
        e.preventDefault();

        let target = $(this).data('target'),
            toggleSelf = $(this).data('toggle-self'),
            toggleSelfClass = $(this).data('toggle-self-class'),
            toggleSelfType = $(this).data('toggle-self-type'),
            toggleSelfTime = $(this).data('toggle-self-time'),
            toggleTargetType = $(this).data('toggle-target-type'),
            toggleTargetTab = $(this).data('toggle-target-tab'),
            toggleTargetTime = $(this).data('toggle-target-time'),
            toggleScroll = $(this).data('toggle-scroll');

        if (target && target.length && $(target).length) {
            if (
                toggleTargetTab &&
                toggleTargetTab.length &&
                $(toggleTargetTab).length &&
                $(toggleTargetTab).css('display') !== 'none'
            ) {
                return false;
            }

            if (toggleSelf) {
                if (toggleSelfType && toggleSelfType === 'slide') {
                    $(this).slideToggle(toggleSelfTime);
                } else {
                    $(this).fadeToggle(toggleSelfTime);
                }
            }

            if (toggleSelfClass) {
                $(this).toggleClass(toggleSelfClass);
            }

            if (toggleTargetType && toggleTargetType === 'slide') {
                $(target).slideToggle(toggleTargetTime !== undefined ? toggleTargetTime : null);
            } else {
                $(target).fadeToggle(toggleTargetTime !== undefined ? toggleTargetTime : null);
            }

            if (toggleScroll) {
                scrollToTarget(toggleScroll);
            }
        }

        return false;
    });
    // --- Toggle View (end) ---

    // Show filters for mobile
    filtersMobile();
});

/* Init Help Functions */
function initHelpTooltip(page, modal)
{
    page = page || $helpButton.data('page');
    modal = modal || '';

    ajaxRequest('index.php?page=ajax.help&tooltip=1&pg=' + page + '&modal=' + modal, '', '');
}

function loadHelpEditor(editorId = 'helpEditor')
{
    if(typeof(tinyMCE) !== 'undefined') {
        tinyMCE.EditorManager.execCommand('mceAddEditor', false, editorId);
    }
}

function loadHelpTooltip(html, modal)
{
    let $html = $('<div/>').html(html),
        $container = modal ? $('#myModal') : $('div.content');

    // Find H4 titles in help that also have anchors that point to labels
    $html.find('h4 a[href*="#"]:not([href="#"])').each(function() {
        let anchor = $(this).attr('href').substring(1);
        let text = $(this).parent().next('p').text();

        if (anchor.length) {
            // Find label that matches anchor
            //let $label = $('div.content form label[for="' + anchor + '"]');
            let $label = $container.find('label[for="' + anchor + '"]');

            if ($label.length) {
                // Remove ":" from label text
                let labelText = $label.eq(0).text();

                if (labelText.substring(labelText.length - 1) === ':') {
                    $label.html(labelText.substring(0, labelText.length - 1) + '&nbsp;&nbsp;');
                }

                // Create and append tooltip
                let $tooltip = $('<i/>');

                $tooltip.text('help_outline')
                        .attr('rel', 'tooltip')
                        .addClass('material-icons')
                        .addClass('label-tooltip')
                        .data('title', text)
                        .on('click', function(e) {
                            e.stopPropagation();
                            e.preventDefault();
                        });
                $label.append($tooltip);
            }
        }
    });

    // Reinitialize tooltips
    $('[rel="tooltip"]').tooltip({
        trigger: "hover"
    });
}

function unLoadHelpEditor(editorId = 'helpEditor')
{
    if(typeof (tinyMCE) !== 'undefined') {
        tinyMCE.EditorManager.execCommand('mceRemoveEditor', false, editorId);
    }
}
/* Init Help Functions (end) */

/* Select2 Functions */
var replaceMap = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
};

function formatSelect2(state)
{
    if (state.ajax && state.el) {
        state.element = state.el;
    }

    if (state.element) {
        var $state = state.ajax ? state.element : $(state.element),
            $select = state.ajax ? $state : $(state.element).parent(),
            fields = $select.data('fields').split(':::'),
            data = state.ajax ? state : $state.data(),
            text = '',
            Utils = $.fn.select2.amd.require('select2/utils');

        const regex = /&nbsp;/gi;

        $.each(fields, function (i, field) {
            if (data[field]) {
                text += ($select.data(field) ? '<strong>' + $select.data(field) + ':</strong> ' : '')
                        + '&nbsp;'.repeat(data[field].toString().split('&nbsp;').length - 1)
                        + Utils.escapeMarkup(data[field].toString().replace(regex, ' '))
                        + ($select.data(field + '-no-br') ? '&nbsp;'.repeat(3) : '<br />');
            }
        });

        return $('<span>' + text + '</span>');
    } else {
        return state.text;
    }
}

function formatSelect2Products(state)
{
    var $element = $(state.element);

    if ($element.data('is-cat')) {
        return $('<strong style="font-size: 15px; ' + ($element.is(':disabled') ? 'color: #6D6C6C;' : '') + '">' + state.text + '</strong>');
    }

    return state.text;
}

function formatSelect2Selection(state)
{

    if (state.element) {
        var $state = $(state.element),
            $select = $(state.element).parent(),
            fieldsSelection = $select.data('fields-selection').split(':::'),
            data = $state.data(),
            text = '';

        const regex = /&nbsp;/gi;

        if (state.ajax) {
            data = state;
        }

        $.each(fieldsSelection, function (i, field) {
            if (data[field]) {
                if (text.length) {
                    text += ' / ';
                }

                text += '&nbsp;'.repeat(data[field].toString().split('&nbsp;').length - 1) +
                        data[field].toString().replace(regex, ' ');
            }
        });

        return $('<span>' + text + '</span>');
    } else {
        return state.text;
    }
}

function processResultsSelect2(data, params)
{
    var results,
        $this = this;

    results = $.map(data.items, function (item) {
        $.each(item, function (key, val) {
            item[key] = (val + '').replace(/(&amp;)|(&gt;)|(&lt;)|(&quot;)/g, function (match) {
                return replaceMap[match];
            });
        });

        item.ajax = 1;
        item.el = $this.$element;

        return item;
    });

    // parse the results into the format expected by Select2
    // since we are using custom formatting functions we do not need to
    // alter the remote JSON data, except to indicate that infinite
    // scrolling can be used
    params.page = params.page || 1;
    data.per_page = data.per_page || 30;
    return {
        //results: data.items,
        results: results,
        pagination: {
            more: (params.page * data.per_page) < data.total_count
        }
    };
}

function updateSelect2(field, data) {
    var $field = $('#' + field),
        $el = {},
        text = '';

    if ($field.length) {
        $field.empty();
        $.each(data, function (i, item) {
            $el = $('<option></option>').val(item.id);

            text = '';
            $.each(item, function (key, val) {
                val = val.replace(/(&amp;)|(&gt;)|(&lt;)|(&quot;)/g, function (match) {
                    return replaceMap[match];
                });

                text += ' ' + val;
                $el.data(key, val);
            });

            $el.text(text);
            $field.append($el);
        });
    }
}

function updateSelected(data) {
    $.each(data, function (i, item) {
        let $field = $('#' + item.id);
        if ($field.length) {
            let updatefield = function () {
                $field.val(item.value);

                if (item.trigger) {
                    $field.trigger(item.trigger);
                }
            };

            if (item.timeout) {
                setTimeout(updatefield, item.timeout);
            } else {
                updatefield();
            }
        }
    });
}

/* Select2 Functions (end) */

// Filters mobile
function filtersMobile() {
    $('form.form-filters-mobile').each(function () {
        var summaryId = $(this).data('summary'),
            $fields = $(this).find('input[type=text], input[type=email], input[type=number], input[type=tel], input[type=url], select'),
            summaryText = '';

        if (summaryId && summaryId.length && $fields.length) {
            $fields.each(function () {
                if ($(this).val().length) {
                    var label = $('label[for=' + $(this).attr('id') + ']').text(),
                        value,
                        nodeName = $(this).prop('nodeName');

                    if (nodeName == 'SELECT') {
                        value = $(this).find('option:selected').text();
                    } else {
                        value = $(this).val();
                    }

                    summaryText += '<span class="font-weight-normal">' + label + '</span> ';
                    summaryText += value;
                    summaryText += '<br />';
                }
            });

            if (summaryText.length) {
                summaryText = '<h5 class="mb-0">Filtre active</h5>' + summaryText;
                $(summaryId).html(summaryText);
            }
        }
    });
}
// Filters mobile (end)

// AJAX helper functions
function scrollToTarget(target)
{
    let $target = $(target),
        $container = null,
        menuHeight = 0,
        $notificationBar = $('.notification-bar'),
        $tableHeader = $('#datatable thead');

    if ($tableHeader.length) {
        menuHeight = $tableHeader.outerHeight();
    }

    if ($(window).width() <= 768) {
        menuHeight += $('.nav-menu').outerHeight();

        if ($notificationBar.length) {
            menuHeight += $notificationBar.outerHeight();
        }
    }

    if ($target.length) {
        let topScroll = $target.offset().top;

        if (menuHeight) {
            topScroll -= menuHeight;
        }

        if ($('html').hasClass('perfect-scrollbar-on')) {
            topScroll += $('.main-panel').scrollTop();
            $container = $('.main-panel');
            //document.querySelector('.main-panel').scrollTop = topScroll;
        } else {
            $container = $('html, body');
        }

        $container.animate({
            scrollTop: topScroll
        }, 500);
    }
}

function redirectTimeout(URL, delay) {
    setTimeout(function() {
        if (URL == 'reload') {
            location.reload();
        } else {
            document.location.href = URL;
        }
    }, delay);
}
// AJAX helper functions (end)

// Chars counter functions
function addCharLimit() {
    $('input.char-limit, textarea.char-limit').each(function() {
        var limit = $(this).data('limit'),
            $counter = $($(this).data('limit-counter'));

        if (limit && $counter.length) {
            if ($(this).val().length > limit) {
                limit = $(this).val().length;
            }

            $(this).limiter(limit, $counter);
        }
    });
}
// Chars counter functions (end)