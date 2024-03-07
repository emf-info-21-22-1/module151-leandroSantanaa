<?php
require_once('wrk/LoginDBManager.php');
class LoginManager
{

    private $manager;
    public function __construct()
    {
        $this->manager = new LoginDBManager();
    }
    public function createAccount($username, $password)
    {
        $pays = $this->manager->createAccount($username, $password);
        return $pays;
    }
    public function checkLogin($username, $password)
    {
        $pays = $this->manager->checkLogin($username, $password);
        return $pays;
    }
    public function disconnct()
    {
        $pays = $this->manager->disconnct();
        return $pays;
    }
}

?>