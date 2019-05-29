$(document).ready(function () {
    $('.modal-trigger').click(function () {
        $('.modal').modal();
        url = $(this).attr('data-target');
        $.get(url, function (data) {
            $('.modal-body').html(data)
            $('#modal1').modal('show');
        });
    })
});