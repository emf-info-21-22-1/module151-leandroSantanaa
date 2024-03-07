<?php
require_once('Connexion.php');
require_once('bean/Monument.php');
class MonumentDBManager
{
    private $connexion;

    public function __construct()
    {

        $this->connexion = connexion::getInstance();
    }

    public function ajouterMonument($nom, $localite, $coordonneeX, $coordonneeY, $fk_Pays)
    {
        $test = "";
        try {
            $test = connexion::getInstance()->startTransaction();
            $array = array(":nom"->$nom, ":localite"->$localite, ":coordonneeX"->$coordonneeX, "coordonneeY"->$coordonneeY, "fk_Pays"->$fk_Pays);
            $test = connexion::getInstance()->executeQuery("INSERT INTO monuments (nom, localite, coordonneeX, coordonneeY, fk_Pays) VALUES (:nom, :localite, :coordonneeX, :coordonneeY, :fk_Pays)", $array);
            if ($test) {
                http_response_code(200);
                $result = json_encode(array("IsOk" => true, "message" => "ajout monument OK"));
                $test = connexion::getInstance()->commitTransaction();
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout d'un monument";
            $test = connexion::getInstance()->rollbackTransaction();
        }
        return $test;
    }
    public function modifierMonument($nom, $localite, $coordonneeX, $coordonneeY, $fk_Pays)
    {
        try {
            // Préparer la requête SQL de mise à jour
            $test = connexion::getInstance()->startTransaction();
            $array = array(":nom"->$nom, ":localite"->$localite, ":coordonneeX"->$coordonneeX, "coordonneeY"->$coordonneeY, "fk_Pays"->$fk_Pays);

            $test = connexion::getInstance()->executeQuery("UPDATE monuments SET nom = :nom, localite = :localite, coordonneeX = :coordonneeX, coordonneeY = :coordonneeY, fk_Pays = :fk_Pays WHERE fk_pays = pk_pays", $array);
            if ($test) {
                foreach ($test as $row) {
                    $pk_Pays = $row['FK_Projet'];
                    // Get projet detail
                    $params = array('pk_pays' => $pk_Pays);
                    $data = Connexion::getInstance()->selectSingleQuery("SELECT * FROM t_pays WHERE pk_pays = pk_pays", $params);
                    if ($data) {
                        echo json_encode($test);
                        $test = connexion::getInstance()->commitTransaction();
                    }
                }
            } else {
                echo "Erreur lors de la moidification d'un monument";
                $test = connexion::getInstance()->rollbackTransaction();
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la moidification d'un monument";
            $test = connexion::getInstance()->rollbackTransaction();

        }
    }
    public function getMonuments()
    {
        try {
            $test = connexion::getInstance()->startTransaction();
            $test = connexion::getInstance()->selectQuery("SELECT * FROM monuments");
            if ($test) {
                $test = connexion::getInstance()->commitTransaction();
                echo json_encode($test);
            } else {
                echo "Erreur lors de la récupération des monuments";
                $test = connexion::getInstance()->rollbackTransaction();

            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner un tableau vide
            echo "Erreur lors de la récupération des monuments : ";
            return array();
        }
    }
    public function getMonumentById($pk_monument)
    {
        try {
            $test = connexion::getInstance()->startTransaction();
            $array = array(":pk_monument"->$pk_monument);
            $test = connexion::getInstance()->selectQuery('SELECT * FROM monuments WHERE PK_Monument = :pk_monument', $array);
            if ($test) {
                echo json_encode($test);
                $test = connexion::getInstance()->commitTransaction();

            } else {
                echo "Erreur avec la récupération du monument";
            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner null
            echo "Erreur lors de la récupération du monument : " . $e->getMessage();
            $test = connexion::getInstance()->rollbackTransaction();

        }
    }
    public function supprimerMonument($pk_monument)
    {
        try {
            $test = connexion::getInstance()->startTransaction();
            $test = connexion::getInstance()->executeQuery("DELETE FROM monuments WHERE PK_Monument = :pk_monument");
            $array = array(':pk_monument'->$pk_monument);
            if ($test) {
                echo json_encode($test);
                $test = connexion::getInstance()->commitTransaction();

            } else {
                echo 'Erreur lors de la suppression du monument';
                $test = connexion::getInstance()->rollbackTransaction();
            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner false
            echo "Erreur lors de la suppression du monument : " . $e->getMessage();
            $test = connexion::getInstance()->rollbackTransaction();
        }
    }


}

?>