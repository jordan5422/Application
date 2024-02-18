function post(donnees, url) {
    $.ajax({
        url: url, // L'URL du script PHP qui traitera les données
        type: 'POST', // Méthode de la requête
        contentType: 'application/json', // Type de contenu envoyé
        data: JSON.stringify(donnees), // Conversion du tableau en chaîne JSON
        success: function (response) {
            console.log('Données envoyées avec succès:', response);
        },
        error: function (xhr, status, error) {
            console.error('Erreur lors de l\'envoi:', error);
        }
    });
}
