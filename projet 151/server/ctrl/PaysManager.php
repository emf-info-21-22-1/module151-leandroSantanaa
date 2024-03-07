<?php
require_once('wrk/paysDBManager.php');
class paysManager
{

  private $manager;
  public function __construct()
  {
    $this->manager = new paysDBManager();
  }
  public function GetJSONPays()
  {
    $pays = $this->manager->récupérerTousPays();
    return $pays;
  }
  public function GetJSONSinglePays($pk_Pays)
  {
    $pays = $this->manager->récupérerPays($pk_Pays);
    return $pays;
  }
  public function ADDJSONPays($nom_pays)
  {
    $pays = $this->manager->ajouterPays($nom_pays);
    return $pays;
  }
  public function UPDATEJSONPays($pk_Pays,$nom_pays)
  {
    $pays = $this->manager->updatePays($pk_Pays,$nom_pays);
    return $pays;
  }

}

?>