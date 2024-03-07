<?php
require_once('wrk/MonumentDBManager.php');
class MonumentManager
{

  private $manager;

  public function __construct()
  {
    $this->manager = new MonumentDBManager();
  }

  public function getMonumentsJSON()
  {
    $monuments = $this->manager->getMonuments();
    $result = json_encode($monuments);
    return $result;
  }
  public function getMonumentJSON($monument)
  {
    $aMonument = $this->manager->getMonumentById($monument);
    $result = json_encode($aMonument);
    return $result;
  }
  public function AjouterMonumentJSON($nom, $localite, $coordonneeX, $coordonneeY, $fk_Pays)
  {
    $Ajout = $this->manager->ajouterMonument($nom, $localite, $coordonneeX, $coordonneeY, $fk_Pays);
    $result = json_encode($Ajout);
    return $result;
  }
  public function modifierMonumentJSON($id, $nom, $localite, $coordonneeX, $coordonneeY, $fk_Pays)
  {
    $Ajout = $this->manager->modifierMonument($id, $nom, $localite, $coordonneeX, $coordonneeY, $fk_Pays);
    $result = json_encode($Ajout);
    return $result;
  }
  public function supprimerMonumentJSON($pk_monument)
  {
    $suppimer = $this->manager->supprimerMonument($pk_monument);
    $result = json_encode($suppimer);
    return $result;
  }
}

?>