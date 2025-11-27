<div>Bienvenue sur le scoreboard !</div>

<?php
// print_r($topten);

if (is_logged_in()) {
    //show current rank
}

if (empty($topten)) { ?>
    <div>Il n'y a pas encore de scores !</div>
<?php } else { ?>
    <table>
        <tr>
            <th>Utilisateur</th>
            <th>Score</th>
            <th>Difficulté</th>
            <th>Coups</th>
            <th>Temps</th>
            <th>Date</th>
        </tr>
        <?php foreach ($topten as $scoreinfo) { ?>
            <tr>
                <td><?= $scoreinfo["username"] ?></td>
                <td><?= $scoreinfo["score"] ?></td>
                <td><?= $scoreinfo["pairs"] ?></td>
                <td><?= $scoreinfo["strikes"] ?></td>
                <td><?= $scoreinfo["time"] ?></td>
                <td><?= $scoreinfo["cleandate"] ?></td>
            </tr>
        <?php } ?>
    </table>
<?php }
