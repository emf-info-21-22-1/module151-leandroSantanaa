<?php
class Monument implements JsonSerializable
{
  private $PK_Monument;
  private $nom;
  private $localite;
  private $FK_Pays;
  private $CoordonneeX;
  private $Coordonnee;

  public function __construct($PK_Monument, $nom, $localite, $FK_Pays, $CoordonneeX, $CoordonneeY)
  {
    $this->PK_Monument = $PK_Monument;
    $this->nom = $nom;
    $this->localite = $localite;
    $this->FK_Pays = $FK_Pays;
    $this->CoordonneeX = $CoordonneeX;
    $this->CoordonneeY = $CoordonneeY;
  }

  public function getPKMonument($PK_Monument)
  {
    return $PK_Monument;
  }
  public function getNom($nom)
  {
    return $nom;
  }
  public function getLocalite($localite)
  {
    return $localite;
  }
  public function getCoordonneX($CoordonneeX)
  {
    return $CoordonneeX;
  }
  public function getCoordonneY($CoordonneeY)
  {
    return $CoordonneeY;
  }

  public function jsonSerialize(): mixed
  {
    return [
      "PK_Monument" => $this->PK_Monument,
      "nom" => $this->nom,
      "localite" ->$this->localite,
      "FK_Pays"->$this->FK_Pays,
      "CoordonneeX"->$this->CoordonneeX,
      "CoordonneeY"->$this->CoordonneeY
    ];
  }
}
?>