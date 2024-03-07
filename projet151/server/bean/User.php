<?php
class User implements JsonSerializable
{
    private $pk_user;
    private $nom;
    private $password;

    public function __construct()
    {

    }

    public function getPK_User()
    {
        return $this->pk_user;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getpassword()
    {
        return $this->password;
    }
    public function initFromDb($data)
    {
        $this->pk_user = $data["pk_user"];
        $this->nom = $data["Username"];
        $this->password = $data["Password"];
    }
    public function jsonSerialize(): mixed
    {
        return [
            "pk_user" => $this->pk_user,
            "nom" => $this->nom,
            "password"->$this->password,

        ];
    }
}
?>