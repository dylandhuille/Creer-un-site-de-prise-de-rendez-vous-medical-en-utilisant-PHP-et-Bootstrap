<?php
require_once(dirname(__FILE__) . '/../models/Patient.php');

// Nettoyage de l'id du patient passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*********************************************************/

// Suppression du patient, et de tous ses rendez-vous. 
// Une contrainte ON DELETE CASCADE, permet de supprimer tous les
// enregistrements d'appointment également.  
$response = Patient::delete($id);

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