<?php
if (isset($errors)) {
    echo "ERREUR : ";
    br();
    foreach ($errors as $e) {
        echo $e;
        br();
    }
}

if (isset($success)) {
    echo $success;
    br();
}
?>

<form method="post">
    <div>Nom du pokémon :</div>
    <input autocomplete="off" type="text" name="card_name" id="card_name">
    <div>Numéro id du pokémon :</div>
    <input autocomplete="off" type="number" name="pkmn_id" id="pkmn_id" min="1" max="1025" value="">
    <div>Type du pokémon :</div>
    <select autocomplete="off" name="card_type" id="card_type">
        <option value="none">...</option>
        <?php foreach ($types as $t) { ?>
            <option value="<?= $t["name"] ?>"><?= $t["name"] ?></option>
        <?php } ?>
    </select>
    <!-- <div>Lien vers l'image du pokemon :</div>
    <input type="text" name="card_img_link"> -->
    <button type="submit" name="submit">GO</button>
</form>

<div>

    <div>Preview :</div>

    <div id="background" class="card_main card_front center">
        <div class="card_content center">
            <img id="img" class="img_size" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Icon-round-Question_mark.svg/1024px-Icon-round-Question_mark.svg.png" alt="">
        </div>
        <div class="card_name" id="cname"></div>
    </div>


</div>

<script src="/assets/js/card_preview.js"></script>