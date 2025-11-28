<?php

/**
 * Layout principal
 * -----------------
 * Ce fichier définit la structure HTML commune à toutes les pages.
 * Il inclut dynamiquement le contenu spécifique à chaque vue via la variable $content.
 */
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">

  <!-- Titre de la page (sécurisé avec htmlspecialchars, valeur par défaut si non défini) -->
  <title><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Mini MVC' ?></title>

  <!-- Bonne pratique : rendre le site responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/css/global.css">
</head>

<body>
  <!-- header -->
  <header class="float_left">
    <div class="funny_sphere_cont">
      <div class="funny_sphere">
        <!-- funny sphere -->
      </div>
    </div>

    <div class="title_block_cont">
      <div class="title_block">
        <div class="title">MEMORY</div>
        <div class="subtitle">Pokedex Edition</div>
      </div>
    </div>


  </header>
  <!-- Menu de navigation global -->
  <nav>
    <a class="link_killer" href="/">
      <button class="nav_elem">
        <div class="shadow"></div>
        <div class="edge"></div>
        <div class="front text"> Accueil </div>
      </button>
    </a>

    <a class="link_killer" href="/memory">
      <button class="nav_elem">
        <div class="shadow"></div>
        <div class="edge"></div>
        <div class="front text"> Memory </div>
      </button>
    </a>

    <a class="link_killer" href="/scoreboard">
      <button class="nav_elem">
        <div class="shadow"></div>
        <div class="edge"></div>
        <div class="front text"> Scoreboard </div>
      </button>
    </a>

    <?php if (is_admin()) { ?>

      <a class="link_killer" href="/cardmaker">
        <button class="nav_elem">
          <div class="shadow"></div>
          <div class="edge"></div>
          <div class="front text"> Cardmaker </div>
        </button>
      </a>

    <?php } ?>

    <a class="link_killer" href="/card_show">
      <button class="nav_elem">
        <div class="shadow"></div>
        <div class="edge"></div>
        <div class="front text"> Voir cartes </div>
      </button>
    </a>

    <a class="link_killer" href="/about">
      <button class="nav_elem">
        <div class="shadow"></div>
        <div class="edge"></div>
        <div class="front text"> About </div>
      </button>
    </a>

    <?php if (is_logged_in()) { ?>

      <a class="link_killer" href="/profile">
        <button class="nav_elem2">
          <div class="shadow"></div>
          <div class="edge"></div>
          <div class="front text"> Profil </div>
        </button>
      </a>

      <a class="link_killer" href="/logout">
        <button class="nav_elem2">
          <div class="shadow"></div>
          <div class="edge"></div>
          <div class="front text"> Déconnexion </div>
        </button>
      </a>

    <?php } else { ?>

      <a class="link_killer" href="/login">
        <button class="nav_elem2">
          <div class="shadow"></div>
          <div class="edge"></div>
          <div class="front text"> Connexion </div>
        </button>
      </a>

      <a class="link_killer" href="/register">
        <button class="nav_elem2">
          <div class="shadow"></div>
          <div class="edge"></div>
          <div class="front text"> Inscription </div>
        </button>
      </a>

    <?php } ?>
  </nav>

  <!-- Contenu principal injecté depuis BaseController -->
  <main>
    <?= $content ?>
  </main>
</body>

</html>