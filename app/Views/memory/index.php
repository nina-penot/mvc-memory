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

print_r($board->total_cards);

?>

<form method="post" style="display: block;">

  <?php foreach ($board->board as $row_key => $row_val) { ?>
    <div style="margin-bottom: 10px;" class="float_left gap_small">
      <?php foreach ($row_val as $card_key => $card_val) { ?>

        <?php if ($card_val->is_revealed != true) { ?>

          <button type="submit" name="card" id="card_<?= $card_key ?>" value="<?= $card_key ?>" class="card_main card_front center gradient_<?= $card_val->type ?>">
            <div class="card_content center">
              <img class="img_size" src="<?= $card_val->img ?>" alt="<?= $card_val->name ?>">
            </div>
            <div class="card_name"><?= $card_val->name ?></div>
          </button>

        <?php } else { ?>
          <button type="submit" name="card" id="card_<?= $card_key ?>" value="<?= $card_key ?>">
            <div class="card_back center">
              <div class="card_back_inside center">
                <img class="card_border" src="../../../assets/images/pokeball.png" alt="">
              </div>
            </div>
          </button>
        <?php } ?>

      <?php } ?>
    </div>
  <?php } ?>

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
      <img class="card_border" src="../../../assets/images/pokeball.png" alt="">
    </div>
  </div>

</div>