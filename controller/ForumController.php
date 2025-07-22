<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\MessageManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id); // pas sûr que çà retourne quoi que ce soit d'exploitable... GENERATOR [6] ???.???.?

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function listMessagesByTopic($id){
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topic = $topicManager->findOneById($id);
        $messageManager = new MessageManager();
        $messages = $messageManager->findMessagesByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listMessages.php",
            "meta_description" => "Liste des messages par topic : ".$topic->getTitle(),
            "data" => [
                "category" => $category,
                "topic" => $topic,
                "messages" => $messages
            ]
        ];



    }
//fonction ajout nouvelle catégorie
    public function addCategory(){
        $categoryManager = new CategoryManager();
        $newCatValue = filter_var($_POST['newCategory'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data = ['name' => $newCatValue];
        $categoryManager->add($data);
        $categories = $categoryManager->findAll(["name", "DESC"]);
        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }
//fonction ajout nouveau topic
    public function addTopicToCategory($id){
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        //$messageManager = new MessageManager();
    //le temps d'ajouter la session, l'user par défaut sera l'ID #1    
        $userId = Session::getUser()->getId();
        $title = filter_var($_POST['newTopicTitle'], FILTER_SANITIZE_SPECIAL_CHARS);
       // $messageContent = filter_var($_POST['newTopicMessage'], FILTER_SANITIZE_SPECIAL_CHARS);
    // création du topic
        $data = [
            'category_id' => $id ,
            'title' => $title ,
            'user_id' => $userId
        ];
        $topicManager->add($data);
        $topicId = $topicManager->getLastInsertId();
    // création du 1er message du topic fraichement créé
/*         $data = [
            'content' => $messageContent,
            'topic_id' => $topicId,
            'user_id' => $userId
        ];
        $messageManager->add($data); */
    // affichage view        
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id); // pas sûr que çà retourne quoi que ce soit d'exploitable... GENERATOR [6] ???.???.?

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];

    }

// ajout d'un message dans un topic existant:
    public function addMessageToTopic($id){
        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $messageManager = new MessageManager();
        $topic = $topicManager->findOneById($id);
    //le temps d'ajouter la session, l'user par défaut sera l'ID #1    
        $userId = Session::getUser()->getId();
        $messageContent = filter_var($_POST['newMessage'], FILTER_SANITIZE_SPECIAL_CHARS);
    // création du message du topic fraichement créé
        $data = [
            'content' => $messageContent,
            'topic_id' => $id,
            'user_id' => $userId
        ];
        $messageManager->add($data);
    // affichage view        
        $messages = $messageManager->findMessagesByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listMessages.php",
            "meta_description" => "Liste des messages par topic : ".$topic,
            "data" => [
                //"category" => $category,
                "topic" => $topic,
                "messages" => $messages
            ]
        ];
    }
}