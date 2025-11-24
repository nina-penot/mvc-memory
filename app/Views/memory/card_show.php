<?php

?>

<h1>Cartes Disponibles :</h1>

<?php if (!empty($cards)) { ?>
    <?php foreach ($rows as $row) { ?>
        <div class="float_left gap_small">
            <?php foreach ($row as $card) { ?>

                <div class="card_main card_front gradient_<?= $types[$card["type_id"]] ?> center">
                    <div class="card_content center">
                        <img class="img_size" src="<?= $card["image"] ?>" alt="<?= $card["name"] ?>">
                    </div>
                    <div class="card_name"><?= $card["name"] ?></div>
                </div>

            <?php } ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <div>Il n'y a aucune cartes disponible.</div>
<?php } ?>