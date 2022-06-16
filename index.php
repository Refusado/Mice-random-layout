<?php session_start() ?>
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
function generateNewGround($id) {
  global $grounds;

  global $proportionMult;
  global $positionMult;

  global $groundWidth;
  global $groundHeight;
  
  global $groundOriginX;
  global $groundOriginY;

  global $groundEndX;
  global $groundEndY;

  global $maxGroundWidth;
  global $maxGroundHeight;

  $groundWidth = $grounds[$id]['width'] =  gMult(10, $maxGroundWidth, $proportionMult);
  $groundHeight = $grounds[$id]['height'] = gMult(10, $maxGroundHeight, $proportionMult);
  
  $groundOriginX = $grounds[$id]['originX'] = gMult(0, (800 - $grounds[$id]['width']), $positionMult);
  $groundOriginY = $grounds[$id]['originY'] = gMult(0, (400 - $grounds[$id]['height']), $positionMult);
  
  $groundEndX = $grounds[$id]['endX'] = $groundOriginX + $groundWidth;
  $groundEndY = $grounds[$id]['endY'] = $groundOriginY + $groundHeight;
}

function verifyException($var){
  global $typeExceptions;
  if (!is_null($typeExceptions)){
    foreach ($typeExceptions as $execption) {
      if ($var == $execption){
        return true;
      }
    }
  }
}
function verifyDisable($var){
  global $typeDisable;
  if (!is_null($typeDisable)){
    foreach ($typeDisable as $disable) {
      if ($var == $disable){
        return true;
      }
    }
  }
}
function gMult($min, $max, $m) {
  $n = random_int($min, $max);
  while (($n % $m) != 0) {
      $n = random_int($min, $max);
  }
  return $n;
}

$typeDisable = array(13, 14);

$typeColors = array(
  "#324650","#89A7F5","#6D4E94","#D84801","#2E190C","#324650","#324650","#324650","#f3faf86b","#6d9fb85d","#324650","#E7F0F2","#324650","#324650","#00000000","#f3faf86b","#324650","#324650","#324650","#51A317"
);

$proportionMult = $positionMult = 80;
// Múltiplos de 400 > 200, 100, 80, 50, 40, 25, 20, 16, 10, 8, 5, 4, 2, 1

$maxGroundWidth = 400;
$maxGroundHeight = 200;

if (isset($_POST['grounds-number']) && $_POST['grounds-number'] != 0) {
  $groundsNo = $_POST['grounds-number'];
}
$_SESSION['lastGroundsNo'] = $groundsNo = $_POST['grounds-number'] ?? $_SESSION['lastGroundsNo'] ?? 4;

if (@$_POST['edited']) {
  $typeToShow = array();
  $typeExceptions = array();

  for ($i = 0; $i < 20; $i++) {
    array_push($typeToShow, $i);
    if (isset($_POST['e-' . $i])) {
      array_push($typeExceptions, $i);
    }
  }

  $_SESSION['lastExceptions'] = $typeExceptions;
} else {
  $typeExceptions = $_SESSION['lastExceptions'] ??
  array(
    5, 7, 8, 11, 12, 13, 14, 15, 16, 17, 18,
  );
}

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
    for ($ii = 0; $ii < count($typeExceptions); $ii++) { 
      if ($grounds[$i]['type'] == $typeExceptions[$ii]) {
        $grounds[$i]['type'] = random_int(0, count($typeColors) - 1);
        $ii = -1;
      }

      for ($iii = 0; $iii < count($typeDisable); $iii++) { 
        if ($grounds[$i]['type'] == $typeDisable[$iii]) {
          $grounds[$i]['type'] = random_int(0, count($typeColors) - 1);
          $ii = -1;
        }
      }
    };
    $groundColor = $typeColors[$grounds[$i]['type']];

        echo "  <rect width='$groundWidth' height='$groundHeight' x='$groundOriginX' y='$groundOriginY' fill='$groundColor'/>
    ";
  } else {
    break;
  }
};
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
