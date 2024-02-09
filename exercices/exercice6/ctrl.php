<?php
class Ctrl
{
  private $wrk;
  public function construct()
  {
    require('wrk.php');
    $this->wrk = new wrk();
  }

  public function getEquipesFromDB()
  {

    return $this->wrk->getEquipesFromDB();
  }
}
?>