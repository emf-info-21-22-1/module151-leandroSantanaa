/*
* Contrôleur de la vue "index.html"
*
* @author Olivier Neuhaus
* @version 1.0 / 20-SEP-2013
*/
 
/**
* Méthode appelée lors du retour avec succès du résultat des équipes
* @param {type} data
* @param {type} text
* @param {type} jqXHR
*/
function chargerTeamSuccess(data, text, jqXHR) {
    // Appelé lorsque la liste des équipes est reçue
    var cmbEquipes = document.getElementById("cmbEquipes");
    cmbEquipes.innerHTML = ""; // Supprimer toutes les options existantes

    for (let i = 0; i < data.length; i++) {
        var equipe = data[i];
        var pk = equipe.id;
        var name = equipe.nom;

        var option = new Option(name, pk); // Créer une nouvelle option avec le nom comme texte et pk comme valeur
        cmbEquipes.appendChild(option); // Ajouter l'option au select
    }
}


 
/**
* Méthode appelée lors du retour avec succès du résultat des joueurs
* @param {type} data
* @param {type} text
* @param {type} jqXHR
*/
function chargerPlayerSuccess(data, text, jqXHR) {
    // Appelé lorsque la liste des joueurs est reçue
    var cmbJoueurs = document.getElementById("cmbJoueurs");
    // A COMPLETER!!! selon la logique suivante:
 
 
    for (let i = 0; i < data.length; i++) {
        var player = data[i];
        var nom = player.nom;
        var points = player.points;
        var joueur = new Joueur();
        joueur.setNom(nom);
        joueur.setPoints(points);
        cmbJoueurs.options[cmbJoueurs.options.length] = new Option(joueur, JSON.stringify(joueur));
    }
    // cmbJoueurs.options[cmbJoueurs.options.length] = new Option(<ce qui sera affiché>, <la valeur de la cellule>));
}
 
/**
* Méthode appelée en cas d'erreur lors de la lecture du webservice
* @param {type} data
* @param {type} text
* @param {type} jqXHR
*/
function chargerTeamError(request, status, error) {
    alert("erreur : " + error + ", request: " + request + ", status: " + status);
}
 
/**
* Méthode appelée en cas d'erreur lors de la lecture du webservice
* @param {type} data
* @param {type} text
* @param {type} jqXHR
*/
function chargerPlayerError(request, status, error) {
    alert("erreur : " + error + ", request: " + request + ", status: " + status);
}
 
/**
* Méthode "start" appelée après le chargement complet de la page
*/
$(document).ready(function () {
    var butLoad = $("#displayTeams");
    var cmbEquipes = $("#cmbEquipes");
    var cmbJoueurs = $("#cmbJoueurs");
    var equipe = '';
    var joueur = '';
    $.getScript("javascripts/beans/equipe.js", function () {
        console.log("equipe.js chargé !");
    });
    $.getScript("javascripts/beans/joueur.js", function () {
        console.log("joueur.js chargé !");
    });
    $.getScript("javascripts/services/servicesHttp.js", function () {
        console.log("servicesHttp.js chargé !");
        chargerTeam(chargerTeamSuccess, chargerTeamError);
    });
 
    // Ce qui se passe lorsque l'on sélectionne une équipe
    cmbEquipes.change(function (event) {
        equipe = this.options[this.selectedIndex].value;
        chargerPlayers(JSON.parse(equipe).pk, chargerPlayerSuccess, chargerPlayerError);
    });
 
    // Ce qui se passe lorsque l'on sélectionne une joueur
    cmbJoueurs.change(function (event) {
        joueur = this.options[this.selectedIndex].value;
        alert(JSON.parse(joueur).nom + ": " + JSON.parse(joueur).points + " points");
    });
});