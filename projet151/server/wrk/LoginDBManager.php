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
                // Utilisez la syntaxe correcte pour accéder aux valeurs de l'objet array
                $param = array(':username' => $username, ':password' => $hashedPassword);
                $Query = connexion::getInstance()->executeQuery('INSERT INTO t_user (username, password) VALUES (:username, :password)', $param);
                if ($Query == 1) {
                    http_response_code(200);
                    $test = Connexion::getInstance()->commitTransaction();
                    $result = json_encode(array("IsOk" => true, "message" => "Création d'utilisateur OK"));
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

        $params = array('username' => $username);
        $Query = Connexion::getInstance()->selectSingleQuery("SELECT pk_user,Username,Password FROM t_user WHERE username=:username", $params);
        if ($Query) {
            $user = new User();
            $user->initFromDb($Query);
            if ($user->getPassword() !== null) {
                $hashpash = $user->getpassword();


                if (password_verify($password, $hashpash)) {
                    http_response_code(200);
                    $result = json_encode(array("IsOk" => true, "message" => "Connexion à l'utilisateur OK"));
                } else {
                    http_response_code(500);
                    $result = "Erreur lors de la vérification du mot de passe";

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