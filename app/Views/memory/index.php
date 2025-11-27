<?php
// print_r($_SESSION);
?>

<!-- Block démarrage du jeu -->
<?php if ($game_state == "start") { ?>

  <form method="post">
    <div>Sélectionnez une difficulté.</div>
    <select name="difficulty">
      <?php for ($n = 3; $n < 18; $n++) {
        if ($n == 3) {
          //easy
      ?>
          <optgroup label="Facile">
          <?php
        }
        if ($n == 6) {
          //medium
          ?>
          </optgroup>
          <optgroup label="Moyen">
          <?php
        }
        if ($n == 10) {
          //hard
          ?>
          </optgroup>
          <optgroup label="Difficile">
          <?php
        }
        if ($n == 14) {
          //very hard
          ?>
          </optgroup>
          <optgroup label="EXTREME">
          <?php
        }
          ?>
          <option value="<?= $n ?>"><?= $n ?> paires (ou <?= $n * 2 ?> cartes)</option>
        <?php
      }
        ?>
    </select>

    <!-- Add if not login, input name -->
    <?php
    if (!is_logged_in()) { ?>

      <div>Vous n'êtes pas connecté, entrez un nom pour apparaître sur le scoreboard.</div>
      <input type="text" name="temp_user">

    <?php }
    ?>

    <button type="submit" name="start_game">START</button>
  </form>

<?php } ?>

<!-- Block jeu -->
<?php if ($game_state == "playing") { ?>

  <form method="post" class="game_board float_left">

    <div class="game_board_cards">

      <?php
      if (!$board->is_waiting) {
        generate_game_board($board->board);
      } else {
        generate_waiting_game($board->board);
      }
      ?>

    </div>


    <div class="game_interface">

      <div class="interface_follow">
        <div>Coups : <?= $board->strikes ?></div>

        <div style="display: inline-block;">
          <div>Restart :</div>
          <button type="submit" name="kill">RESTART</button>
        </div>

        <?php
        if ($board->is_waiting) {
          show_next_turn();
        }
        if ($board->winning) {
          show_win_message();
        }
        ?>
      </div>
    </div>

  </form>

<?php } ?>

<!-- Block fin de jeu -->
<?php if ($game_state == "over") { ?>

  <form method="post">

    <div>Vous avez fini !</div>
    <div>Votre score :</div>
    <div>Jeu de <?= $board->pair_amount ?> paires en <?= $board->strikes ?> coups, en <?= clean_time($time) ?> !</.div>
      <div>Score :</div>
      <div>BONUS DIFFICULTE : <?= $board->pair_amount ?> x 10 = <?= show_difficulty_bonus($board->pair_amount) ?></div>
      <div>MALUS COUPS : - <?= show_strikes_malus($board->strikes, $board->pair_amount) ?></div>
      <div>BONUS TEMPS : + <?= time_bonus_calc($time, $board->pair_amount) ?></div>
      <div>SCORE FINAL : <?= score_calc($board->pair_amount, $board->strikes, $time) ?> !</div>
      <button type="submit" name="play_again">REJOUER</button>

  </form>

<?php } ?>

<?php
// echo "SESSION BOARD TEST = ";
// print_r($_SESSION["board"]);
// br();
// echo "------";
// br();
// foreach (get_defined_vars() as $k => $v) {
//   print_r($k);
//   echo " => ";
//   print_r($v);
//   br();
//   echo "-------";
//   br();
// }
// br();
// print_r($board);
?>