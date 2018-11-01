<?php

namespace entities;

use database\UserDBC;

/**
 * Description of Participant
 *
 * @author Lukas
 */
class Participant {
    
    private $id;
    private $firstName;
    private $lastName;
    private $birthDate;
    private $fk_user_id;
    private $userDBC;
    
    public function __construct() {
        $this->userDBC = new UserDBC();
    }
    
    /** (tested)
     * Creates a new Participant
     * @return type
     */
    public function createParticipant(){
        return $this->userDBC->createParticipant($this);
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }
    
    public function getFkUserId(){
        return $this->fk_user_id;
    }
    
    public function setId($id) {
        /* @var $id type int*/
        $this->id = (int) $id;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }
    
    public function setFkUserId($fk_user_id){
        /* @var $fk_user_id type int*/
        $this->fk_user_id = (int) $fk_user_id;
    }

}
