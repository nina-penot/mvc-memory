<?php
if (isset($errors)) {
    error_handle($errors);
}

?>

<form method="post">

    <div>INSCRIPTION</div>

    <div>Votre nom d'utilisateur : (ATTENTION : ce nom sera visible de tous !)</div>
    <input name="username" type="text" required>
    <div>Mot de passe : </div>
    <input name="password" type="password" required>
    <div>Confirmation de mot de passe : </div>
    <input name="verify_pass" type="password" required>
    <button type="submit" name="register">S'INSCRIRE</button>

</form>