$.getScript("javascripts/services/servicesHttp.js", function () {
	console.log("servicesHttp.js chargé !");



	$(document).ready(function () {
		$("#btnCreer").click(function (event) {
			event.preventDefault(); // pour afficher les echos / permission
			console.log("Button créer presser");
			user = $("#name").val();
			console.log("utilisateur  = ", user);
			ajouterPays(user);
		});
	})
});
function ajouterPays(user) {

	// Appel de la fonction AJAX pour se connecter
	createpays(user, function (response) {
		console.log(response);

		// Récupération des propriétés de la réponse JSON
		var success = response.IsOk;
		var message = response.message;
		console.log(success);
		if (success) {
			alert("Pays créer avec succès : ");

			window.location.href = 'indexLogin.html';

		} else {
			alert("Vous n'avez pas pu vous connecter : " + message);
		}
	}, function (error) {

		alert("Erreur lors de la création du monument");
	});
}