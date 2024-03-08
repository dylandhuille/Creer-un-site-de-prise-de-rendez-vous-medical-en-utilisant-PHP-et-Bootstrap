<?php

require_once(dirname(__FILE__).'/../utils/database.php');

class Patient{

    private $_firstname;
    private $_lastname;
    private $_birthdate;
    private $_phone;
    private $_mail;
    
    private $_pdo;

    
    /**
     * Méthode magique qui permet d'hydrater notre objet 'patient'
     * 
     * @return boolean
     */
    public function __construct($lastname=NULL, $firstname=NULL, $birthdate=NULL, $phone=NULL, $mail=NULL){
        
        // Hydratation de l'objet contenant la connexion à la BDD
        
        $this->_lastname = $lastname;
        $this->_firstname = $firstname;
        $this->_birthdate = $birthdate;
        $this->_phone = $phone;
        $this->_mail = $mail;
        
        try{
            $this->_pdo = Database::getInstance();
        } catch(PDOException $ex){
            return $ex;
        }
    }


    /**
     * Méthode qui permet de créer un patient
     * 
     * @return int
     */
    
    public function create(){

        try{
            if(!$this->isExist($this->_mail)){

                    $sql = 'INSERT INTO `patients` (`lastname`, `firstname`, `birthdate`, `phone`, `mail`) 
                            VALUES (:lastname, :firstname, :birthdate, :phone, :mail);';

                    $sth = $this->_pdo->prepare($sql);
                    $sth->bindValue(':lastname',$this->_lastname,PDO::PARAM_STR);
                    $sth->bindValue(':firstname',$this->_firstname,PDO::PARAM_STR);
                    $sth->bindValue(':birthdate',$this->_birthdate,PDO::PARAM_STR);
                    $sth->bindValue(':phone',$this->_phone,PDO::PARAM_STR);
                    $sth->bindValue(':mail',$this->_mail,PDO::PARAM_STR);
                    $result = $sth->execute();

                    if($result === false){
                        throw new PDOException(ERR_CREATE_PATIENT_NOTOK);
                    } else {
                        return true;
                    }
                
            } else {
                throw new PDOException(ERR_PATIENTEXIST);
            }
        } catch(PDOException $ex){
            return $ex;
        }

    }

    
    /**
     * Méthode permettant de savoir si un mail existe
     * 
     */
    public static function isExist($mail){
        try{
            $pdo = Database::getInstance();
            $sql = 'SELECT `mail` FROM `patients` 
                    WHERE `mail` = :mail;';

            $sth = $pdo->prepare($sql);
            $sth->bindValue(':mail',$mail,PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetchColumn();
            if($result){
                return true;
            }
        }
        catch(PDOException $ex){
            throw new PDOException($ex);
        }

    }

    /**
     * Méthode qui permet de lister tous les patients existants
     * 
     * @return array
     */
    public static function getAll($search='', $limit=null, $offset=0){
        
        try{
            $pdo = Database::getInstance();

             // Si la limite n'est pas définie, il faut tout lister
            if(is_null($limit)){
                $sql = 'SELECT * FROM `patients` 
                WHERE `lastname` LIKE :search 
                OR `firstname` LIKE :search;';
            } else {
                $sql = 'SELECT * FROM `patients` 
                WHERE `lastname` LIKE :search 
                OR `firstname` LIKE :search 
                LIMIT :limit OFFSET :offset;';
            }

            $sth = $pdo->prepare($sql);
            $sth->bindValue(':search','%'.$search.'%',PDO::PARAM_STR);
            
            if(!is_null($limit)){
                $sth->bindValue(':offset', $offset, PDO::PARAM_INT);
                $sth->bindValue(':limit', $limit, PDO::PARAM_INT);
            }
            
            $result = $sth->execute();

            if($result === false){
                throw new PDOException(ERR_PDO);
            } else {
                return($sth->fetchAll());
            }
            
        }
        catch(PDOException $ex){
            return $ex;
        }

    }

    
    /**
     * get
     *
     * @param  mixed $id
     */
    public static function get($id){

        try {
            $pdo = Database::getInstance();
            $sql = 'SELECT * FROM patients WHERE `id` = :id;';

            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);

            $result = $sth->execute();
            if($result){
                $patient = $sth->fetch();
                if($patient===false){
                    //Patient non trouvé
                    throw new PDOException('Patient non trouvé');
                } else {
                    return $patient;
                }
            } else {
                //Erreur générale
                throw new PDOException('Erreur d\'exécution de la requête');
            }

        } catch (\PDOException $ex) {
            return $ex;
        }


    }

    /**
     * Méthode qui permet de mettre à jour un patient
     * 
     * @return boolean
     */
    public function update($id){
        try{
            // On récupère le patient
            $response = $this::get($id);
            
            //Si la réponse est une erreur on sort via le catch
            if($response instanceof PDOException){
                throw new PDOException($response->getMessage());
            }

            // Si le mail n'existe pas en base ou que ça n'est pas déjà le mail du patient que l'on modifie
            // on a le droit de faire les modifs
            if(!$this->isExist($this->_mail) || $this->_mail==$response->mail){
                $sql = 'UPDATE `patients` SET `lastname` = :lastname, `firstname` = :firstname, `birthdate` = :birthdate, `phone` = :phone, `mail` = :mail
                        WHERE `id` = :id;';

                $sth = $this->_pdo->prepare($sql);
                $sth->bindValue(':lastname',$this->_lastname,PDO::PARAM_STR);
                $sth->bindValue(':firstname',$this->_firstname,PDO::PARAM_STR);
                $sth->bindValue(':birthdate',$this->_birthdate,PDO::PARAM_STR);
                $sth->bindValue(':phone',$this->_phone,PDO::PARAM_STR);
                $sth->bindValue(':mail',$this->_mail,PDO::PARAM_STR);
                $sth->bindValue(':id',$id,PDO::PARAM_INT);
                $result = $sth->execute();

                if($result === false){
                    throw new PDOException(ERR_UPDATE_PATIENT_NOTOK);
                }
                
            } else {
                throw new PDOException(ERR_PATIENTEXIST);
            }
        } catch(PDOException $ex){
            return $ex;
        }
    }

    /**
     * Méthode qui permet de compter les patients
     * 
     * @return int
     */

    public static function count($s){

        try {

            $pdo = Database::getInstance();

            $sql = 'SELECT COUNT(`id`) as `nbPatients` FROM `patients`
                    WHERE `lastname` LIKE :search 
                    OR `firstname` LIKE :search;';

            $sth = $pdo->prepare($sql);
            $sth->bindValue(':search','%'.$s.'%',PDO::PARAM_STR);
            $result = $sth->execute();
            if($result === false){
                throw new PDOException(ERR_PDO);
            } else {
                $count = $sth->fetchColumn();
                if($count === false){
                    return 0;
                } else {
                    return $count;
                }
            }
        
        } catch (\PDOException $ex) {
            return 0;
        }
        

    }

    /**
     * Méthode qui permet de supprimer un patient
     * 
     * @return boolean
     */
    public static function delete($id){

        try{
            $pdo = Database::getInstance();
            $sql = 'DELETE FROM `patients`
                    WHERE `id` = :id;';

            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            
            $sth->execute();
            if($sth === false){
                throw new PDOException(ERR_PDO);
            } else {
                if($sth->rowCount()==0)
                    throw new PDOException(ERR_DELETE_PATIENT_NOTOK);
                else
                    throw new PDOException(MSG_DELETE_PATIENT_OK);
            }
        }
        catch(PDOException $ex){
            return $ex;
        }

    }

}