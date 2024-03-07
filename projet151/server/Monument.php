<?php
header('Access-Control-Allow-Origin: *');
include_once('ctrl/MonumentManager.php');
include_once('ctrl/PaysManager.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['nom']) && isset($_POST['type']) && isset($_POST['fk_user']) && isset($_POST['fk_lieu'])) {
                $login = new MonumentManager();
                echo $login->AjouterMonumentJSON($_POST['nom']) && isset($_POST['localite']) && isset($_POST['coordonneeX']) && isset($_POST['coordonneeY']&& isset($_POST['FK_Pays'])
            } else {
                echo 'Paramètre de nom d\'utilisateur ou mot de passe manquant';
            }
            break;

        case 'GET':
            if (isset($_GET['username']) && isset($_GET['password'])) {
                $login = new LoginManager();
                echo $login->checkLogin($_GET["username"], $_GET["password"]);
                break;
            } else {
                echo 'Paramètre de nom d\'utilisateur ou mot de passe manquant';
            }
            break;
    }

}
?>