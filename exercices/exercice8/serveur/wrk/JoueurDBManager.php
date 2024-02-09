<?php
require_once('wrk/Connexion.php');
require_once('bean/Joueur.php');
class JoueurDBManager
{
    private $connexion;

    public function __construct()
    {

        $this->connexion = connexion::getInstance();
    }

    public function GetJoueurs($equipeId)
    {

        $query = $this->connexion->selectQuery('select pk_joueur, nom, points from t_joueur where fk_equipe=' . $equipeId . ';', null);

        $result = array();
        foreach ($query as $row) {
            $joueur = new Joueur($row['pk_joueur'], $row['nom'], $row['points']);
            $result[] = $joueur;
            json_encode($result);
        }

        return $result;
    }
}

?>