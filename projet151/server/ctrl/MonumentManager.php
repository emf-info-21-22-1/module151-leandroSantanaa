<?php
require_once('wrk/MonumentDBManager.php');
class MonumentManager
{

  private $manager;

  public function __construct()
  {
    $this->manager = new MonumentDBManager();
  }

  public function getMonumentJSON()
  {
    $monuments = $this->manager->getMonuments();
    $result = json_decode($monuments, true);
    return $result["data"];
  }
  public function getMonumentsJSON($monument)
  {
    $aMonument = $this->manager->getMonumentById($monument);
    $result = json_decode($aMonument, true);
    return $result["data"];
  }
  public function AjouterMonumentJSON($nom, $localite, $coordonneeX, $coordonneeY, $username)
  {
    $monument = $this->manager->ajouterMonument($nom, $localite, $coordonneeX, $coordonneeY, $username);
    $message = json_decode($monument, true);
    return $message["message"];
  }
  public function modifierMonumentJSON($nom, $localite, $coordonneeX, $coordonneeY)
  {
    $Ajout = $this->manager->modifierMonument($nom, $localite, $coordonneeX, $coordonneeY);
    $result = json_encode($Ajout);
    return $result["message"];
  }
  public function supprimerMonumentJSON($pk_monument)
  {
    $suppimer = $this->manager->supprimerMonument($pk_monument);
    $result = json_encode($suppimer);
    return $result;
  }
}

?>