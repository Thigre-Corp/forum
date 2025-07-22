<?php
    $users = $result["data"]['users']; 
?>

<h1>Liste des Users</h1>

<?php
foreach($users as $user ){ ?>
    <div class="Box">
        <p><a href="index.php?ctrl=security&action=profile&id=<?= $user->getId() ?>"><?= $user->getNickName() ?> - <?= $user->getRole() ?></a></p>
    </div>
<?php }