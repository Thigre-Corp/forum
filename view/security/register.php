<h1>Page d'inscription</h1>

<h2>--register.php---</h2>
        <form action="index.php?ctrl=security&action=register" method="POST">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo"><br>

            <label for="email">Mail</label>
            <input type="email" name="email" id="email"><br>

            <label for="pass1">Mot de passe</label>
            <input type="password" name="pass1" id="pass1"><br>

            <label for="pass2">Confirmation mot de passe</label>
            <input type="password" name="pass2" id="pass2"><br>
            <input type="submit" value="S'enregister">
        </form>