<?php
   $category = $result["data"]['category']; 
   $topics = $result["data"]['topics']; 
   //aka();
   $messages = $result["data"]['content']; 
   var_dump($result);
?>

<h1>Liste des Messages</h1>

<?php
foreach($messages as $message ){ ?>
    <p><a href="index.php?ctrl=forum&action=listMessagesByTopic&id=<?= $category->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
<?php }
