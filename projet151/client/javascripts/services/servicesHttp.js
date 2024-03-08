/*
 * Couche de services HTTP (worker).
 *
 * @author Olivier Neuhaus
 * @version 1.0 / 20-SEP-2013
 */

var BASE_URL = "http://localhost:8081/";

/**
 * Fonction permettant de charger les données d'équipe.
 * @param {type} Fonction de callback lors du retour avec succès de l'appel.
 * @param {type} Fonction de callback en cas d'erreur.
 */
function createAccount(username, password, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "Session.php",
        data: {
            "action": "createAccount",
            "username": username,
            "password": password
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function loginAjax(username, password, successCallback, errorCallback) {
    console.log("reuquete LOGIN");
    $.ajax({
        type: "POST",
        dataType: "json",
        url: BASE_URL + "Session.php",
        data: {
            "action": "login",
            "username": username,
            "password": password
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}
function logOut(successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "Session.php",
        data: 'action=POST',
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}
