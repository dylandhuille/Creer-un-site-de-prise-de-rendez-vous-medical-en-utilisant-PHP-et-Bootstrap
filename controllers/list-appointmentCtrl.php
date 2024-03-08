<?php
require_once(dirname(__FILE__) . '/../models/Patient.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

$appointments = Appointment::getAll();

// Si $response appartient à la classe PDOException (Si une exception est retournée),
// on stocke un message d'erreur à afficher dans la vue
if($appointments instanceof PDOException){
    $message = $appointments->getMessage();
}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/appointments/list-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/