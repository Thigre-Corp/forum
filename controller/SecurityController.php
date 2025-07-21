<?php
namespace Controller;

use App\DAO;
use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

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

    public function logging(){
        $userManager = new UserManager() ;

        $pseudo= filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($pseudo && $pass1){
            $sql = "
                SELECT *
                FROM user
                WHERE nickName = :pseudo
                ";
            $userData = DAO::select($sql, [":pseudo" => $pseudo], false );
            //var_dump($userData);die;
            if(password_verify($pass1, $userData['password'])){                 // là, nous sommes connectés.. on démarre la session ?
                var_dump('yes');die;
            }
            else{
                var_dump('no');die; // raté.. message flash etc....
            }
            return [                                                            // une fois le user logger, direction la homePage.
                "view" => VIEW_DIR."/home.php",
                "meta_description" => "Page d'accueil"
                ];
        }
        $this->login();
    }


    public function registering(){
        $userManager = new UserManager() ;
        $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($pseudo && $email && $pass1 && $pass2){                             // si tout est renseigné
            if ( !$userManager->checkIfExists($email) ){                        // et que l'email n'exisite pas en DB
                if( $pass1 == $pass2 &&  strlen($pass1)>=5 ){                   // et que le MDP correspond à la confirmation ET qu'il comporte + de 5 caractères
                    $userManager->add([                                         // alors on l'ajoute en DB
                        "nickName" => $pseudo, 
                        "email" => $email, 
                        "password" => password_hash($pass1, PASSWORD_DEFAULT),
                        "role" => '{"role" : "user"}'
                    ]);
                }
                else {
                    $this->register();                                         // sinon retour case register
                }
            }
        }

        return [                                                            // une fois le user créer, direction le login. Idem s'il existe déjà.
                "view" => VIEW_DIR."/security/login.php",
                "meta_description" => "Page de connexion du forum"
                ];
    }

    public function logout () {}

}