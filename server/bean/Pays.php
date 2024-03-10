<?php
class Pays implements JsonSerializable
{
  private $pk_Pays;
  private $nom;

  public function __construct($pk_Pays, $nom)
  {
    $this->pk_Pays = $pk_Pays;
    $this->nom = $nom;

  }

  public function getpk_Pays()
  {
    return $this->pk_Pays;
  }

  public function getNom()
  {
    return $this->nom;
  }


  public function jsonSerialize(): mixed
  {
    return [
      "pk_Pays" => $this->getpk_Pays(),
      "nom" => $this->getNom()
    ];
  }
}
?>