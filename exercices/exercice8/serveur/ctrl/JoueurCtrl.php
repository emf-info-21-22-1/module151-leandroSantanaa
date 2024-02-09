<?php
require_once('wrk/EquipesDBManager.php');
require_once('wrk/JoueurDBManager.php');
class JoueurCtrl{
  
  private $manager;
  
  public function __construct(){
    $this->manager = new JoueurDBManager();
  }
  
  public function getJoueursJSON($equipeID){
    $joueurs = $this->manager->getJoueurs($equipeID);
    $result = json_encode($joueurs);
    return $result;
  }
  

}

?>