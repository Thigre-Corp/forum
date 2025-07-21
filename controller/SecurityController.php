<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {
        return [
            "view" => VIEW_DIR."/security/register.php",
            "meta_description" => "Page d'inscription du forum"
        ];

    }
    public function login () {
        return [
            "view" => VIEW_DIR."/security/login.php",
            "meta_description" => "Page de connexion du forum"
        ];
    }

    public function registering(){
        $pseudo= filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2= filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($pseudo && $email && $pass1 && $pass2){
            $requete = $pdo->prepare("
            SELECT *
            FROM user
            WHERE email = :email");
            $requete->execute(["email" => $email]);
            $user = $requete->fetch();

            if($user){
                header("location: login.php"); exit;
            }
            else{
                if( $pass1 == $pass2 &&  strlen($pass1)>=5 ){
                    $insertUser = $pdo->prepare("
                    INSERT INTO user (pseudo, email, pass)
                    VALUES
                    (:pseudo, :email, :password)");
                    $insertUser->execute([
                        "pseudo" => $pseudo, 
                        "email" => $email, 
                        "password" => password_hash($pass1, PASSWORD_DEFAULT)
                    ]);
                }
            }
        }
    }

    public function logout () {}

}