<?php
namespace Model\Entities;
use App\Entity;
use App;

$user = $result["data"]['user']; 
    //$user['role']= (json_decode($user['role'])[0]);
?>

<h1>Profil Utilisateur de <?=$user?></h1>

<div class="profile box">
    <form action="index.php?ctrl=security&action=modUser&id=<?=$user->getId()?>" method="POST">
        <div class="Box pseudo">
            <label for="nickName">Pseudo :</label><br>
            <input style="width :90%;" type="text" name="nickName" id="nickName" value="<?=$user->getNickName()?>"></input>
        </div>
        <div class="Box email">
            <label for="email">Email :</label><br>
            <input style="width :90%;" type="text" name="email" id="email" value="<?=$user->getEmail()?>"></input>
        </div>

<?php
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
