$.getScript("javascripts/services/servicesHttp.js", function () {
    console.log("servicesHttp.js chargé !");
    // Une fois que le script est chargé, exécutez votre code
    $(document).ready(function () {
        $("#monumentInfo").ready(function (event) {
            AfficherMonument();
        });
    });
});

function AfficherMonument() {
    console.log("Afficher les monuments");

    // Appel de la fonction AJAX pour récupérer les monuments
    getMonuments(function (response) {
        // Vérifier si la requête a réussi
        var success = response.IsOk;
        if (success) {
            // Récupérer les données des monuments
            var monumentsData = response.data;

            // Afficher les informations des monuments dans l'élément "monumentInfo"
            var monumentInfoElement = document.getElementById("monumentInfo");
            monumentInfoElement.innerHTML = monumentsData;

            // Ajouter des classes CSS en fonction de la longueur du contenu
            var elements = monumentInfoElement.querySelectorAll('.text-holder');
            elements.forEach(function (element) {
                // Récupérer la longueur du texte
                var textLength = element.textContent.length;

                // Ajouter des classes CSS en fonction de la longueur du texte
                if (textLength > 50) {
                    element.classList.add('long-text');
                } else {
                    element.classList.add('short-text');
                }
            });
        } else {
            // Gérer le cas où la requête a échoué
            var monumentInfoElement = document.getElementById("monumentInfo");
            monumentInfoElement.innerHTML = "La récupération des monuments a échoué.";
        }
    }, function (error) {
        console.error("Erreur lors de la récupération des monuments :", error);
    });
}
