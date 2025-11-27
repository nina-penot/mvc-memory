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

<div>Bonjour, <?= $_SESSION["user"]["username"] ?> !</div>

<div>Jeux précédents : </div>


<div>Votre position dans le scoreboard : n#<?= $rank ?> !</div>
<div><?= rank_congratulations($rank) ?></div>