<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Credentials: true');
include_once('ctrl/LoginManager.php');

        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            switch ($action) {
                case "createAccount"; {
                        if (isset($_POST['username']) && isset($_POST['password'])) {
                            $login = new LoginManager();
                            echo $login->createAccount($_POST["username"], $_POST["password"]);
                            break;
                        }
                    }
                case "disconnect"; {
                        $login = new LoginManager();
                        echo $login->disconnect();
                        break;
                    }
                case "login"; {
                        if (isset($_POST['username']) && isset($_POST['password'])) {
                            $login = new LoginManager();
                            echo $login->checkLogin($_POST["username"], $_POST["password"]);
                            break;
                        } else {
                            echo 'Paramètre de nom d\'utilisateur ou mot de passe manquant';
                        }
                        break;
                    }
            }
        }




?>