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

         $user=   $userManager->findOneByPseudo($pseudo);


            // var_dump($user);
            // die;
            // $sql = "
            //     SELECT *
            //     FROM user
            //     WHERE nickName = :pseudo
            //     ";
            // $userData = DAO::select($sql, [":pseudo" => $pseudo], false );
           

            if(password_verify($pass1, $user->getPassword())){                 // là, nous sommes connectés.. on démarre la session ?
                
                Session::setUser($user);
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
            Session::addFlash("error", "Inscription ratée, retente ta chance !");
            $this->redirectTo("security", "registerForm");
        }

        $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_VALIDATE_REGEXP,array("options" => array("regexp"=>'/[A-Za-z0-9]{6,32}/')));
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($pseudo && $email && $pass1 && $pass2){                             // si tout est renseigné
            $userManager = new UserManager() ;
            if ( !$userManager->checkIfExists($email) ){                        // et que l'email n'exisite pas en DB
                if( $pass1 == $pass2 && strlen($pass1)>=5 ){                   // et que le MDP correspond à la confirmation ET qu'il comporte + de 5 caractères
                    $userManager->add([                                         // alors on l'ajoute en DB
                        "nickName" => ucfirst(strtolower($pseudo)), 
                        "email" => strtolower($email), 
                        "password" => password_hash($pass1, PASSWORD_DEFAULT),
                        "role" => json_encode(['ROLE_USER'])
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
        // $this->restrictTo("ROLE_USER");
        Session::setUser(null);
        Session::addFlash("success", "A bientôt !");
        $this->redirectTo("home");
    }

    public function profile($id = false){
        Session::addFlash("success", "ici devrait se trouver la page profile");
        if (!$id){
            $id = Session::getUser()->getId();
        }
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR."security/profile.php",
            "meta_description" => "Profil utilisateur ",
            "data" => [
                "user" => $user->getAll()
            ]
        ];
    }




    public function users(){
        Session::addFlash("success", "ici devrait se trouver la fameuse liste des gens");

        $userManager = new UserManager();
        $users = $userManager->findAll(); 
        return [
            "view" => VIEW_DIR."security/listUsers.php",
            "meta_description" => "Liste des Users ",
            "data" => [
                "users" => $users
            ]
        ];
    }


}