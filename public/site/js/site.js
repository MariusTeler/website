let isMobile;

$(document).ready(function(){
    // Check if tablet or mobile
    isMobile = $(window).width() <= 992;

    // --- Smooth scroll ---
    $('a[href*="#"]:not([href="#"])').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (
            location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'')
            && location.hostname === this.hostname
        ) {
            scrollToTarget(this.hash);
        }

        window.location = this.href;
    });
    // --- Smooth scroll (end) ---

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

    // --- Cookies dialog ---
    let $cookie = $('#cookie');

    if ($cookie.length) {
        if (document.cookie.replace(/(?:(?:^|.*;\s*)agreeCookie\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
            $cookie.removeClass('d-none');
        }

        $cookie.find('button').on('click', function(e) {
            document.cookie = "agreeCookie=true; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT";
            $cookie.addClass('d-none');
        });
    }
    // --- Cookies dialog (end) ---


    // --- Popover ---
    let $popover = $('#popover'),
        $popoverOverlay = $('#popoverOverlay'),
        $popoverMobile = $('#popoverMobile');

    if ($popover.length) {
        /*
        // Open popover by default on desktop
        if (document.cookie.replace(/(?:(?:^|.*;\s*)popoverCookie\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true" && !isMobile) {
            popoverToggle();
        }
        */

        // Close popover
        $popover.find('.close').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            document.cookie = "popoverCookie=true; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT";
            popoverToggle();
        });

        // Open popover from inline button
        $('body').on('click', '#popoverButton', function(e) {
            e.preventDefault();

            popoverToggle();
        });
    }

    if ($popoverMobile.length) {
        // Open popover intro if no cookies is set
        if (document.cookie.replace(/(?:(?:^|.*;\s*)popoverMobile\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
            $popoverMobile.toggle();
        }

        // Close popover intro
        $popoverMobile.find('.close').on('click', function() {
            document.cookie = "popoverMobile=true; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT";
            $popoverMobile.toggle();
        });

        // Open popover and close popover intro
        $popoverMobile.find('.button').on('click', function() {
            popoverToggle();
            $popoverMobile.find('.close').trigger('click');
        });
    }

    // Toggle popover visibility
    function popoverToggle() {
        $popover.toggle();
        $popoverOverlay.toggle();
    }
    // --- Popover (end) ---


    // --- Toggle View (start) ---
    $('body').on('click', '.toggle-view', function(e) {
        e.preventDefault();

        let target = $(this).data('target'),
            toggleSelf = $(this).data('toggle-self'),
            toggleSelfClass = $(this).data('toggle-self-class'),
            toggleSelfType = $(this).data('toggle-self-type'),
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
                    $(this).slideToggle(100);
                } else {
                    $(this).fadeToggle(100);
                }
            }

            if (toggleSelfClass) {
                $(this).toggleClass(toggleSelfClass);
            }

            if (toggleTargetType && toggleTargetType === 'slide') {
                $(target).slideToggle(toggleTargetTime ? toggleTargetTime : null);
            } else {
                $(target).fadeToggle(toggleTargetTime ? toggleTargetTime : null);
            }

            if (toggleScroll) {
                scrollToTarget(toggleScroll);
            }
        }

        return false;
    });
    // --- Toggle View (end) ---

    // Analytics tracking on click
    $('body').on('click', '.event-track', function() {
        eventAnalytics($(this));

        return true;
    });

    // Form open / close
    $('body').on('click', 'a.form-open', function(e) {
        e.preventDefault();
        e.stopPropagation();

        let $contactButton = $(this),
            $contactForm = $($contactButton.data('form'));

        // Get previous button that was hidden and show it
        if ($contactForm.prev().hasClass('form-open')) {
            $contactForm.prev().fadeIn();
        }

        // Check if button is on carousel
        if ($contactButton.closest('.home-images-container').length) {
            // Find next button that is not on the carousel container
            $('a.btn').each(function() {

                if (!$(this).closest('.home-images-container').length) {
                    // Assign new button
                    $contactButton = $(this);

                    // Scroll to new button
                    $('html,body').animate({
                        scrollTop: ($contactButton.offset().top - (isMobile ? 130 : 50))
                    }, 500);

                    return false;
                }
            });
        }

        // Insert form after button, hide button and show form
        $contactForm.insertAfter($contactButton);

        // Hide button if not inline link
        if (
            $contactForm.prev().hasClass('btn')
            && !$contactForm.prev().hasClass('btn-link')
        ) {
            $contactButton.hide();
        }

        $contactForm.fadeIn();

        // Scroll to form
        scrollToTarget('#' + $contactForm.attr('id'));
    });
});

function eventAnalytics($this, trackFacebook)
{

    if (typeof $this === 'string') {
        $this = $($this);
    }

    if (window.gtag) {
        gtag('event', $this.data('event-action'), {
            'event_category': $this.data('event-category'),
            'event_label': $this.data('event-label')
        });
    }

    if (trackFacebook && window.fbq) {
        fbq('track', 'Lead', {
            'content_name': $this.data('event-fbq') ? $this.data('event-fbq') : $this.data('event-category')
        });
    }
}

function scrollToTarget(target)
{
    let $target = $(target),
        menuHeight = 0,
        $notificationBar = $('.notification-bar'),
        $navMenu = $('.navbar.fixed-top');

    if ($navMenu.length) {
        menuHeight += $navMenu.outerHeight();
    }

    if (isMobile) {
        if ($notificationBar.length) {
            menuHeight += $notificationBar.outerHeight();
        }
    }

    if ($target.length) {
        $('html,body').animate({
            scrollTop: ($target.offset().top - menuHeight)
        }, 500);
    }
}

function redirectTimeout(URL, delay) {
    setTimeout(function() {
        document.location.href = URL;
    }, delay);
}
