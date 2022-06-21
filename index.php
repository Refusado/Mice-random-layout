<?php
session_start();
require_once('source.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./images/settings-icon.svg">
  <title>Layout Generator - TFM maps</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <svg class="map-container" viewBox="0 0 800 400">
    <?php
// GERA PISOS A PARTIR DA QUANTIDADE DEFINIDA E VERIFICA ONDE HÁ ESPAÇO LIVRE
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
    }
  }

  generateGroundType($i);

  $groundType = $typeColors[$grounds[$i]['type']];

  // IMPRIME O PISO NA TELA COM AS ESPECIFICAÇÕES
  echo "  <rect id='z-$i' width='$groundWidth' height='$groundHeight' x='$groundOriginX' y='$groundOriginY' fill='$groundType'/>
  ";
}
// VERIFICA SE O GRID FOI CONFIGURADO PARA APARECER E IMPRIME AS TAGS DO GRID SE VERDADEIRO
if ($showGrid) {
  echo "
  <svg class='grid'>";
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
}
// VERIFICA SE A BARRA DE INFORMAÇÕES FOI CONFIGURADA PARA APARECER E IMPRIME A TAG SE VERDADEIRO
if ($showInfoBar) {
  echo '<rect style="border-radius: 7px;" width="800" height="22" x="0" y="0" fill="#324650"></rect>
  ';
}
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
          // IMPRIME TODOS OS PISOS DISPONÍVEIS COMO INPUT CHECKBOX
          for ($i = 0; $i < count($allGroundTypes); $i++) {
            // VERIFICA O ESTADO DE CADA OPÇÃO DE PISO E IMPRIME A TAG CONFIGURADA DE CADA ESTADO
            if (verifyException($i) && verifyException($i) != verifyDisable($i)) {
              echo "<input type='checkbox' name='e-$i' id='e-$i' checked>
              <label class='ground-btn' for='e-$i'>{$allGroundTypes[$i]}</label>
              ";
            } else if (verifyDisable($i)) {
              echo "<input type='checkbox' name='e-$i' id='e-$i'>
              <label class='ground-btn disable' for='e-$i'>{$allGroundTypes[$i]}</label>
              ";
            } else {
              echo "<input type='checkbox' name='e-$i' id='e-$i'>
              <label class='ground-btn' for='e-$i'>{$allGroundTypes[$i]}</label>
              ";
            }
          }
          ?>
        </div>

        <div id="btns-on-settings">
          <div class='grounds-no-container'>
            <p style="text-align: center;">Pisos</p>
            <?php
            // IMPRIME A CONFIGURAÇÃO DE QUANTOS PISOS DEVERÃO SER GERADOS E ARMAZENA A RESPOSTA DO USUÁRIO
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
    <code class="display-xml"><?php require_once('generatexml.php'); ?></code>
  </div>
</main>
</body>
</html>