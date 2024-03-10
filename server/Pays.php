<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Credentials: true');
include_once('ctrl/MonumentManager.php');
include_once('ctrl/PaysManager.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['nom'])) {
                $login = new PaysManager();
                echo $login->ADDJSONPays($_POST['nom']);
            } else {
                echo 'un des paramètres est manquant';
            }
            break;


    }


}

?>