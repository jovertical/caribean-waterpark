$(document).ready(function() {
    setTimeout(function() {
        $('#mdb-preloader').css({ display: 'none' });
    }, 1000);

    // SideNav Init
    $(".button-collapse").sideNav();

    // form

    $('button[type=submit]').on('click', function(e) {
        $('button').addClass('disabled');
    });

    $('input, select').on('change, keyup', function(e) {
        var $targetInput = $(this);

        if ($targetInput.hasClass('invalid')) {
            $targetInput.removeClass('invalid');

            $('div[id=' + $targetInput.attr('id') + '-error]').css({ display: 'none' });
        }
    });
});
