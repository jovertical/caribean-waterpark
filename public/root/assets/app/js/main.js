// modal delete confirmation
$('table[data-form="table"]').on('click', '.form-delete', function(e) {
    e.preventDefault();

    let $form = $(this);

    $('#modal').modal({ backdrop: 'static', keyboard: false}).on('click', '#btn-confirm', function() {
        $form.submit();
    });
});