<?php
header('Access-Control-Allow-Origin: *');
include_once('ctrl/EquipeCtrl.php');
include_once('ctrl/JoueurCtrl.php');

switch ($_GET['action']) {
    case 'equipe':
        $equipes = new EquipeCtrl();
        echo $equipes->getEquipesJSON();
        break;
    case 'joueur':
        $joueurs = new JoueurCtrl();
        echo $joueurs->getJoueursJSON($_GET['equipeId']);
        break;
}
?>