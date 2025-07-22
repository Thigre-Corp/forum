<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics de la categorie <?= $category->getName() ?></h1>

<?php

if (isset($topics)){
    foreach($topics as $topic ){ 

        ?>
            <div class="Box">
                <p><a href="index.php?ctrl=forum&action=listMessagesByTopic&id=<?= $topic->getId() ?>"> <?= $topic ?></a> par <?= $topic->getUser() ?></p>
            </div>
        <?php }
}
else{
?>
            <div class="Box">
                <p>Y a rien !!!!!!!!!!!</p>
            </div>
        <?php 
}

 ?>
<div class="adder">
    <form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId() ?>" method="post">
        <label for="newTopicTitle">Créer un nouveau topic: </label>
            <input type='text' name="newTopicTitle" value='ex: tournevis'></input>
<!--         <label for="newTopicMessage">Y inclure le message suivant: </label>
            <input type='text' name="newTopicMessage" value='ex: message par défaut'></input> -->
        <input type='submit' value='add'></input>
    </form>
</div>
            