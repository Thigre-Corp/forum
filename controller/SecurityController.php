<?php
namespace Controller;

use App\DAO;
use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function registerForm () {
        return [
            "view" => VIEW_DIR."/security/register.php",
            "meta_description" => "Page d'inscription du forum"
        ];

    }

    public function loginForm () {
        return [
            "view" => VIEW_DIR."/security/login.php",
            "meta_description" => "Page de connexion du forum"
        ];
    }

    public function login(){
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

            if(password_verify($pass1, $userData['password'])){                 // là, nous sommes connectés.. on démarre la session ?
                Session::setUser($userData);
                Session::addFlash("success", "user logged In");
                $this->redirectTo("home");
            }
            
            else{
                Session::addFlash("error", "loupé!");
                $this->redirectTo("security", "registerForm");
            }

            return [                                                            // une fois le user logger, direction la homePage.
                "view" => VIEW_DIR."/home.php",
                "meta_description" => "Page d'accueil"
                ];
        }
        $this->redirectTo("security", "loginForm");
        // redirect to
    }


    public function register(){
        if( empty($_POST)) {
            $this->redirectTo("security", "registerForm");
            die; // necessaire  ???
        }

        $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_VALIDATE_REGEXP,array("options" => array("regexp"=>'/[A-Za-z0-9]{6,32}/')));
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($pseudo && $email && $pass1 && $pass2){                             // si tout est renseigné
            $userManager = new UserManager() ;
            if ( !$userManager->checkIfExists($email) ){                        // et que l'email n'exisite pas en DB
                if( $pass1 == $pass2 && strlen($pass1)>=8 ){                   // et que le MDP correspond à la confirmation ET qu'il comporte + de 5 caractères
                    $userManager->add([                                         // alors on l'ajoute en DB
                        "nickName" => strtolower($pseudo), 
                        "email" => strtolower($email), 
                        "password" => password_hash($pass1, PASSWORD_DEFAULT),
                        "role" => json_encode(['ROLE_ADMIN'])
                    ]);
                }
                else {
                    $this->redirectTo("security", "loginForm");                                         // sinon retour case register
                }
            }
            else{
                Session::addFlash("error", "Cet e-mail existe déjà !");
            }

            Session::addFlash("success", "Inscription réussie, connectez-vous !");
            $this->redirectTo("security", "login");
        }

        return [                                                            // une fois le user créer, direction le login. Idem s'il existe déjà.
                "view" => VIEW_DIR."/security/login.php",
                "meta_description" => "Page de connexion du forum"
                ];
    }

    public function logout () {
        $this->restrictTo("ROLE_USER");

        Session::setUser(null);
        Session::addFlash("success", "A bientôt !");
        $this->redirectTo("home");
    }

}
/***********************************
 * 
 * 
 * 
 * 


    public function register(){
            if(!empty($_POST)){
                $username = filter_input(INPUT_POST, "username", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{4,}/')
                    )
                );
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $pass = filter_input(INPUT_POST, "pass", FILTER_VALIDATE_REGEXP,
                    array(
                        "options" => array("regexp"=>'/[A-Za-z0-9]{6,32}/')
                    )
                );
                $passrepeat = filter_input(INPUT_POST, "pass-r", FILTER_SANITIZE_STRING);

                if($username && $email){
                    if($pass){
                        if($pass === $passrepeat){
                            //embeter la base de données
                            $manager = new UserManager();
                            if(!$manager->checkUserExists($email)){
                                $manager->add([
                                    "username" => strtolower($username),
                                    "email"    => strtolower($email),
                                    "password" => password_hash($pass, PASSWORD_ARGON2I),
                                    "roles"    => json_encode(['ROLE_USER'])
                                ]); 
                                Session::addFlash("success", "Inscription réussie, connectez-vous !");
                                $this->redirectTo("security", "login");
                            }
                            else{
                                Session::addFlash("error", "Cet e-mail existe déjà !");
                            }
                        }
                        else{
                            Session::addFlash("error", "Les deux mots de passe ne correspondent pas.");
                        }
                    }
                    else{
                        Session::addFlash("error", "Le mot de passe est invalide.");
                    }
                }
                else{
                    Session::addFlash("error", "Le pseudo ou l'email sont vides.");
                }
            }
            return [
                "view" => VIEW_DIR."security/register.php"
            ];
        }
*/