<?php
   //$category = $result["data"]['category']; 
   $topic = $result["data"]['topic']; 
   $messages = $result["data"]['messages']; 
   
?>

<h1>Liste des Messages du topic <?= $topic->getTitle() ?> ></h1>

<?php

if (isset($messages)) {
    foreach($messages as $message ){ 
        
        //var_dump($message);
        ?>
        <div class="Box">
            <p><?= $message->getContent() ?>  par <?= $message->getUser() ?></p>
    </div>
    <?php }
}
else{
    ?>
        <div class="Box">
            <p>AUCUN MESSAGE A AFFICHER</p>
        </div>
    <?php 
} ?>

<div class="adder">
    <form action="index.php?ctrl=forum&action=addMessageToTopic&id=<?= $topic->getId() ?>" method="post">
        <label for="newMessage">Ajoute un nouveau message: </label>
            <input type='text' name="newMessage" value='ex: message par défaut'></input>
        <input type='submit' value='add'></input>
    </form>
</div>

