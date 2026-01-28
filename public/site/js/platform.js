debug = 0;

function ajaxRequest(URL, callers, requestType, formSelector)
{
    URL += '&ajax=1';
    sendData = '';

    if(!callers)
        callers = [];

    for(var i = 0; i < callers.length; i++)
    {
        var $el = $('#' + callers[i]);
        var elValue = '';
        if($el.length)
        {
            if(($el.is(':radio') || $el.attr('name').slice(-2) == '[]') && !$el.data('no-group'))
            {
                if($el.attr('name').length)
                {
                    elValue = $el.closest('form').find('input[name="' + $el.attr('name') + '"],select[name="' + $el.attr('name') + '"],textarea[name="' + $el.attr('name') + '"]').serialize();
                }
            }
            else
            {
                elValue = $el.serialize();
            }

            if (!elValue.length && ($el.attr('name').slice(-2) == '[]' || $el.is(':checkbox'))) {
                elValue = $el.attr('name') + '=';
            }

            if(elValue.length)
                sendData += elValue + '&';
        }
    }

    if(formSelector) {
        sendData = $(formSelector).serialize();
    }

    if(debug)
    {
        console.log(callers);
        console.log(sendData);
        console.log(URL);
    }

    //$.getJSON(URL, function(data){
    $.ajax(URL, {
        type : (requestType ? requestType : 'GET'),
        dataType : 'json',
        data : sendData,
        success : function(data) {

        $.each(data.contents, function(i, item) {
            $el = $('#' + item.id);
            if($el.length) {
                $el.html(item.value);

                if (item.trigger) {
                    $el.trigger(item.trigger);
                }
            }
        });

        $.each(data.options, function(i, item) {
            $el = $('#' + item.id);
            if($el.length)
            {
                $el.empty();
                $.each(item.value, function(i, item) {
                    $el.append($('<option></option>').val(item.value).text(item.text));
                });

                if (item.trigger) {
                    $el.trigger(item.trigger);
                }
            }
        });

        $.each(data.fields, function(i, item) {
            $el = $('#' + item.id);
            if($el.length)
            {
                if($el.is(':checkbox'))
                {
                    if(item.value == 'checked')
                        $el.prop('checked', true);
                    else
                        $el.prop('checked', false);
                }
                else
                {
                    if($el.is(':radio'))
                    {
                        $el.closest('form').children('input[name="' + $el.attr('name') + '"]').prop('checked', false);
                        if(item.value.length)
                            $el.closest('form').children('input[name="' + $el.attr('name') + '"][value="' + item.value + '"]').prop('checked', true);
                    }
                    else
                        $($el.val(item.value));
                }

                if (item.trigger) {
                    $el.trigger(item.trigger);
                }
            }
        });

        $.each(data.css, function(i, item) {
            $el = $('#' + item.id);
            if($el.length) {
                $el.css(item.property, item.value);

                if (item.trigger) {
                    $el.trigger(item.trigger);
                }
            }
        });

        $.each(data.attributes, function(i, item) {
            $el = $('#' + item.id);
            if($el.length) {
                $el.attr(item.attribute, item.value);

                if (item.trigger) {
                    $el.trigger(item.trigger);
                }
            }
        });

        $.each(data.functions, function(i, item) {
            if(window[item.id])
            {
                /*switch(item.params.length)
                {
                    case 0 :
                        window[item.id]();
                        break;
                    case 1:
                        window[item.id](item.params[0]);
                        break;
                    case 2:
                        window[item.id](item.params[0], item.params[1]);
                        break
                    case 3:
                        window[item.id](item.params[0], item.params[1], item.params[2]);
                        break;
                    case 4:
                        window[item.id](item.params[0], item.params[1], item.params[2], item.params[3]);
                        break;
                    case 5:
                        window[item.id](item.params[0], item.params[1], item.params[2], item.params[3], item.params[4]);
                        break;
                }*/
                window[item.id].apply(null, item.params);
            }
        });
        }
    });
}

function formPostById(id)
{
    $('#' + id)[0].submit();
}

function formReactivateById(id)
{
    $('#' + id + '_submit').fadeTo(0, 1);
    $('#' + id + '_submit').prop('disabled', false);
    $('#' + id + '_submit').val($('#' + id + '_submit').data('message-normal'));
}