<?php
//démarrer une session si elle n'existe pas
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//fonction pour valider un formulaire
function validerForm($data):bool{
    // la variable pouvant contenir les erreurs
    $error ="";

    foreach ($data as $key => $value) {

        //vérifier si le formulaire  est lié aux propriétés de la Entreprise
        if(in_array($key,['nom','description','adresse','nbrEmp','dateC'])){  
            
            //sécuriser les entrées de l'utilisateur 
            $data[$key]= trim(htmlspecialchars($data[$key]));

            //vérifier si le nombre d'employé est inférieur ou égale à 0
            if($data['nbrEmp'] <= 0){
                $error= "Le champ nombre d'employé n'est pas positive ou est nulle. ";
                $_SESSION['error'] = $error;
                return false;
            }

            //vérifier la validité de la date de création
            if(!controlerDate( $data['dateC'] )){
                $error= "Le champ date de cretion est mal renseigné. ";
                $_SESSION['error'] = $error;
                return false;
            }

        }else{
            $data[$key]= trim(htmlspecialchars($data[$key]));
        }

        // verifier si un champ est vide
        if($value == ""){
            $error= "Un ou plusieurs champ(s) sont vide(s). ";
            $_SESSION['error'] = $error;
            return false;
        }
    }    
    
        $_SESSION['form']=$data;
        return true;
    
}

// Fonction de connexion à la base de données
function connecter(): ?PDO
{
    //Utiliser le fichier config unique dans la fonction pour se connecter
    require_once('./config.php');

    // Options de connexion
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Connexion à la base de données
    try {
        $dsn = DB_HOST . DB_NAME;
        $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $connection;
    } catch (PDOException $e) {
        echo "Connexion à MySQL impossible : ", $e->getMessage();
        
        return null;
    }
}

//fonction pour controler si une date est valide
function controlerDate(string $valeur): bool {
    if (preg_match("/^(\d{1,2})[\/|\-|\.](\d{1,2})[\/|\-|\.](\d\d)(\d\d)?$/", $valeur, $regs)) {
        $jour = ($regs[1] < 10) ? "0" . $regs[1] : $regs[1];
        $mois = ($regs[2] < 10) ? "0" . $regs[2] : $regs[2];
        if ($regs[4]) {
            $tab1n = $regs[3] . $regs[4];
        } else {
            return false;
        }
        return checkdate((int)$mois, (int)$jour, (int)$tab1n);
    } else {
        return false;
    }
}


//fonction pour trier un tableau d'objet en fonction de l'une de leur propriété (cle)
function trierParCle(array $tableau, string $cle, string $ordre = 'asc'): array {

    /** usort permet le trie des tableau à l'aide d'une fonction (annonyme dans notre cas) passer en paramettre 
    *   tab1 et tab2 contiennent les données de $tableau
    */
    usort($tableau, function ($tab1, $tab2) use ($cle, $ordre) {
        //getter contient le nom de la methode qui permet d'accéder à la propriété (exemple nom :  getNom)
        $getter='get'.ucfirst($cle);
        $val1=$tab1->$getter();
        $val2=$tab2->$getter();

        if ($val1 == $val2) {
            return 0;
        }

        if ($ordre === 'asc') {
            return ($val1 < $val2) ? -1 : 1;
        } else {
            return ($val1 > $val2) ? -1 : 1;
        }
    });

    return $tableau;
}

//fonction pour paginer les données d'un tableau 
function paginerTab(int $parPage, int $page=1, array $tableau): array {
    
    
    if ($parPage <= 0 || $page <= 0) {
        return [];
    }

    $total = count($tableau);
    $debut = ($page - 1) * $parPage;

    if ($debut >= $total) {
        return [];
    }

    //si tout va bien jusqu'ici extraire $parPage (ex: 10) donnée(s) à partir de $debut du $tableau
    return array_slice($tableau, $debut, $parPage);
}

?>