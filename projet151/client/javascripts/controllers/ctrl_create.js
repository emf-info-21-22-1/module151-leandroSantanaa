$.getScript("javascripts/services/servicesHttp.js", function () {
	console.log("servicesHttp.js chargé !");

});
var createValueUsername;
var createValuePassword;
$(document).ready(function () {
	$("#btnCreer").click(function (event) {
		event.preventDefault(); // pour afficher les echos / permission
		console.log("Button connexion presser");
		CreateUser(createValueUsername, createValuePassword);
	});
})
function CreateUser(username, password) {
	console.log("création de l'utilisateur : " + username + " " + password);

	// Appel de la fonction AJAX pour se connecter
	createAccount(username, password, function (response) {
		// Callback de succès
		console.log(response);

		// Récupération des propriétés de la réponse JSON
		var success = response.IsOk;
		var message = response.message;
		var userLogin = response["data"]["Username"];
		var userPK = response["data"]["pk_user"];
		if (success) {
			alert("Utilisateur connecté avec succès : " + userLogin);
			sessionStorage.setItem('username', userLogin);
			sessionStorage.setItem('PKuser', userPK);
		} else {
			alert("Vous n'avez pas pu vous connecter : " + message);
		}
	}, function (error) {

		alert("Login ou mot de passe incorrect");
	});
}