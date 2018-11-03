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
        $stmt = $this->mysqliInstance->prepare("INSERT INTO user VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sssisssss', $firstName, $lastName, $street, $zipCode, 
                $location, $email, $role, $birthDate, $password);
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $street = $user->getStreet();
        $zipCode = $user->getZipCode();
        $location = $user->getLocation();
        $email = $user->getEmail();
        $role = $user->getRole();
        $birthDate = $user->getBirthDate();
        $password = $user->getPassword();
        return $this->executeInsert($stmt);
    }
    
    
    /** (tested)
     * Finds User to the given email if available
     * @param type $user
     * @return String stored (hashed) password if query was successful
     *         boolean false if query failed (usually email is not stored in database)
     */
    public function findUserByEmail($user){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user where email = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('s', $email);
        $email = $user->getEmail();
        $stmt->execute();
        $userObj = $stmt->get_result()->fetch_object("entities\User");
        
        //checks whether the given email from a User exists
        $stmt->close();
        if($userObj){
            return $userObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Finds User by the given id
     * @param type $user
     * @return boolean|User
     */
    public function findUserById($user){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $user->getId();
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
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM user ORDER BY firstName ASC");
        if(!$stmt){
            return false;
        }
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
        $stmt = $this->mysqliInstance->prepare("UPDATE user SET password = ? WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('si', $password, $id);
        $password = $user->getPassword();
        $id = $user->getId();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Deletes a User from the database by the given id
     * @param type $user
     * @return type
     */
    public function deleteUser($user){
        $stmt = $this->mysqliInstance->prepare("DELETE FROM user WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $user->getId();
        return $this->executeDelete($stmt);
    }
    
    /** (tested)
     * Stores a new Participant in relation to the User
     * @param type $participant
     * @return boolean
     */
    public function createParticipant($participant){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO participant VALUES (NULL, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sssi', $firstName, $lastName, $birthDate, $fk_user_id);
        $firstName = $participant->getFirstName();
        $lastName = $participant->getLastName();
        $birthDate = $participant->getBirthDate();
        $fk_user_id = $participant->getFkUserId();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Finds any number of Participants related to the given User
     * @param type $user
     * @return boolean|array
     */
    public function findParticipants($user){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM participant where fk_user_id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $fk_user_id);
        $fk_user_id = $user->getId();
        $stmt->execute();
        $participants = array();
        $result = $stmt->get_result();
        while($participant = $result->fetch_object("entities\Participant")){
            array_push($participants, $participant);
        }
        
        //checks whether there is at least one Participant
        $stmt->close();
        if($participants){
            return $participants;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Updates the role of the given User
     * @param type $user
     * @return boolean
     */
    public function updateRole($user){
        $stmt = $this->mysqliInstance->prepare("UPDATE user SET role = ? WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('si', $role, $id);
        $role = $user->getRole();
        $id = $user->getId();
        return $this->executeInsert($stmt);
    }
    
}
