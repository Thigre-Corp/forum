<?php
namespace Model\Entities;
use App\Entity;
use App;

$user = $result["data"]['user']; 
    //$user['role']= (json_decode($user['role'])[0]);
?>

<h1>Profil Utilisateur de <?=$user//['nickName']
?></h1>

<div class="profile box">
    <form action="index.php?ctrl=security&action=modUser&id=<?=$user->getId()?>" method="POST">
<?php

foreach($user as $userKey => $userValue ){

    if($userKey == 'password' || $userKey == 'id' || $userKey =='creationDate' || $userKey =='role'){
        continue;
    }

    
?>
    <div class="Box <?=$userKey?>">
        <label for="<?=$userKey?>"><?=$userKey?></label><br>
        <input style="width :90%;" type="text" name="<?=$userKey?>" id="<?=$userKey?>" value="<?=$userValue?>"></input>
    </div>
    <div class="Box <?=$userKey?>">
        <label for="<?=$userKey?>"><?=$userKey?></label><br>
        <input style="width :90%;" type="text" name="<?=$userKey?>" id="<?=$userKey?>" value="<?=$userValue?>"></input>
    </div>

<?php } 

if (App\Session::isAdmin()){ 

?>

    <div class="Box role">
        <label for="role">Changer le rôle:</label><br>
        <select style="width :90%;" type="text" name="role" id="role">
<?php
            foreach(User::USER_ROLE as $role){

                echo "<option value='".$role."'>".$role."</option>";
            }
?>
        </select>
    </div>

<?php
}

?>
        <label for="suppr">Supprimer le profil ?</label>
        <input type='checkbox' name="suppr" id="suppr"></input><br><br>
        <input type='submit' value='Appliquer les modifications'></input>
        <input type='hidden' name='cestSReffe' value='<?=$_SESSION["cestSReffe"]?>'>
    </form>
</div>
