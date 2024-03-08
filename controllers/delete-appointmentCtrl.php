<?php
require_once(dirname(__FILE__) . '/../models/Appointment.php');

// Nettoyage de l'id du rendez-vouspassé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*********************************************************/

// Appel à la méthode statique permettant de supprimer le RDV
$response = Appointment::delete($id);

// Si $response appartient à la classe PDOException (Si une exception est retournée),
// on stocke un message d'erreur à afficher dans la vue
if($response instanceof PDOException){
    $message = $response->getMessage();
}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/templates/display-message.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/