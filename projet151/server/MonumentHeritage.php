<?php
header('Access-Control-Allow-Origin: *');
include_once('ctrl/LoginManager.php');
include_once('ctrl/MonumentManager.php');
include_once('ctrl/PaysManager.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $login = new LoginManager();
                echo $login->createAccount($_POST["username"], $_POST["password"]);
                break;
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