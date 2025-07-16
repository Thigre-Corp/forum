<?php
namespace Model\Entities;

use App\Entity;


/***************
 * 
 * 
 *  sanitization des setters ??
 * 
 * 
 * 
 * 
 * 
 * 
 */













/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Message extends Entity{

    private $id;
    private $creationDate; //<- pas de setter, valeur attribué par la BDD lors de la création.
    private $content;
    private $topic; // bonne idée ???
    private $user; // bonne idée ???


    public function __construct($data){         
        $this->hydrate($data);                    // app/entity.php : User EXTENDS entity
    }
    
    
    /**
     * get CreationDate
     */
    public function getCreationDate(){
        return $this->creationDate;
    }


    /**
     * get Content
    */
    public function getContent(){
        return $this->content;
    }

    /**
     * set Content
     */
    public function setContent($newContent){
        $this->content = $newRole;
        return $this;
    }

    /**
     * get topic
     */
    public function getTopic(){
        return $this->topic;
    }

    /**
     * Set topic
     */
    public function setTopic($newTopic){
        $this->topic = $newTopic;
        return $this;
    }

    /**
     * Get user
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * Set user
     */
    public function setUser($newUser){
        $this->user = $newUser;
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

    public function __toString() {
        return $this->content;
    }
}