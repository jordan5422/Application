$(document).ready(function () {
    $('.tag').click(function () {
        var type = $(this).data('type'); // Récupère le type de recette sur lequel on a cliqué
        console.log("je suis dans le javascript");
        $.ajax({
            url: '../../application/filtres_recettes.php', // Nom du nouveau fichier PHP à créer pour le filtrage
            type: 'GET',
            data: {
                'type': type
            },
            success: function (data) {
                // Met à jour la liste des recettes avec les recettes filtrées retournées par le serveur
                $('.recipes-list').html(data);
            }
        });
    });

    

});



// $(document).ready(function () {
//     $('.like-btn').click(function () {
//         console.log("je suis dans les likes");
//         const recetteId = $(this).data('id');
//         $.ajax({
//             url: '../../application/handle_like.php',
//             type: 'POST',
//             data: { 'id_recette': recetteId },
//             success: function (data) {
//                 const result = JSON.parse(data);
//                 $('button[data-id="' + recetteId + '"]').next('.like-count').text(result.newLikeCount);
//             }
//         });
//     });
// });



