$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        var modal = $(this);
        $.get({
            url: $(this).attr('data-target'),
            success: function (data) {
                modal.find('.modal-body').html(data);
            }
        });
    });

    $(document).on('submit', 'form', function (e) {
        e.preventDefault();

        $form = $(e.target);
        modal = $('#exampleModal');

        var $submitButton = $form.find(':submit');
        $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
        $submitButton.prop('disabled', true);

        $.post({
            success: function (data) {
                console.log('ok !!!');
                // modal.modal('toggle');
            },


        });
    });
});


// $(document).ready(function () {
//     //On écoute le "click" sur le bouton ayant la classe "modal-trigger"
//     $('.modal-trigger').click(function () {
//         //On initialise la modale
//         $('.modal').modal();
//         //On récupère l'url depuis la propriété "Data-target" de la balise html <a>
//         url = $(this).attr('data-target');
//         //on fait un appel ajax vers l'action symfony qui nous renvoie la vue
//         $.get(url, function (data) {
//             //on injecte le html dans la modale
//             $('.modal-content').html(data);
//             //on ouvre la modale
//             $('#modal1').modal('open');
//         });
//     })
// });