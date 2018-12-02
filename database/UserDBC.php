<?php

namespace database;

use entities\User;
use entities\Participant;

/**
 * Description of UserDBC
 *
 * @author Lukas
 */
class UserDBC extends DBConnector {
    
    /** (tested)
     * Stores a new User into the database
     * @param type $user
     * @return boolean if registration was successful (usually email does already exist)
     */
    public function createUser($user){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO user VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssssisssssi', $firstName, $lastName, $gender, $street, $zipCode,
                $location, $email, $role, $birthDate, $password, $deleted);
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $gender = $user->getGender();
        $street = $user->getStreet();
        $zipCode = $user->getZipCode();
        $location = $user->getLocation();
        $email = $user->getEmail();
        $role = $user->getRole();
        $birthDate = $user->getBirthDate();
        $password = $user->getPassword();
        $deleted = intval(false);
        return $this->executeInsert($stmt);
    }
    
    
    /** (tested)
     * Finds User to the given email if available
     * @param type $user
     * @return String stored (hashed) password if query was successful
     *         boolean false if query failed (usually email is not stored in database)
     */
    public function findUserByEmail($search, $inputType = "object"){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user where email = ? and deleted = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('si', $email, $deleted);
        if ($inputType == "object") {
        $email = $search->getEmail();
        } elseif ($inputType == "email") {
            $email = $search;
        } else {
            exit;
            
        }
        $deleted = intval(false);
        $stmt->execute();
        $userObj = $stmt->get_result()->fetch_object("entities\User");
        
        //checks whether the given email from a User exists
        $stmt->close();
        if($userObj){
            if ($inputType == "object") {
                return $userObj;
            } else {
                return true;
            }
        }else{
            return false;
        }
    }
    
    /**
     * Sets the current timestamp for booking to avoid to fast booking
     * @return boolean
     */
    public function setTimeStamp(){
        $stmt = $this->mysqliInstance->prepare("UPDATE user SET lastBooking = ? WHERE id = ? AND deleted = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('dii', $lastBooking, $id, $deleted);
        $lastBooking = \time();
        $id = $_SESSION['userId'];
        $deleted = intval(false);
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Finds User by the given id (teleted Users too)
     * @param type $userId
     * @return boolean|User
     */
    public function findUserById($userId){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user where id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $userId;
        $stmt->execute();
        $userObj = $stmt->get_result()->fetch_object("entities\User");
        
        //checks whether the User exists
        $stmt->close();
        if($userObj){
            return $userObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Gets all Users registered ordered by firstName asc
     * @return boolean|array
     */
    public function getAllUsers(){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user WHERE deleted = ? ORDER BY firstName ASC");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $deleted);
        $deleted = intval(false);
        $stmt->execute();
        $users = array();
        $result = $stmt->get_result();
        while($user = $result->fetch_object("entities\User")){
            array_push($users, $user);
        }

        $stmt->close();
        return $users;
    }
    
    /** (tested)
     * Updates the Users password (new password must be stored in the object)
     * @param type $user
     * @return type
     */
    public function updatePassword($user){
        $stmt = $this->mysqliInstance->prepare("UPDATE user SET password = ? WHERE id = ? AND deleted = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sii', $password, $id, $deleted);
        $password = $user->getPassword();
        $id = $user->getId();
        $deleted = intval(false);
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Removes the User from access of several functions
     * @param type $user
     * @return type
     */
    public function deleteUser($user){
        if(!($this->checkLastAdmin($user))){
            return false;
        }
        $stmt = $this->mysqliInstance->prepare("UPDATE user SET deleted = ? WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ii', $deleted, $id);
        $deleted = intval(true);
        $id = $user->getId();
        return $this->executeDelete($stmt);
    }
    
    /**
     * Checks for the permission to delete or change the role for the last admin
     * @param type $user
     * @return boolean
     */
    public function checkLastAdmin($user){
        $user = $this->findUserById($user->getId());
        if(!$user){
            return false;
        }
        //Checks whether it is the last admin to delete, then it rejects the delete process
        if($user->getRole() == "admin"){
            $users = $this->getAllUsers();
            if(!$users){
                return false;
            }
            $count = 0;
            foreach($users as $u){
                if($u->getRole() == "admin"){
                    $count++;
                }
            }
            if($count <= 1){
                return false;
            }
        }
        return true;
    }
    
    /** (tested)
     * Stores a new Participant in relation to the User
     * @param type $participant
     * @return boolean
     */
    public function createParticipant($participant){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO participant VALUES (NULL, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sssii', $firstName, $lastName, $birthDate, $deleted, $fk_user_id);
        $firstName = $participant->getFirstName();
        $lastName = $participant->getLastName();
        $birthDate = $participant->getBirthDate();
        $deleted = intval(false);
        $fk_user_id = $participant->getFkUserId();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Finds any number of Participants related to the given User
     * @param type $user
     * @return boolean|array
     */
    public function findParticipants($user){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM participant WHERE fk_user_id = ? AND deleted = ? ORDER BY firstName ASC");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ii', $fk_user_id, $deleted);
        $fk_user_id = $user->getId();
        $deleted = intval(false);
        $stmt->execute();
        $participants = array();
        $result = $stmt->get_result();
        while($participant = $result->fetch_object("entities\Participant")){
            array_push($participants, $participant);
        }
        
        $stmt->close();
        return $participants;
    }
    
    /** (tested)
     * Finds Participant by the given id (teleted Participants too)
     * @param type $participantId
     * @return boolean|Participant
     */
    public function findParticipantById($participantId){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM participant where id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $participantId;
        $stmt->execute();
        $participantObj = $stmt->get_result()->fetch_object("entities\Participant");
        
        //checks whether the Participant exists
        $stmt->close();
        if($participantObj){
            return $participantObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Finds all Participants according to the Trip (deletion of Participants ignored)
     * @param type $tripId
     * @return boolean|array
     */
    public function findParticipantsToTrip($tripId){
        $stmt = $this->mysqliInstance->prepare("SELECT fk_participant_id FROM tripparticipant WHERE fk_trip_id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $fk_trip_id);
        $fk_trip_id = $tripId;
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        //Gets the real Participant objects into an array
        $participants = array();
        while($participantId = $result->fetch_assoc()){
            $participant = $this->findParticipantById($participantId["fk_participant_id"]);
            array_push($participants, $participant);
        }

        return $participants;
    }
    
    /** (tested)
     * Removes Participant from access of several functions
     * @param type $participant
     * @return boolean
     */
    public function deleteParticipant($participant){
        $stmt = $this->mysqliInstance->prepare("UPDATE participant SET deleted = ? WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ii', $deleted, $id);
        $deleted = intval(true);
        $id = $participant->getId();
        return $this->executeInsert($stmt);
    }

    
    /** (tested)
     * Updates the role of the given User
     * @param type $user
     * @return boolean
     */
    public function updateRole($user){
        $stmt = $this->mysqliInstance->prepare("UPDATE user SET role = ? WHERE id = ? AND deleted = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sii', $role, $id, $deleted);
        $role = $user->getRole();
        $id = $user->getId();
        $deleted = intval(false);
        return $this->executeInsert($stmt);
    }
    
        public function checkByEmail($email){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user where email = ? and deleted = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('si', $email, $deleted);
        $deleted = intval(false);
        $stmt->execute();
        $userObj = $stmt->get_result()->fetch_object("entities\User");
        
        //checks whether the given email from a User exists
        $stmt->close();
        if($userObj){
            return true;
        }else{
            return false;
        }
    }
}
