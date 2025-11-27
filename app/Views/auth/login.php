<?php

if (isset($errors)) {
    error_handle($errors);
}
echo "POSTS : ";
print_r($_POST);
br();
echo "SESSIONS : ";
print_r($_SESSION);
br();
print_r($errors);
?>

<form method="post">

    <div>CONNEXION</div>

    <div>Votre nom d'utilisateur : </div>
    <input name="username" type="text" required>
    <div>Mot de passe : </div>
    <input name="password" type="password" required>
    <button type="submit" name="login">SE CONNECTER</button>

</form>