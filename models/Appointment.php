<?php
require_once(dirname(__FILE__).'/../utils/database.php');

class Appointment{

    private $_dateHour;
    private $_idPatients;
    private $_pdo;

    /**
     * Méthode magique qui permet d'hydrater notre objet 'patient'
     * 
     * @return boolean
     */
    public function __construct($dateHour=NULL, $idPatients=NULL){
        // Hydratation de l'objet contenant la connexion à la BDD
        
        $this->_dateHour = $dateHour;
        $this->_idPatients = $idPatients;

        try{
            $this->_pdo = Database::getInstance();
        } catch(PDOException $ex){
            return $ex;
        }
    }

    /**
     * Méthode qui permet de créer un rendez-vous
     * 
     * @return boolean
     */
    public function create(){

        try{
            $sql = 'INSERT INTO `appointments` (`dateHour`, `idPatients`) 
                    VALUES (:dateHour, :idPatients)';
            $sth = $this->_pdo->prepare($sql);

            $sth->bindValue(':dateHour',$this->_dateHour,PDO::PARAM_STR);
            $sth->bindValue(':idPatients',$this->_idPatients,PDO::PARAM_INT);
            $result = $sth->execute();

            if($result === false){
                throw new PDOException(ERR_CREATE_APPOINTMENT_NOTOK);
            } else {
                return true;
            }
            
        }
        catch(PDOException $ex){
            return $ex;
        }

    }

     /**
     * Méthode qui permet de récupérer le rendez-vous d'un patient
     * 
     * @return object
     */
    public static function get($id){
        
        $pdo = Database::getInstance();

        try{
            $sql = 'SELECT * FROM `appointments` WHERE `id` = :id';
            $sth = $pdo->prepare($sql);

            $sth->bindValue(':id',$id,PDO::PARAM_INT);

            $result = $sth->execute();
            if($result){
                $appointment = $sth->fetch();
                if($appointment===false){
                    //RDV non trouvé
                    throw new PDOException('Rendez-vous non trouvé');
                } else {
                    return $appointment;
                }
            } else {
                //Erreur générale
                throw new PDOException('Erreur d\'exécution de la requête');
            }

        }
        catch(PDOException $ex){
            return $ex;
        }

    }

    /**
     * Méthode qui permet de lister tous les patients ou selon un id
     * 
     * @return boolean
     */
    public static function getAll($id=null){

        
        try{
            $pdo = Database::getInstance();

            if(is_null($id)){
                $sql = '    SELECT `appointments`.`id` as `appointmentId`, `patients`.`id` as `patientId`, `patients`.*, `appointments`.* 
                            FROM `appointments` 
                            INNER JOIN `patients`
                            ON `appointments`.`idPatients` = `patients`.`id`
                            ORDER BY `appointments`.`dateHour` DESC
                            ;';
                $sth = $pdo->query($sql);
            } else {
                $sql = '    SELECT `appointments`.`id` as `appointmentId`, `patients`.`id` as `patientId`, `patients`.*, `appointments`.* 
                            FROM `appointments` 
                            INNER JOIN `patients`
                            ON `appointments`.`idPatients` = `patients`.`id`
                            WHERE `appointments`.`idPatients` = :id
                            ORDER BY `appointments`.`dateHour` DESC
                            ;';
                $sth = $pdo->prepare($sql);
                $sth->bindValue(':id', $id, PDO::PARAM_INT);
                $sth->execute();
            }


            if($sth === false){
                throw new PDOException(ERR_PDO);
            } else {
                return $sth->fetchAll();
            }
            
        }
        catch(PDOException $ex){
            return $ex;
        }

    }


    /**
     * Méthode qui permet de modifier un rdv
     * 
     * @return boolean
     */
    public function update($id){

        try{
            $sql = 'UPDATE `appointments` SET `dateHour` = :dateHour, `idPatients` = :idPatients
                    WHERE `id` = :id';

            $sth = $this->_pdo->prepare($sql);

            $sth->bindValue(':dateHour',$this->_dateHour,PDO::PARAM_STR);
            $sth->bindValue(':idPatients',$this->_idPatients,PDO::PARAM_INT);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);

            $result = $sth->execute();
            if($result === false){
                throw new PDOException(ERR_UPDATE_RDV_NOTOK);
            }
        }
        catch(PDOException $ex){
            return $ex;
        }

    }

    /**
     * Méthode qui permet de supprimer un rendez-vous
     * 
     * @return boolean
     */
    public static function delete($id){

        try{

            $pdo = Database::getInstance();
            $sql = 'DELETE FROM `appointments`
                    WHERE `id` = :id;';

            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            if($sth === false){
                throw new PDOException(ERR_PDO);
            } else {
                if($sth->rowCount()==0)
                    throw new PDOException(ERR_DELETE_RDV_APPOINTMENT_NOTOK);
                else
                    throw new PDOException(MSG_DELETE_RDV_APPOINTMENT_OK);
            }
            
        }
        catch(PDOException $ex){
            return $ex;
        }

    }


}