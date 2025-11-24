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
