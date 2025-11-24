<?php

namespace App\Models;

use Core\Database;

/**
 * Classe CardsModel
 * ---------------------
 * Gère l'accès aux données pour l'entité "Card".
 * Elle encapsule les requêtes SQL liées aux cartes et retourne des données
 * prêtes à être utilisées par les contrôleurs.
 */
class CardsModel
{
    /**
     * Récupère toutes les cartes depuis la base
     *
     * @return array Liste des cartes sous forme de tableau associatif
     *               Chaque entrée contient : ['id' => ..., 'title' => ..., 'body' => ...]
     */
    public function all()
    {
        // Exécute une requête SQL directe pour récupérer toutes les cartes
        $stmt = Database::getPdo()->query(
            'SELECT * FROM cards ORDER BY id ASC'
        );

        // Retourne tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll();
    }

    /**
     * Récupère une carte spécifique par son identifiant
     *
     * @param int $id Identifiant unique de la carte
     * @return array|null Retourne la carte trouvé ou null si aucun résultat
     */
    public function find(int $id)
    {
        // Prépare une requête SQL sécurisée (évite les injections SQL via PDO)
        $stmt = Database::getPdo()->prepare(
            'SELECT * FROM cards WHERE id = :id'
        );

        // Exécution avec liaison de paramètre
        $stmt->execute(['id' => $id]);

        // Récupère une seule ligne
        $row = $stmt->fetch();

        // Retourne la carte si trouvé, sinon null
        return $row ?: null;
    }

    /**
     * Récupère tous les types dans la table cards_types
     */
    function get_all_types()
    {
        $stmt = Database::getPdo()->query(
            'SELECT * FROM cards_types'
        );

        return $stmt->fetchAll();
    }

    /**
     * Retourne un array types propre : id => type
     */
    function clean_types_array()
    {
        $types_arr = $this->get_all_types();
        $types = [];
        foreach ($types_arr as $type) {
            $types[$type["id"]] = $type["name"];
        }

        return $types;
    }

    function add_card($name, $type, $img)
    {
        //get the type's id
        $typeidquery = Database::getPdo()->prepare(
            'SELECT cards_types.id FROM cards_types WHERE cards_types.name = ?'
        );

        $typeidquery->execute([$type]);
        $type_id = $typeidquery->fetch();
        $type_id = $type_id["id"];

        //insert
        $stmt = Database::getPdo()->prepare(
            'INSERT INTO cards (cards.name, cards.type_id, cards.image)
            VALUES (?, ?, ?)'
        );

        $stmt->execute([$name, $type_id, $img]);
    }
}

/**
 * Classe Card
 * --
 * Construit une carte
 */
class Card
{
    public $id, $img, $type, $name, $is_revealed = false, $is_ignored = false;

    function __construct($id, $name, $type, $img_link)
    {
        $this->name = $name;
        $this->type = $type;
        $this->img = $img_link;
        $this->id = $id;
    }

    /**
     * Retourne une carte
     */
    function card_turn()
    {
        if ($this->is_revealed == false) {
            $this->is_revealed = true;
        } else {
            $this->is_revealed = false;
        }
    }
}

/**
 * A smaller variant for the Card class for testing purposes
 */
class Card_tester
{
    public $name, $id, $img, $is_revealed = false, $is_ignored = false;

    public function __construct($name, $id, $img)
    {
        $this->name = $name;
        $this->id = $id;
        $this->img = $img;
    }

    /**
     * Retourne une carte
     */
    function card_turn()
    {
        if ($this->is_revealed == false) {
            $this->is_revealed = true;
        } else {
            $this->is_revealed = false;
        }
    }
}

class Game
{
    public $pair_amount, $cards, $total_cards, $revealed_cards, $elem_per_row,
        $board, $strikes = 0;

    function __construct($pair_amount, $cards)
    {
        $this->pair_amount = $pair_amount;
        $this->cards = $cards;

        $random_picks = [];
        //pick (pair number) amount of numbers between 0, count(cards-1)
        $numbers = [];
        for ($n = 0; $n < $pair_amount; $n++) {
            $pick = mt_rand(0, count($this->cards) - 1);
            while (in_array($pick, $numbers)) {
                $pick = mt_rand(0, count($this->cards) - 1);
            }
            $numbers[] = $pick;
        }
        foreach ($this->cards as $k => $v) {
            if (in_array($k, $numbers)) {
                $random_picks[] = $v;
            }
        }

        for ($n = 1; $n <= 2; $n++) {
            foreach ($random_picks as $c) {
                $this->total_cards[] = clone $c;
            }
        }

        $this->build_rows();
        shuffle($this->total_cards);
        $this->build_board();
    }

    function build_rows()
    {
        //row can have 3, 4 or 5
        if ((count($this->total_cards) % 5) == 0) {
            //row has 5 elements
            $row = 5;
        } elseif ((count($this->total_cards) % 4) == 0) {
            //row has 4
            if (!isset($row)) $row = 4;
        } elseif ((count($this->total_cards) % 3) == 0) {
            //rows has 3
            if (!isset($row)) $row = 3;
        }

        if (!isset($row)) $row = 5;

        $this->elem_per_row = $row;
    }

    function build_board()
    {
        $count = 0;
        for ($n = 0; isset($this->total_cards[$n]); $n += $this->elem_per_row) {
            for ($nn = $n; $nn < $n + $this->elem_per_row; $nn++) {
                if (isset($this->total_cards[$nn])) {
                    $board[$count][$nn] = $this->total_cards[$nn];
                }
            }
            $count++;
        }

        $this->board = $board;
    }

    function get_revealed_cards()
    {
        foreach ($this->total_cards as $card) {
            if ($card->is_ignored == false and $card->is_revealed) {
                $this->revealed_cards[] = $card;
            }
        }
    }

    function clear_revealed()
    {
        $this->revealed_cards = [];
    }

    /**
     * Vérifie si il y a une paire révélée, si gagne ou pas
     */
    function check_pair()
    {
        $this->get_revealed_cards();
        if (!empty($this->revealed_cards) and count($this->revealed_cards) == 2) {
            if ($this->revealed_cards[0] == $this->revealed_cards[1]) {
                //pair get
                $this->revealed_cards[0]->is_ignored = true;
                $this->revealed_cards[1]->is_ignored = true;
                $this->clear_revealed();
            } else {
                //unreveal cards
                foreach ($this->total_cards as $card) {
                    if ($card->is_revealed == true and $card->is_ignored == false) {
                        $card->card_turn();
                    }
                }
                //clear revealed list
                $this->clear_revealed();
            }
        }
    }

    function is_game_over()
    {
        //if all cards in total revealed, game is over
    }
}
