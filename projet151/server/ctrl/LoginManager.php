<?php
require_once('wrk/LoginDBManager.php');
require_once('ctrl/SessionManager.php');

class LoginManager
{

    private $manager;
    private $session;
    public function __construct()
    {
        $this->manager = new LoginDBManager();
        $this->session = new SessionManager();

    }
    public function createAccount($username, $password)
    {
        $pays = $this->manager->createAccount($username, $password);
        $message = json_decode($pays, true);
        return $message["message"];
    }
    public function checkLogin($username, $password)
    {
        $pays = $this->manager->checkLogin($username, $password);
        $ok = json_decode($pays);
        if ($ok) {
            $this->session->set("username", $username);
            $message = json_decode($pays, true);
            $pays = $message["message"];
        }
        return $pays;
    }
    public function disconnct()
    {
        if (isset($_SESSION["username"])) {
            $this->session->destroy();
            echo ("utilisateur déconnecter");
        } else {
            echo ("la session n'existe pas donc l'utilisateur n'as pas été déconnecté");
        }
    }
}

?>