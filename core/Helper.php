<?php

//----------------------------------------
//DIVERS
//----------------------------------------

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

function error_handle($errors)
{
    echo "ERREUR : ";
    br();
    if (gettype($errors) == "array") {
        foreach ($errors as $e) {
            echo $e;
            br();
        }
    } elseif (gettype($errors) == "string") {
        echo $errors;
        br();
    }
}

function success_handle($success)
{
    if (gettype($success) == "array") {
        foreach ($success as $e) {
            echo $e;
            br();
        }
    } elseif (gettype($success) == "string") {
        echo $success;
        br();
    }
}

/**
 * Vérifie si $_POST est set, peut aussi vérifier un $_POST en particulier
 */
function is_post_set($value = NULL)
{
    if ($value != NULL) {
        return isset($_POST[$value]);
    } else {
        return isset($_POST);
    }
}

/**
 * Donne la valeau d'un $_POST, plus facile à écrire
 */
function post($value)
{
    return $_POST[$value];
}

//----------------------------------------
//CARDMAKER
//----------------------------------------

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

//----------------------------------------
//MEMORY GAME
//----------------------------------------

/**
 * Créé un anchor pour la redirection
 */
function generate_anchor($val)
{ ?>
    <div class="anchor" id="anchor_<?= $val ?>"></div>
<?php }

/**
 * Génère une carte qui est un bouton
 */
function make_clickable_card($card_key, $card_val)
{ ?>

    <button type="submit" name="card" id="card_<?= $card_key ?>" value="<?= $card_key ?>" class="button_killer">
        <div class="card_main_active card_front center gradient_<?= $card_val->type ?>">
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
        <?php generate_anchor($card_key) ?>
        <div class="card_back_active center">
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
        <?php generate_anchor($card_key) ?>
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
        <?php generate_anchor($card_key) ?>
        <div class="card_content center">
            <img class="img_size" src="<?= $card_val->img ?>" alt="<?= $card_val->name ?>">
        </div>
        <div class="card_name"><?= $card_val->name ?></div>
    </div>

<?php }

function float_block_start()
{ ?>
    <div class="super_flex">

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
        <div>Shame, try again.</div>
        <button type="submit" name="next_turn">NEXT TURN</button>
    </div>

<?php }

function show_win_message()
{ ?>

    <div>Good job, keept it up!</div>

<?php }

//----------------------------------------
//SCORE
//----------------------------------------

function clean_time($time)
{
    $unit_minute = 60;
    $unit_hour = 60 * 60;

    $hour = (int) gmdate("H", $time);
    $minute = (int) gmdate("i", $time);
    $seconds = (int) gmdate("s", $time);

    $hour_f = $hour . " h";
    $min_f = $minute . " min";
    $sec_f = $seconds . " sec";

    if ($hour > 0) {
        $result = $hour_f . " " . $min_f . " " . $sec_f;
    }
    if ($hour == 0 and $minute > 0) {
        $result = $min_f . " " . $sec_f;
    }
    if ($hour == 0 and $minute == 0) {
        $result = $sec_f;
    }
    return $result;
}

function time_bonus_calc($time, $pairs)
{
    $bonus_table = [
        "great" => 100,
        "good" => 50,
        "ok" => 25,
        "bad" => 0
    ];
    //for time bonus calculate time per strike
    $time_great = $pairs;
    //+100
    $time_good = $pairs * 2;
    //+50
    $time_ok = $pairs * 4;
    //+25
    $time_bad = $pairs * 10;
    //0 if more than time_bad

    if ($time >= 0 and $time < $time_good) {
        $bonus = $bonus_table["great"];
    } elseif ($time >= $time_good and $time < $time_ok) {
        $bonus = $bonus_table["good"];
    } elseif ($time >= $time_ok and $time < $time_bad) {
        $bonus = $bonus_table["ok"];
    } elseif ($time >= $time_bad) {
        $bonus = $bonus_table["bad"];
    }

    return $bonus;
}

function show_difficulty_bonus($difficulty)
{
    $bonus_difficulty = 10;
    $bonus = $difficulty * $bonus_difficulty;
    return $bonus;
}

function show_strikes_malus($strikes, $pairs)
{
    $malus = $strikes - $pairs;
    return $malus;
}

function score_calc($pairs, $strikes, $time)
{
    $bonus_difficulty = 10;
    $malus = $strikes - $pairs;

    $time_bonus = time_bonus_calc($time, $pairs);

    $score = (($pairs * $bonus_difficulty) - $malus) + $time_bonus;
    $score < 0 ?? $score = 1;

    return $score;
}

function rank_congratulations($rank)
{
    if ($rank == 1) {
        return "Félicitations !! Vous êtes premier !!";
    }
    if ($rank < 1 and $rank >= 3) {
        return "Félicitations ! Vous êtes dans le top 3 !";
    }
    if ($rank > 3 and $rank <= 10) {
        return "Félicitations, vous apparaissez dans le scoreboard !";
    }
    if ($rank > 10) {
        return "Vous n'êtes pas encore dans le scoreboard.";
    }
}

//----------------------------------------
//USER MANAGEMENT
//----------------------------------------

function log_in($username, $is_admin)
{
    $_SESSION["user"] = $username;
    $_SESSION["user"]["is_admin"] = $is_admin;
}

function is_logged_in()
{
    return isset($_SESSION["user"]);
}

function is_admin()
{
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"]["is_admin"] == true) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function logout()
{
    unset($_SESSION["user"]);
    redirect("/");
}

/**
 * Vérifie qu'un username n'ait pas de caractères spéciaux
 */
function is_username_allowed($str)
{
    if (preg_match("/^[a-zA-Z0-9\p{L}\s\-_ ]+$/u", $str)) {
        return true;
    } else {
        return false;
    }
}
