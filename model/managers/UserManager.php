<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    public function checkIfExists($email){

        $sql = "
                SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.email = :email";
       
        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false), 
            $this->className
        );
    }

    public function findOneByPseudo($pseudo){

        $sql = "
                SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.nickName = :pseudo";
       
        return $this->getOneOrNullResult(
            DAO::select($sql, ['pseudo' => $pseudo], false), 
            $this->className
        );
    }

    public function updateUser($id, $data){
        $string = '';
        
        foreach($data as $key=> $value){
            $string = $string.$key. " = '".$value."', ";
        }
        $string = (substr($string,0,strlen($string)-2));

        $sql = "
            UPDATE ".$this->tableName."
            SET ".$string."

            WHERE id_user = :id
        ";

        DAO::update($sql, ['id' => $id], false);
        return ;

    }


}