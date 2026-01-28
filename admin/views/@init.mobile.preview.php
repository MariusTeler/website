<script>
    $(document).ready(function () {
        $('body').on('click', '.showMobilePreview', function (e) {
            $('#mobilePreview').remove();

            $('<div>', {
                id: 'mobilePreview'
            }).appendTo('body');

            $('#mobilePreview')
            .append('<div id="hideMobilePreview" class="position-absolute p-2 bg-danger pointer"><span class="material-icons">power_settings_new</span></div><div id="mobilePreviewCon"><iframe src="" name="mobilePreviewFrame" id="mobilePreviewFrame" frameborder="0" height="100%" width="100%" ></iframe></div>')
            .draggable()
            .fadeIn(0);

            $('#mobilePreviewFrame').attr("src", $(this).data('href'));

            $('#hideMobilePreview').on('click', function (e) {
                $('#mobilePreview').remove();
            });
        });
    });

    $(document).keyup(function(e) {
        if (e.keyCode == 27) { // escape key maps to keycode `27`
            $('#mobilePreview').remove();
        }
    });

</script>

<style>
    #mobilePreview {
        position: fixed;
        top: calc((100vh - 800px) / 2);
        right: 10px;
        display: none;
        z-index: 10000;
    }
    @media only screen and (max-height: 800px){
        #mobilePreview {
            top: 1vh;
        }
    }
    #hideMobilePreview {
        display: grid;
        font-size: 2em;
        left: -2.2em;
        color: #fff;
        place-content: center;
        border-radius: 50%;
    }
    #hideMobilePreview .material-icons {
        font-size: 2.2rem;
    }
    #mobilePreview::before {
        content: '';
        display: block;
        height: calc(100% - 4.5em);
        background: #fff;
        position: absolute;
        width: 3.4em;
        z-index: -1;
        left: -4.4em;
        top: 4.5em;
        border-radius: 1em;
        box-shadow: 0 0 0.3em 0 rgb(0 0 0 / 25%) inset;
        cursor: grab;
    }
    #mobilePreviewCon{
        overflow: hidden;
        height: 98vh;
        max-height: 800px;
        width: 375px;
        border-radius:1em;
        background: #fff;
        box-shadow: 0 0 3px 0 rgb(0 0 0 / 25%);
    }
</style>