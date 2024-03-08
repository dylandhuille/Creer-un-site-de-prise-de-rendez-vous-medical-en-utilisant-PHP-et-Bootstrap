<?php
include(dirname(__FILE__) . '/../config/regexp.php');

include(dirname(__FILE__) . '/../models/Patient.php');
include(dirname(__FILE__) . '/../models/Appointment.php');

// Initialisation du tableau d'erreurs
$errorsArray = array();
/*************************************/

// Nettoyage de l'id du rdv passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*************************************************************/

// Appel à la méthode statique permettant de récupérer toutes les infos d'un rdv
$response = Appointment::get($id);
// Si $response appartient à la classe PDOException (Si une exception est retournée),
// on stocke un message d'erreur à afficher dans la vue
if($response instanceof PDOException){
    $message = $response->getMessage();
} else {
    // Appel à la méthode statique permettant de récupérer tous les patients
    $allPatients = Patient::getAll();
    /*************************************************************/
    // Formatte l'heure pour l'injecter au bon format dans la vue.
    $dateHour=date('Y-m-d\TH:i:s', strtotime($response->dateHour));
}


//On ne controle que s'il y a des données envoyées 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

     // DATE ET HEURE DE RDV
    // On verifie l'existance et on nettoie
    
    $dateHour = trim(filter_input(INPUT_POST, 'dateHour', FILTER_SANITIZE_STRING));
    $isOk = filter_var($dateHour, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.REGEXP_DATE_HOUR.'/')));

    //On test si le champ n'est pas vide
    if(!empty($dateHour)){
        // On test la valeur
        if(!$isOk){
            $errorsArray['dateHour_error'] = 'Le date n\'est pas valide, le format attendu est JJ/MM/AAAA HH:mm';
        }
    }else{
        $errorsArray['dateHour_error'] = 'Le champ est obligatoire';
    }

    // ***************************************************************
  
    $idPatients = trim(filter_input(INPUT_POST, 'idPatients', FILTER_SANITIZE_NUMBER_INT));
    //On test si le champ n'est pas vide
    if($idPatients==0){
        $errorsArray['dateHour_error'] = 'Le champ est obligatoire';
    }


    // Si il n'y a pas d'erreurs, on met à jour le rdv.
    if(empty($errorsArray) ){
        $appointment = new Appointment($dateHour, $idPatients);
 
        $response = $appointment->update($id);
        // Si $response appartient à la classe PDOException (Si une exception est retournée),
        // on stocke un message d'erreur à afficher dans la vue
        if($response instanceof PDOException){
            $message = $response->getMessage();
        } else {
            $message = MSG_UPDATE_RDV_OK;
        }
    }

}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/appointments/form-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/