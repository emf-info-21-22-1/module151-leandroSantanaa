$.getScript("javascripts/services/servicesHttp.js", function () {
	console.log("servicesHttp.js chargé !");

});

$(document).ready(function () {
	$("#btnDeco").click(function (event) {
		event.preventDefault(); // pour afficher les echos / permission
		console.log("Button connexion presser");
	
	
		disconnectUser();
	});
})
function disconnectUser() {

	// Appel de la fonction AJAX pour se connecter
	logOut(function (response) {
		// Callback de succès
		console.log(response);

		// Récupération des propriétés de la réponse JSON
		var success = response.IsOk;
		var message = response.message;
		
		if (success) {
			alert("Utilisateur déconnecté avec succès");
		
			window.location.href = 'index.html';

		} else {
		}
	}, function (error) {

		alert("vous devez 'etre connecté pour vous déconnecté");
	});
}