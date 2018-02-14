// loading animation on submit button click
$('button, a[type=submit]').on('click', function(e) {
    var button = $(this);

    button.addClass('m-loader m-loader--light m-loader--right');
});

// modal confirmation
$('table[data-form="table"]').on('click', '.form-confirm', function(e) {
    e.preventDefault();

    let $form = $(this);

    $('#modal').modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
        $form.submit();
    });
});