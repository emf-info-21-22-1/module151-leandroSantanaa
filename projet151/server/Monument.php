<?php
header('Access-Control-Allow-Origin: *');
include_once('ctrl/MonumentManager.php');
include_once('ctrl/PaysManager.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['nom']) && isset($_POST['localite']) && isset($_POST['coordonneeX']) && isset($_POST['coordonneeY']) && isset($_POST['username'])) {
                $login = new MonumentManager();
                echo $login->AjouterMonumentJSON($_POST['nom'], $_POST['localite'], $_POST['coordonneeX'], $_POST['coordonneeY'], $_POST["username"]);
            } else {
                echo 'un des paramètres est manquant';
            }
            break;

        case 'PUT':
            parse_str(file_get_contents("php://input"), $vars);
            if (isset($vars['new_nom']) && isset($vars['new_localite']) && isset($vars['new_coordonneeX']) && isset($vars['new_coordonneeY'])) {
                $nom = $vars['new_nom'];
                $localite = $vars['new_localite'];
                $coordonneeX = $vars['new_coordonneeX'];
                $coordonneeY = $vars['new_coordonneeY'];
                $login = new MonumentManager();
                $result = $login->modifierMonumentJSON($nom, $localite, $coordonneeX, $coordonneeY);
                echo $result;
                break;
            }

    }
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                switch ($action) {
                    case 'GetALL':
                        $login = new MonumentManager();
                        $result = $login->getMonumentJSON();
                        break;
                    case 'GetSingle':
                        if (isset($_GET['nom'])) {
                            $login = new MonumentManager();

                            $result = $login->getMonumentsJSON($_GET['nom']);
                            echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            break;
                        }
                    default:
                        // Gérer les cas non valides
                        break;
                }
            } else {
                // Gérer les cas où aucun paramètre 'action' n'est fourni
                break;
            }
            break;
        default:
            // Gérer les autres méthodes HTTP si nécessaire
            break;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        $login = new MonumentManager();
        echo $login->supprimerMonumentJSON($_REQUEST['pk_monument']);

    }

}
?>