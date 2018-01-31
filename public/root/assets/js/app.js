// $(document).ready(function() {
    setTimeout(function() {
        $('#mdb-preloader').css({ display: 'none' });
    }, 1000);

    // SideNav Init
    $(".button-collapse").sideNav();

    var container = document.getElementById('slide-out');
    Ps.initialize(container, {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

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
// });
