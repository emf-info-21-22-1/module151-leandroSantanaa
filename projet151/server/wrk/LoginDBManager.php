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
                    $test = Connexion::getInstance()->commitTransaction();
                    $result = json_encode(array("IsOk" => true, "message" => "Création d'utilisateur OK"));
                }
            } else {
                $test = Connexion::getInstance()->rollbackTransaction();
                $result = json_encode(["error" => "Password hashing failed"]);
            }
        } catch (PDOException $e) {
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
                    $result = json_encode(array("IsOk" => true, "message" => "Connexion à l'utilisateur OK"));
                } else {
                    $result = "Erreur lors de la vérification du mot de passe";
                }
            }
        } else {
            $result = "Erreur dans le contrôle du login"
            ;
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