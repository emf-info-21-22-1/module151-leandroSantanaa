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

    public function ajouterMonument($nom, $localite, $coordonnesX, $coordonnesY, $username_user)
    {
        $test = "";
        try {
            $test = connexion::getInstance()->startTransaction();
            $param = array(':nom' => $localite);
            $query_pays = connexion::getInstance()->selectSingleQuery("SELECT pk_pays FROM t_pays WHERE nom = :nom", $param);

            $fk_Pays = $query_pays['pk_pays'];
            $Session_username = $username_user;
            $query_user = connexion::getInstance()->selectSingleQuery("SELECT pk_user FROM t_user WHERE username = :username_user", array(":username_user" => $Session_username));
            $fk_user = $query_user['pk_user'];

            $array = array(
                ":nom" => $nom,
                ":localite" => $localite,
                ":fk_user" => $fk_user,
                ":fk_pays" => $fk_Pays,
                ":coordonnesY" => $coordonnesY,
                ":coordonnesX" => $coordonnesX
            );

            // Exécute la requête d'insertion
            $query = "INSERT INTO `monumentheritage`.`t_monument` 
                      (`nom`, `localite`, `fk_user`, `fk_pays`, `coordonnesY`, `coordonnesX`) 
                      VALUES (:nom, :localite, :fk_user, :fk_pays, :coordonnesY, :coordonnesX)";
            connexion::getInstance()->executeQuery($query, $array);

            if ($query) {
                http_response_code(200);
                $result = json_encode(array("IsOk" => true, "message" => "ajout monument OK"));
                $test = connexion::getInstance()->commitTransaction();
            } else {
                http_response_code(500);
                $result = json_encode(array("IsOk" => false, "message" => "ajout monument NOK"));
                $test = connexion::getInstance()->rollbackTransaction();
            }
        } catch (PDOException $e) {
            connexion::getInstance()->rollbackTransaction();
            return json_encode(array("IsOk" => false, "message" => "Erreur lors de l'ajout du monument : " . $e->getMessage()));
        }
        return $result;
    }
    public function modifierMonument($nom, $localite, $coordonneeX, $coordonneeY)
    {
        $result = "";
        try {
            $test = connexion::getInstance()->startTransaction();
            $param = array(':nom' => $localite);
            $Session_username = $_SESSION["username"];
            if ($Session_username !== null) {
                # code...

                $query_pays = connexion::getInstance()->selectSingleQuery("SELECT pk_pays FROM t_pays WHERE nom = :nom", $param);

                $fk_Pays = $query_pays['pk_pays'];

                echo json_encode($fk_Pays, JSON_UNESCAPED_UNICODE);
                $data = array(
                    "nom" => $nom,
                    "localite" => $localite,
                    "coordonneesX" => $coordonneeX,
                    "coordonneesY" => $coordonneeY,
                    "fk_Pays" => $fk_Pays
                );
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
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
                            // http_response_code(200);
                            $result = json_encode(array("IsOk" => true, "message" => "modifier monument OK"));
                            $test = connexion::getInstance()->commitTransaction();

                        }
                    }
                } else {
                    echo "Erreur lors de la moidification d'un monument";
                    $test = connexion::getInstance()->rollbackTransaction();
                }
            } else {
                echo "Connectez vous pour pouvoir modifier le monument";
                $test = connexion::getInstance()->rollbackTransaction();
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la moidification d'un monument";
            $test = connexion::getInstance()->rollbackTransaction();

        }
        return $result;

    }
    public function getMonuments()
    {
        $result = "";
        try {
            $test = connexion::getInstance()->selectQuery("SELECT nom, localite FROM t_monument", null);
            if ($test !== false) {
                $data = ""; // Initialisez une chaîne vide pour stocker les données HTML
                foreach ($test as $row) {
                    // Récupérez les valeurs spécifiques de chaque ligne
                    $nom = $row['nom'];
                    $localite = $row['localite'];
                    // Concaténez les valeurs dans la chaîne HTML
                    $data .= '<div class="text-holder" id="monumentInfo">';
                    $data .= '<p>Nom: ' . $nom . '</p>';
                    $data .= '<p>Localite: ' . $localite . '</p>';
                    $data .= '</div><br>';
                }
                // Encodage JSON à l'extérieur de la boucle foreach
                $result = json_encode(array("IsOk" => true, "message" => "Récupération des monuments réussie", "data" => $data));
            } else {
                $result = json_encode(array("IsOk" => false, "message" => "Aucun monument trouvé"), JSON_UNESCAPED_UNICODE);
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des monuments : " . $e->getMessage();
            // Gérer l'erreur PDO ici
            $result = json_encode(array("IsOk" => false, "message" => "Erreur PDO lors de la récupération des monuments"), JSON_UNESCAPED_UNICODE);
        }
        return $result;
    }
    
    
    public function getMonumentById($nom)
    {
        $result = "";
        try {
            $array = array(":nom" => $nom);
            $test = connexion::getInstance()->selectSingleQuery('SELECT nom,localite FROM t_monument WHERE nom = :nom', $array);
            if ($test) {
                $result = json_encode(array("IsOk" => true, "message" => "Modifier monument OK", "data" => $test), JSON_FORCE_OBJECT);
            } else {
                $result = json_encode(array("IsOk" => false, "message" => "Aucun monument trouvé avec ce nom"), JSON_FORCE_OBJECT);
            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner null
            echo "Erreur lors de la récupération du monument : " . $e->getMessage();
            $test = connexion::getInstance()->rollbackTransaction();

        }
        return $result;

    }
    public function supprimerMonument($pk_monument)
    {
        $result = "";

        try {
            $test = connexion::getInstance()->startTransaction();
            $test = connexion::getInstance()->executeQuery("DELETE FROM t_monument WHERE PK_Monument = :pk_monument");
            $array = array(':pk_monument'->$pk_monument);
            if ($test) {
                $result = json_encode(array("IsOk" => true, "message" => "Supprimer le monument OK", "data" => $test), JSON_FORCE_OBJECT);
                $test = connexion::getInstance()->commitTransaction();
                return $result;
            } else {
                echo 'Erreur lors de la suppression du monument';
                $test = connexion::getInstance()->rollbackTransaction();
                return $result;

            }
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner false
            echo "Erreur lors de la suppression du monument : " . $e->getMessage();
            $test = connexion::getInstance()->rollbackTransaction();
            return $result;

        }
    }


}

?>