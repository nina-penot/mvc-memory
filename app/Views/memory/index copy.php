<?php
print_r($board);
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
    <div>Jeu de (insert pair here) en <?= $board->strikes ?> coups, en (insert time here)</div>
    <button type="submit" name="play_again">REJOUER</button>

  </form>

<?php } ?>

<?php
echo "SESSION BOARD TEST = ";
print_r($_SESSION["board"]);
br();
echo "------";
br();
foreach (get_defined_vars() as $k => $v) {
  print_r($k);
  echo " => ";
  print_r($v);
  br();
  echo "-------";
  br();
}
br();
print_r($board);
?>