$.getScript("javascripts/services/servicesHttp.js", function () {
	console.log("servicesHttp.js chargé !");

});
var loginValueUsername;
var loginValuePassword;
$(document).ready(function () {
	$("#btnConexion").click(function (event) {
		event.preventDefault(); // pour afficher les echos / permission
		console.log("Button connexion presser");
		loginValueUsername = $("#username").val();
		console.log("username = ", loginValueUsername);
		loginValuePassword = $("#password").val();
		console.log("password = ", loginValuePassword);
		loginUser(loginValueUsername, loginValuePassword);
	});
})
function loginUser(username, password) {
	console.log("Connexion à l'utilisateur : " + username + " " + password);

	// Appel de la fonction AJAX pour se connecter
	loginAjax(username, password, function (response) {
		// Callback de succès
		console.log(response);

		// Récupération des propriétés de la réponse JSON
		var success = response.IsOk;
		var message = response.message;
		var userLogin = response["Data"]["Username"];
		var userPK = response["Data"]["pk_user"];
		if (success) {
			alert("Utilisateur connecté avec succès : " + userLogin);
			sessionStorage.setItem('username', userLogin);
			sessionStorage.setItem('PKuser', userPK);
			window.location.href = 'indexLogin.html';

		} else {
			alert("Vous n'avez pas pu vous connecter : " + message);
		}
	}, function (error) {

		alert("Login ou mot de passe incorrect");
	});
}