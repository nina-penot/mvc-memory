<?php

/**
 * Redirection HTTP
 */
function redirect($path = '/')
{
    header("Location: $path");
    exit;
}

/**
 * Fonction scandir() mais qui ne donne pas les points.
 */
function scandir_plus($dir)
{
    return array_values(array_diff(scandir($dir), array('..', '.')));
}

/**
 * Fait un saut de ligne.
 */
function br()
{
    echo "<br>";
}

/**
 * Saut de ligne pour l'output, utilse pour les tests
 */
function slash_n()
{
    echo "\n";
}

/**
 * Removes a php extension from a string
 */
function remove_php_ext($str)
{
    return str_replace(".php", "", $str);
}

/**
 * Turn a controller into a dir name
 */
function controller_to_dirname($str)
{
    $name = str_replace("Controller", "", $str);
    return strtolower($name);
}

/**
 * Rend un string en majuscules
 */
function all_uppercase($str)
{
    $accents = array(
        'à' => 'À',
        'á' => 'Á',
        'â' => 'Â',
        'ã' => 'Ã',
        'ä' => 'Ä',
        'å' => 'Å',
        'æ' => 'Æ',
        'ç' => 'Ç',
        'è' => 'È',
        'é' => 'É',
        'ê' => 'Ê',
        'ë' => 'Ë',
        'ì' => 'Ì',
        'í' => 'Í',
        'î' => 'Î',
        'ï' => 'Ï',
        'ñ' => 'Ñ',
        'ò' => 'Ò',
        'ó' => 'Ó',
        'ô' => 'Ô',
        'õ' => 'Õ',
        'ö' => 'Ö',
        'œ' => 'Œ',
        'ù' => 'Ù',
        'ú' => 'Ú',
        'û' => 'Û',
        'ü' => 'Ü',
        'ý' => 'Ý',
        'ÿ' => 'Ÿ'
    );

    $upper_str = "";

    for ($n = 0; isset($str[$n]); $n++) {
        if (preg_match("/[a-z]/", $str[$n])) {
            $upper_str .= strtoupper($str[$n]);
        } else {
            //check if accented char
            $letter = isset($str[$n + 1]) ? $str[$n] . $str[$n + 1] : $str[$n];
            if (array_key_exists($letter, $accents)) {
                $upper_str .= $accents[$letter];
                $n += 1;
            } else {
                $upper_str .= $str[$n];
            }
        }
    }

    return $upper_str;
}

/**
 * Vérifie qu'un string n'a pas de caractères spéciaux
 */
function is_string_allowed($str)
{
    if (preg_match("/^[a-zA-Z\p{L}\s\-_ ]+$/u", $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Génère une carte qui est un bouton
 */
function make_clickable_card($card_key, $card_val)
{ ?>

    <button type="submit" name="card" id="card_<?= $card_key ?>" value="<?= $card_key ?>" class="button_killer">
        <div class="card_main card_front center gradient_<?= $card_val->type ?>">
            <div class="card_content center">
                <img class="img_size" src="<?= $card_val->img ?>" alt="<?= $card_val->name ?>">
            </div>
            <div class="card_name"><?= $card_val->name ?></div>
        </div>
    </button>

<?php }

/**
 * Génère le dos de la carte en bouton
 */
function make_clickable_card_back($card_key)
{ ?>

    <button class="button_killer" type="submit" name="card" id="card_<?= $card_key ?>" value="<?= $card_key ?>">
        <div class="card_back center">
            <div class="card_back_inside center">
                <img class="card_border card_back_img" src="../../../assets/images/pokeball.png" alt="">
            </div>
        </div>
    </button>

<?php }

/**
 * Génère une carte de dos qui n'est pas un bouton
 */
function make_ignored_card_back($card_key)
{ ?>

    <div id="card_<?= $card_key ?>" value="<?= $card_key ?>" class="card_back center">
        <div class="card_back_inside center">
            <img class="card_border card_back_img" src="../../../assets/images/pokeball.png" alt="">
        </div>
    </div>

<?php }

/**
 * Génère une carte qui n'est pas un bouton
 */
function make_ignored_card($card_key, $card_val)
{ ?>

    <div id="card_<?= $card_key ?>" class="card_main card_front center gradient_<?= $card_val->type ?>">
        <div class="card_content center">
            <img class="img_size" src="<?= $card_val->img ?>" alt="<?= $card_val->name ?>">
        </div>
        <div class="card_name"><?= $card_val->name ?></div>
    </div>

<?php }

function float_block_start()
{ ?>
    <div style="margin-bottom: 10px;" class="float_left gap_small">

    <?php }

function float_block_end()
{ ?>
    </div>
<?php }

function generate_game_board($board)
{
    foreach ($board as $row_key => $row_val) {
        float_block_start();

        foreach ($row_val as $card_key => $card_val) {
            if ($card_val->is_revealed == true) {
                if ($card_val->is_ignored == true or $card_val->is_waiting == true) {
                    make_ignored_card($card_key, $card_val);
                } elseif ($card_val->is_ignored == false or $card_val->is_waiting == false) {
                    make_clickable_card($card_key, $card_val);
                }
                // if ($card_val->is_ignored == false or $card_val->is_waiting == false) {
                //     make_clickable_card($card_key, $card_val);
                // } elseif ($card_val->is_ignored == true or $card_val->is_waiting == true) {
                //     make_ignored_card($card_key, $card_val);
                // }
            } else {
                make_clickable_card_back($card_key);
            }
        }

        float_block_end();
    }
}

function generate_waiting_game($board)
{
    foreach ($board as $row_key => $row_val) {
        float_block_start();

        foreach ($row_val as $card_key => $card_val) {
            if ($card_val->is_revealed == true) {
                make_ignored_card($card_key, $card_val);
            } else {
                make_ignored_card_back($card_key);
            }
        }

        float_block_end();
    }
}

function show_next_turn()
{ ?>

    <div>
        <button type="submit" name="next_turn">NEXT TURN</button>
    </div>

<?php }
