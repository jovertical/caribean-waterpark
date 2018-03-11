$('input, select').on('change keyup', function(e) {
    var input = $(this);

    $('span[id=' + input.attr('id') + '-error]').css({display: 'none'});
});