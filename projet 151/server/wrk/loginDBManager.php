<?php
class LoginDBManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->Connexion = connexion::getInstance();
    }

    public function createAccount($username, $password)
    {
        try {
            $test = Connexion::getInstance()->startTransaction();
            $hashedPassword = $this->hashPassword($password);
            if ($hashedPassword != null) {
                $param = array(':username'->$username, ':password'->$hashedPassword);
                $Query = connexion::getInstance()->executeQuery('INSERT INTO users (username, password) VALUES (:username, :password)', $param);
                if ($Query->rowCount() == 0) {
                    echo json_encode($Query);

                    $test = Connexion::getInstance()->commitTransaction();
                }
            } else {
                $test = Connexion::getInstance()->rollbackTransaction();

            }
        } catch (PDOException $e) {
            $test = Connexion::getInstance()->rollbackTransaction();
        }
    }
    public function checkLogin($username, $password)
    {
        $test = Connexion::getInstance()->startTransaction();
        $param = array(':username'->$username, ':password'->$password);
        $Query = connexion::getInstance()->selectQuery("SELECT username, password FROM users WHERE username = :username AND password = :password", $param);
        if ($Query == 1) {
            echo json_encode($Query);

            $test = Connexion::getInstance()->commitTransaction();
        } else {
            $test = Connexion::getInstance()->rollbackTransaction();
        }
    }

    public function hashPassword($password)
    {
        // Générer un sel aléatoire
        $salt = password_hash($password, PASSWORD_DEFAULT);

        // Retourner le mot de passe hashé avec le sel
        return $salt;
    }
    public function disconnct()
    {
        $test = Connexion::getInstance()->__destruct();
        echo json_encode($test);
    }
}
?>