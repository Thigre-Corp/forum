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
}