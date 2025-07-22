<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $category ){ ?>
    <div class="Box">
        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
    </div>
<?php }



if (App\Session::isAdmin()){

?>

<div class="adder">
    <form action="index.php?ctrl=forum&action=addCategory" method="post">
        <label for="newCategory">Créer une nouvelle catégorie: </label>
            <input type='text' name="newCategory" value='ex: peinture'></input>
            <input type='submit' value='add'></input>
    </form>
</div>

<?php
}