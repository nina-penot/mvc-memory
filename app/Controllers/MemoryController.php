<?php

namespace App\Controllers;

use App\Models\CardsModel;
use Core\BaseController;
use App\Helper\Helper;
use App\Models\Card;
use App\Models\Card_tester;
use App\Models\Game;

/**
 * Classe MemoryController
 * ----------------------
 * Controlle tout ce qui ce trouve dans le dossier "memory"
 */
class MemoryController extends BaseController
{
    public $post_needed = [
        "cardmaker",
        "index"
    ];

    /**
     * Page où se trouve le jeu memory
     */
    public function index()
    {
        $cardsmodel = new CardsModel();
        $cards = $cardsmodel->all();
        $types = $cardsmodel->clean_types_array();

        $card_objs = [];
        foreach ($cards as $card) {
            $card_objs[] = new Card($card["id"], $card["name"], $types[$card["type_id"]], $card["image"]);
        }

        //game start (open page)
        if (!isset($_SESSION["board"])) {
            //show start menu
            $_SESSION["game_state"] = "start";
            $board = "";
        } else {
            $board = $_SESSION["board"];
        }

        //game on (playing)
        if (isset($_POST["start_game"])) {
            $board_ = new Game($_POST["difficulty"], $card_objs);
            $_SESSION["board"] = serialize($board_);
            $_SESSION["game_state"] = "playing";
            $_SESSION["time"]["start"] = time();
        }

        if ($_SESSION["game_state"] == "playing") {

            if (isset($_POST["card"])) {
                $_SESSION["board"] = unserialize($_SESSION["board"]);
                $_SESSION["board"]->total_cards[$_POST["card"]]->card_turn();
                $_SESSION["board"]->total_cards[$_POST["card"]]->wait();

                $_SESSION["board"]->check_pair();

                if ($_SESSION["board"]->is_game_over()) {
                    $_SESSION["game_state"] = "over";
                    $_SESSION["time"]["end"] = time();
                }

                $_SESSION["board"] = serialize($_SESSION["board"]);
                redirect("/memory#anchor_" . $_POST["card"]);
            }

            if (isset($_POST["next_turn"])) {
                $_SESSION["board"] = unserialize($_SESSION["board"]);
                $_SESSION["board"]->next_turn();
                $_SESSION["board"] = serialize($_SESSION["board"]);
            }
        }

        if ($_SESSION["game_state"] == "over") {
            $_SESSION["board"] = unserialize($_SESSION["board"]);
            //save the score in the scoreboard
            //saves strikes, time and pair amount
            //also saves in user profile if logged in
            $_SESSION["board"] = serialize($_SESSION["board"]);
        }

        if (isset($_POST["kill"])) {
            if (isset($_SESSION["board"])) unset($_SESSION["board"]);
        }

        if (isset($_POST["play_again"])) {
            unset($_SESSION["board"]);
            unset($_SESSION["time"]);
            $_SESSION["game_state"] = "start";
        }

        $game_state = $_SESSION["game_state"];

        if (isset($_SESSION["board"])) {
            $board = unserialize($_SESSION["board"]);
        } else {
            $board = "";
        }

        if (isset($_SESSION["time"]["end"])) {
            $time = $_SESSION["time"]["end"] - $_SESSION["time"]["start"];
        } else {
            $time = 0;
        }

        $data = [
            'game_state' => $game_state,
            'title' => "Mes cartes",
            "cards" => $cards,
            "card_objs" => $card_objs,
            'board' => $board,
            'time' => $time
        ];

        $this->render('memory/index', $data);
    }

    /**
     * Montre les cartes qui existent
     */
    function card_show()
    {
        $cards = new CardsModel();
        $types_arr = $cards->get_all_types();

        $types = [];
        foreach ($types_arr as $type) {
            $types[$type["id"]] = $type["name"];
        }

        $my_cards = $cards->all();
        $row_amount = 6;
        $count = 1;
        $rows = [];
        for ($n = 0; isset($my_cards[$n]); $n += $row_amount) {
            for ($nn = $n; $nn < $n + $row_amount; $nn++) {
                if (isset($my_cards[$nn])) {
                    $rows[$count][] = $my_cards[$nn];
                }
            }
            $count++;
        }

        $data = [
            'title' => "Mes cartes",
            'types' => $types,
            "cards" => $cards->all(),
            'rows' => $rows,
        ];

        $this->render('memory/card_show', $data);
    }

    /**
     * Créateur de cartes. Accessible seulement à l'admin.
     */
    function cardmaker()
    {
        $cardmodel = new CardsModel();

        $errors = [];
        $success = "";

        if (isset($_POST["submit"])) {
            $name = all_uppercase($_POST["card_name"]);
            $type = $_POST["card_type"];
            $pkmn_num = $_POST["pkmn_id"];
            $img = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/" . $pkmn_num . ".png";
            if (is_string_allowed($name) and !empty($name) and in_array($pkmn_num, range(1, 1025)) and $type != "none") {
                $cardmodel->add_card($name, $type, $img);
                $success = "Carte créée avec succès! #" . $pkmn_num . "-" . all_uppercase($name) . ", type : " . $type;
            } elseif (!is_string_allowed($name or empty($name))) {
                $errors[] = "Le nom du pokémon est incorrecte. Veuillez remplir et n'utiliser que des lettres, 
                tirets ou espaces.";
            } elseif (!in_array($pkmn_num, range(1, 1025))) {
                $errors[] = "Le numéro ID doit être compris entre 1 et 1025.";
            } elseif ($type == "none") {
                $errors[] = "Vous devez choisir un type.";
            }
        }

        $data = [
            "types" => $cardmodel->get_all_types()
        ];

        if (!empty($errors)) {
            $data['errors'] = $errors;
        }
        if (!empty($success)) {
            $data['success'] = $success;
        }

        $this->render('memory/cardmaker', $data);
    }

    function scoreboard()
    {
        $this->render('memory/scoreboard');
    }
}
