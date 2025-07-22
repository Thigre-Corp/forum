<?php
    $user = $result["data"]['user']; 
?>

<h1>Profil Utilisateur de <?=$user['nickName']?></h1>

<div class="profile">
<?php

foreach($user as $userKey => $userValue ){

    if($userKey == 'password'){
        continue;
    }
?>
    <div class="Box <?=$userKey?>" style="width: fit-content; margin-right: 2em;">
        <h4><?=$userKey?></h4>
        <span><?=$userValue?></span>
    </div>

<?php } ?>
</div>