// $(document).ready(function () {
//     $('.registrationModal').click(function () {

//         $('#formPseudo').val($(this).data('form-pseudo'));
//         $('.modal').modal();
//         url = '/inscription';
//         $('#modal1').modal('show');
//         $.get(url, function (data) {
//             $('.modal-body').html(data)
//             $('#modal1').modal('show');
//         });
//     })

//     $('.validate').click(function () {
//         // console.log('hello!!');

//         var formPseudo = $('#formPseudo').val();
//         console.log(formPseudo);
//         $.post({
//             url: $(this).attr('data-target'),
//             success: function () {

//             }
//         });
//     });
// });

$(document).ready(function () {
    //On écoute le "click" sur le bouton ayant la classe "modal-trigger"
    $('.modal-trigger').click(function () {
        //On initialise la modale
        $('.modal').modal();
        //On récupère l'url depuis la propriété "Data-target" de la balise html <a>
        url = $(this).attr('data-target');
        //on fait un appel ajax vers l'action symfony qui nous renvoie la vue
        $.get(url, function (data) {
            //on injecte le html dans la modale
            $('.modal-content').html(data);
            //on ouvre la modale
            $('#modal1').modal('open');
        });
    })
});