<?php

//Memory game: notes

//Steps:
//- First form : Choose amount of pairs ($n in range = 3, 12)
//- hide previous form, show cards, all unrevealed (pick $n amount of cards at rand, then $n * 2)
//- game loop
//- record every turn passed (every time 2 cards are revealed)
//- every pair revealed, show button "next turn", hides pairs if not identical, keeps them if
//they are
//- prevent turning other cards when two cards are revealed and the pair not checked yet
//- revealed cards cannot be interacted with anymore
//- game end: record final score (less is better), win message with score, 
//button "start another game"

print_r($_POST);
br();
$g_o = $board->is_game_over() ? "yes" : "no";
echo "game over? ", $g_o;
br();
echo "strikes : ", $board->strikes;
br();
$waiting = $board->is_waiting ? "yes" : "no";
echo "game waiting? ", $waiting;
br();
echo "cards revealed : ", count($board->revealed_cards);
br();
print_r($board->total_cards);

// echo "total cards : ";
// print_r($board->total_cards);

?>

<form method="post" style="display: block;">

  <?php
  if (!$board->is_waiting) {
    generate_game_board($board->board);
  } else {
    generate_waiting_game($board->board);
    show_next_turn();
  }
  ?>

  <div style="display: inline-block;">
    <div>KILL BUTTON</div>
    <button type="submit" name="kill">KILL</button>
  </div>
</form>


<div class="float_left gap_small">

  <div class="card_main card_front gradient_normal card_shadow center">
    <div class="card_content center">
      <img class="img_size" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/143.png" alt="">
    </div>
    <div class="card_name">RONFLEX</div>
  </div>

  <div class="card_main card_front gradient_dragon center">
    <div class="card_content center">
      <img class="img_size" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/384.png" alt="">
    </div>
    <div class="card_name">RAYQUAZA</div>
  </div>

  <div class="card_back center">
    <div class="card_back_inside center">
      <img class="card_border card_back_img" src="../../../assets/images/pokeball.png" alt="">
    </div>
  </div>

</div>