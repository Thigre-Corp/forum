<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

    private $id;
    private $nickName;
    private $password; 
    private $email;
    private $creationDate;
    private $role;


    public function __construct($data){         
        $this->hydrate($data);                    // app/entity.php : User EXTENDS entity
    }


    /**
     * get role
     */
    public function getRole(){
        return $this->role;
    }

    public function getAll(){
        return (get_object_vars($this)); 
    }

    /**
     * has role
     */
    public function hasRole($role){
        return in_array($role, json_decode($this->getRole()));
    }
        

    /**
     * set Role
     */
    public function setRole($newRole){
        $this->role = $newRole;
        return $this;
    }

    /**
     * get the value of the password
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * Set the password
     */
    public function setPassword($newPassword){
        $this->password = $newPassword;
        return $this;
    }

    /**
     * Get email
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set email
     */
    public function setEmail($newEmail){
        $this->email = $newEmail;
        return $this;
    }

    /**
     * get CreationDate
     */
    public function getCreationDate(){
        return $this->creationDate;
    }

    /**
     * set creationDate
     */
    public function setCreationDate($newDate){
        $this->creationDate = $newDate;
        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName(){
        return $this->nickName;
    }

    /**
     * Set the value of nickName
     *
     * @return  self
     */ 
    public function setNickName($newNickName){
        $this->nickName = $newNickName;

        return $this;
    }

    public function __toString() {
        return $this->nickName;
    }
}