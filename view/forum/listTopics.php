<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic ){ 
    
    //var_dump($topic);
?>
    <div class="Box">
        <p><a href="index.php?ctrl=forum&action=listMessagesByTopic&id=<?= $topic->getId() ?>"> <?= $topic ?></a> par <?= $topic->getUser() ?></p>
    </div>
<?php }
