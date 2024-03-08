<?php

define('DSN', 'mysql:host=localhost;dbname=dwwm_hospitale2n');
define('LOGIN', 'root');
define('PASSWORD', '');
define('NB_ELEMENTS_BY_PAGE', 10);

// Définition des constantes retournées par les méthodes
define('ERR_UNKNOWN', 'Une erreur inconnue s\'est produite'); 

define('ERR_DATABASE', 'Problème de connexion à la base de données');
define('ERR_PDO', 'Une erreur SQL s\'est produite');

define('MSG_CREATE_PATIENT_OK', 'Le patient a bien été ajouté');
define('ERR_CREATE_PATIENT_NOTOK', 'Le patient n\'a pas été enregistré en base de données');
define('ERR_PATIENTEXIST', 'Le patient existe déjà');
define('ERR_PATIENT_NOT_FOUND', 'Le patient n\'a pas été trouvé');
define('MSG_UPDATE_PATIENT_OK', 'Le patient a bien été mis à jour');
define('ERR_UPDATE_PATIENT_NOTOK', 'Le patient n\'a pas été mis à jour');


define('ERR_CREATE_APPOINTMENT_NOTOK', 'Le rdv n\'a pas été créé');
define('MSG_CREATE_RDV_OK', 'Le rdv a bien été créé');
define('ERR_UPDATE_RDV_NOTOK', 'Le rdv n\'a pas été mis à jour');
define('MSG_UPDATE_RDV_OK', 'Le rdv a bien été mis à jour');
define('MSG_DELETE_RDV_APPOINTMENT_OK', 'Le rdv a bien été supprimé');
define('ERR_DELETE_RDV_APPOINTMENT_NOTOK', 'Le rdv n\'a pas été supprimé');

define('MSG_DELETE_PATIENT_OK', 'Le patient et ses rdv ont été supprimés');
define('ERR_DELETE_PATIENT_NOTOK', 'Le patient et ses rdv n\'ont pas été supprimés');

define('MSG_CREATE_PATIENT_APT_OK', 'Le patient et ses rdv ont été créés simultanément');
define('ERR_CREATE_PATIENT_APT_NOTOK', 'Le patient et ses rdv n\'ont pas été créés');







