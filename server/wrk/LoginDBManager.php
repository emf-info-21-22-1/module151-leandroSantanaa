<?php
require_once('Connexion.php');
require_once("bean/User.php");
class LoginDBManager
{


    public function __construct()
    {
    }

    public function createAccount($username, $password)
    {
        $result = "";
        try {
            $test = Connexion::getInstance()->startTransaction();
            $hashedPassword = $this->hashPassword($password);
            if ($hashedPassword != null) {
                $param = array(':username' => $username, ':password' => $hashedPassword);
                $Query = connexion::getInstance()->executeQuery('INSERT INTO t_user (username, password) VALUES (:username, :password)', $param);
                if ($Query) {
                    $a =array($username, $password);
                    http_response_code(200);
                    $result = json_encode(array("IsOk" => true, "message" => "Création d'utilisateur OK", "Data" => $a));
                    $test = Connexion::getInstance()->commitTransaction();
                }
            } else {
                http_response_code(500);
                $test = Connexion::getInstance()->rollbackTransaction();
            }
        } catch (PDOException $e) {
            http_response_code(500);
            $test = Connexion::getInstance()->rollbackTransaction();
            $result = json_encode(["error" => $e->getMessage()]);
        }
        return $result;
    }

    public function checkLogin($username, $password)
    {
        $params = array("username" => htmlspecialchars($username));
        $result = "";

        $Query = Connexion::getInstance()->selectSingleQuery("SELECT pk_user,Username,Password FROM t_user WHERE username=:username", $params);
        if ($Query) {
            $user = new User();
            $user->initFromDb($Query);
            if ($user->getPassword() !== null) {
                $hashpash = $user->getpassword();


                if (password_verify($password, $hashpash)) {
                    http_response_code(200);
                    $result = json_encode(array("IsOk" => true, "message" => "Connexion à l'utilisateur OK", "Data" => $Query));
                } else {
                    http_response_code(500);
                    $result = "Mot de passe incorect";

                }
            }
        } else {
            http_response_code(500);
            $result = "Erreur dans le contrôle du login";
        }
        return $result;
    }

    public function hashPassword($password)
    {
        // Générer un sel aléatoire
        $salt = password_hash($password, PASSWORD_DEFAULT);

        // Retourner le mot de passe hashé avec le sel
        return $salt;
    }

}
?>