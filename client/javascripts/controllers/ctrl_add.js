$.getScript("javascripts/services/servicesHttp.js", function () {
	console.log("servicesHttp.js chargé !");

});
var addnameMonument;
var addnamelocalite;
var addCoordonneeX;
var addCoordonneeY;
var user;
$(document).ready(function () {
	$("#btnCreer").click(function (event) {
		event.preventDefault(); // pour afficher les echos / permission
		console.log("Button créer presser");
		addnameMonument = $("#name").val();
		console.log("name = ", addnameMonument);
		addnamelocalite = $("#pays").val();
		console.log("pays = ", addnamelocalite);
	
		addCoordonneeX = $("#CoordonneX").val();
		console.log("CoordonneX = ", addCoordonneeX);
		addCoordonneeY = $("#CoordonneY").val();
		console.log("CoordonneY  = ", addCoordonneeY);
		user = sessionStorage.getItem("username");
		console.log("utilisateur  = ", user);
		AjouterMonument(addnameMonument, addnamelocalite, addCoordonneeX, addCoordonneeY, user, );
	});
})
function AjouterMonument(nom, pays, CoordonneX, CoordonneY, username, ) {
	console.log("création du monument : " + nom + " " + pays + " " + CoordonneX + " " + CoordonneY + username);

	// Appel de la fonction AJAX pour se connecter
	createMonument(nom, pays, CoordonneX, CoordonneY, username,  function (response) {	// Callback de succès
		console.log(response);

		// Récupération des propriétés de la réponse JSON
		var success = response.IsOk;
		var message = response.message;
		console.log(success);
		if (success) {
			alert("Monument connecté avec succès : ");

			window.location.href = 'indexLogin.html';

		} else {
			alert("Vous n'avez pas pu vous connecter : " + message);
		}
	}, function (error) {

		alert("Erreur lors de la création du monument");
	});
}