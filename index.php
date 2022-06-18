<?php
session_start();
require_once('source/functions.php');
require_once('source/set.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/x-icon" href="./images/settings-icon.svg">
  <title>Layout Generator - TFM maps</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <svg viewBox="0 0 800 400">
    <?php



for ($i = 0; $i < $groundsNo; $i++) { 
  generateNewGround($i);
  if ($i > 0) {
    for ($ii = 0; $ii < $i; $ii++) {
      if (
        $grounds[$i]['originX'] > $grounds[$ii]['originX'] &&
        $grounds[$i]['originX'] < $grounds[$ii]['endX'] ||
        $grounds[$i]['endX'] > $grounds[$ii]['originX'] &&
        $grounds[$i]['originX'] < $grounds[$ii]['endX']
        ) {
        if (
          $grounds[$i]['originY'] > $grounds[$ii]['originY'] &&
          $grounds[$i]['originY'] < $grounds[$ii]['endY'] ||
          $grounds[$i]['endY'] > $grounds[$ii]['originY'] &&
          $grounds[$i]['originY'] < $grounds[$ii]['endY']
          ) {
            generateNewGround($i);
            $ii = -1;
        }
      }
    };
  }

  $grounds[$i]['type'] = random_int(0, count($typeColors) - 1);
  if (count($typeExceptions) < count($typeColors)) {
    generateGroundType($i);

    
    $groundColor = $typeColors[$grounds[$i]['type']];

    echo "  <rect width='$groundWidth' height='$groundHeight' x='$groundOriginX' y='$groundOriginY' fill='$groundColor'/>
    ";
  } else {
    break;
  }
};

echo "
<svg class='grid' stroke='#d21a1a9f' stroke-width='.5'>";
for ($i = 1; $i < 800 / $proportionMult; $i++) {
  $p = $proportionMult * $i;
  echo "<line x1='$p' x2='$p' y1='0' y2='400'/>";
}
for ($i = 1; $i < 400 / $proportionMult; $i++) {
  $p = $proportionMult * $i;
  echo "<line x1='0' x2='800' y1='$p' y2='$p'/>";
}
echo "
</svg>";
?>
</svg>
  <div class="s">
    <form action="" method="post">
      <div class="btns-container">
        <input id="save-btn" type="submit" value="Salver configurações">
        <label class="btn" id="close-settings-btn" for="save-btn">
          <img src="./images/refresh-icon.svg" alt="Generate new layout">
        </label>
        <label class="btn" id="show-settings-btn" for="show-settings">
          <img src="./images/settings-icon.svg" alt="Settings">
        </label>
      </div>
      <input type="checkbox" name="show-settings" id="show-settings">
      <div id="map-settings">
        <input type="hidden" name="edited" value="true">
        <div class='types-container'>
          <?php

          $groundTypes = array(
            "Madeira","Gelo","Trampolim","Lava","Chocolate","Terra","Grama","Areia","Nuvem","Água","Pedra","Neve","Retângulo","Circulo","Invisível","Teia","Madeira II","Grama II","Grama III","Ácido"
          );

          for ($i = 0; $i < count($groundTypes); $i++) {
            if (verifyException($i) && verifyException($i) != verifyDisable($i)) {
              echo "<input type='checkbox' name='e-$i' id='e-$i' checked>
              <label class='ground-btn' for='e-$i'>{$groundTypes[$i]}</label>
              ";
            } else if (verifyDisable($i)) {
              echo "<input type='checkbox' name='e-$i' id='e-$i'>
              <label class='ground-btn disable' for='e-$i'>{$groundTypes[$i]}</label>
              ";
            } else {
              echo "<input type='checkbox' name='e-$i' id='e-$i'>
              <label class='ground-btn' for='e-$i'>{$groundTypes[$i]}</label>
              ";
            }
          }
          ?>
        </div>

        <div id="btns-on-settings">
          <div class='grounds-no-container'>
            <p style="text-align: center;">Pisos</p>
            <?php
            echo "
            <input type='range' name='grounds-number' id='grounds-number' step='1' value='$groundsNo' min='1' max='10'>
            <div class='steps-line'>";
            for ($i = 1; $i <= 10; $i++) { 
              echo "<span>|</span>
              ";
              if ($i == 10){
                echo "</div>
                <div class='steps-number'>
                ";
                for ($ii = 1; $ii <= 10; $ii++) { 
                  echo "<span>$ii</span>
                  ";
                  if ($ii == 10){
                    echo "</div>";
                  }
                } 
              }
            }
            ?>

          </div>
        </div>
      </div>
    </form>
  </div>
</main>
</body>
</html>