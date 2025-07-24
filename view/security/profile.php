<?php
    $user = $result["data"]['user']; 
    $user['role']= (json_decode($user['role'])[0]);
?>

<h1>Profil Utilisateur de <?=$user['nickName']?></h1>

<div class="profile box">
    <form action="index.php?ctrl=security&action=modUser&id=<?=$user["id"]?>" method="POST">
<?php

foreach($user as $userKey => $userValue ){

    if($userKey == 'password' || $userKey == 'id'){
        continue;
    }

    
?>
    <div class="Box <?=$userKey?>">
        <label for="<?=$userKey?>"><?=$userKey?></label><br>
        <input style="width :90%;" type="text" name="<?=$userKey?>" id="<?=$userKey?>" value="<?=$userValue?>"></input>
    </div>

<?php } ?>
        <label for="suppr">Supprimer le profil ?</label>
        <input type='checkbox' name="suppr" id="suppr"></input><br>
        <input type='submit' value='Appliquer les modifications'></input>

    </form>
</div>
