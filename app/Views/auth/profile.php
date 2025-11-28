<!-- Says hello username -->
<!-- Form to change info -->
<!-- Shows past games (scores and stats) from this one user -->
<!-- Show rank position in whole scoreboard -->
<!-- Option to play more game -->

<?php

if (!is_logged_in()) {
    redirect("/");
}
?>

<div>Bonjour, <?= $username ?> !</div>

<div>Jeux précédents : </div>
<?php if (empty($scores)) { ?>
    <div>Il n'y a pas encore de scores !</div>
<?php } else { ?>
    <table>
        <tr>
            <th>Score</th>
            <th>Difficulté</th>
            <th>Coups</th>
            <th>Temps</th>
            <th>Date</th>
        </tr>
        <?php foreach ($scores as $scoreinfo) { ?>
            <tr>
                <td><?= $scoreinfo["score"] ?></td>
                <td><?= $scoreinfo["pairs"] ?></td>
                <td><?= $scoreinfo["strikes"] ?></td>
                <td><?= $scoreinfo["time"] ?></td>
                <td><?= $scoreinfo["cleandate"] ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<div>Mettre à jour vos informations : </div>
<form method="post">
    <div>Votre nom :</div>
    <input type="text" name="updt_username" value="<?= $username ?>">
    <div>Votre mot de passe :</div>
    <input name="updt_password" type="password">
    <button type="submit" name="update">Mettre à jour</button>
</form>

<div>Votre position dans le scoreboard : n#<?= $rank ?> !</div>
<div><?= rank_congratulations($rank) ?></div>