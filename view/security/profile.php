<?php
    $user = $result["data"]['user']; 
    $user['role']= (json_decode($user['role'])[0]);
?>

<h1>Profil Utilisateur de <?=$user['nickName']?></h1>

<div class="profile box">
    <form action="#" name="profileEdit">
<?php

var_dump(($user['role']));
foreach($user as $userKey => $userValue ){

    if($userKey == 'password' || $userKey == 'id'){
        continue;
    }
?>
    <div class="Box <?=$userKey?>">
        <label for="$userKey"><?=$userKey?></label><br>
        <input style="width :90%;" type="text" value="<?=$userValue?>"></input>
    </div>

<?php } ?>
        <label for="suprr">Supprimer le profil ?</label>
        <input type='checkbox' value="off" name="suppr" id="suppr"></input><br>
        <input type='submit' value='Appliquer les modifications'></input>

    </form>
</div>