<h1>Page de login</h1>

        <form action="index.php?ctrl=security&action=login" method="POST">
            <input type='hidden' name='cestSReffe' value='<?=$_SESSION["cestSReffe"]?>'>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo"><br>

            <label for="pass1">Mot de passe</label>
            <input type="password" name="pass1" id="pass1"><br>

            <input type="submit" value="S'enregister">
        </form>