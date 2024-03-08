<?php
include(dirname(__FILE__) . '/../config/regexp.php');
include(dirname(__FILE__) . '/../models/Patient.php');
include(dirname(__FILE__) . '/../models/Appointment.php');

// Initialisation du tableau d'erreurs
$errorsArray = array();
/*************************************/

// Appel à la méthode statique permettant de récupérer tous les patients
$allPatients = Patient::getAll();
/*************************************************************/

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // DATE ET HEURE DE RDV
    // On verifie l'existance et on nettoie
    $dateHour = trim(filter_input(INPUT_POST, 'dateHour', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
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

    $idPatients = intval(trim(filter_input(INPUT_POST, 'idPatients', FILTER_SANITIZE_NUMBER_INT)));
    //On test si le champ n'est pas vide
    if($idPatients==0){
        $errorsArray['dateHour_error'] = 'Le champ est obligatoire';
    }

    // Si il n'y a pas d'erreurs, on enregistre un nouveau rdv.
    if(empty($errorsArray) ){
        // On hydrate l'objet appointment en effectuant une instance de la classe Appointment
        $appointment = new Appointment($dateHour,$idPatients);

        $response = $appointment->create();
        // Si $response appartient à la classe PDOException (Si une exception est retournée),
        // on stocke un message d'erreur à afficher dans la vue
        if($response instanceof PDOException){
            $message = $response->getMessage();
        } else {
            $message = MSG_CREATE_RDV_OK;
        }
        /*************************************************************/
    }

}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/appointments/form-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/