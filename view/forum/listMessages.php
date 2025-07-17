<?php
   //$category = $result["data"]['category']; 
   //$topics = $result["data"]['topics']; 
   $messages = $result["data"]['messages']; 
   
?>

<h1>Liste des Messages : Topic "à retrouver"</h1>

<?php
foreach($messages as $message ){ 
    
    //var_dump($message);
    ?>
    <div class="Box">
        <p><?= $message->getContent() ?>  par <?= $message->getUser() ?></p>
</div>
<?php }
