<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Layout Generator - TFM maps</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <svg viewBox="0 0 800 400">
<?php
session_start();

if (isset($_GET['grounds-number']) && $_GET['grounds-number'] != 0) {
  $groundsNo = $_GET['grounds-number'];
}
$_SESSION['lastGroundsNo'] = $groundsNo = $_GET['grounds-number'] ?? $_SESSION['lastGroundsNo'] ?? 5;

if (@$_GET['edited']) {
  $typeToShow = array();
  $typeExceptions = array();

  for ($i = 0; $i < 20; $i++) {
    array_push($typeToShow, $i);
    if (isset($_GET['e-' . $i])) {
      array_push($typeExceptions, $i);
    }
  }

  $_SESSION['lastExceptions'] = $typeExceptions;
  header('location: ./');

} else {
  $typeExceptions = $_SESSION['lastExceptions'] ??
  array(
    5, 7, 8, 11, 12, 13, 14, 15, 16, 17, 18,
  );
}

$typeColors = array(
  "#324650","#89A7F5","#6D4E94","#D84801","#2E190C","#324650","#324650","#324650","#f3faf86b","#6d9fb85d","#324650","#E7F0F2","#324650","#324650","#00000000","#f3faf86b","#324650","#324650","#324650","#51A317"
);

for ($i = 0; $i < $groundsNo; $i++) { 
  $groundWidth = $grounds[$i]['width'] = random_int(20, 400);
  $groundHeight = $grounds[$i]['height'] = random_int(20, 200);

  $groundOriginX = $grounds[$i]['originX'] = random_int(0, (800 - $grounds[$i]['width']));
  $groundEndX = $grounds[$i]['endX'] = $groundOriginX + $groundWidth;
  
  $groundOriginY = $grounds[$i]['originY'] = random_int(0, (400 - $grounds[$i]['height']));
  $groundEndY = $grounds[$i]['endY'] = $groundOriginY + $groundHeight;
  
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
            $groundWidth = $grounds[$i]['width'] = random_int(20, 400);
            $groundHeight = $grounds[$i]['height'] = random_int(20, 200);
            
            $groundOriginX = $grounds[$i]['originX'] = random_int(0, (800 - $grounds[$i]['width']));
            $groundEndX = $grounds[$i]['endX'] = $groundOriginX + $groundWidth;
            
            $groundOriginY = $grounds[$i]['originY'] = random_int(0, (400 - $grounds[$i]['height']));
            $groundEndY = $grounds[$i]['endY'] = $groundOriginY + $groundHeight;
            
            $ii = -1;
        }
      }
    };
  }

  $grounds[$i]['type'] = random_int(0, count($typeColors) - 1);
  if ($typeExceptions < $typeColors) {
    for ($ii = 0; $ii < count($typeExceptions); $ii++) { 
      if($grounds[$i]['type'] == $typeExceptions[$ii]) {
        $grounds[$i]['type'] = random_int(0, count($typeColors) - 1);
        $ii = -1;
      }
    };
    $groundColor = $typeColors[$grounds[$i]['type']];

    echo "
    <rect width='$groundWidth' height='$groundHeight' x='$groundOriginX' y='$groundOriginY' fill='$groundColor'/>
    ";
  } else {
    break;
  }
};
?>
    <rect x="0" y="0" width="100%" height="22px" fill="#00000015"/>
  </svg>
  <div class="s">
    <div class="btns-container">
      <a class="btn" id="generate" href="./">
        <img src="./images/refresh-icon.svg" alt="Generate new layout">
      </a>
      <label class="btn" id="show-settings-btn" for="show-settings">
        <img src="./images/settings-icon.svg" alt="Settings">
      </label>
    </div>
    
    <input type="checkbox" name="show-settings" id="show-settings">
    <form id="map-settings" action="" method="get">
      <input type="hidden" name="edited" value="true">
      <div class='types-container'>

      <?php
      $groundTypes = array(
        "Madeira","Gelo","Trampolim","Lava","Chocolate","Terra","Grama","Areia","Nuvem","Água","Pedra","Neve","Retângulo","Circulo","Invisível","Teia","Madeira II","Grama II","Grama III","Ácido"
      );

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
      for ($i = 0; $i < count($groundTypes); $i++) {
        if (verifyException($i)) {
          echo "
          <input type='checkbox' name='e-$i' id='e-$i' checked>
          <label class='ground-btn' for='e-$i'>{$groundTypes[$i]}</label>
          ";
        } else {
          echo "
          <input type='checkbox' name='e-$i' id='e-$i'>
          <label class='ground-btn' for='e-$i'>{$groundTypes[$i]}</label>
          ";
        }
      }
      ?>
      </div>

      <div id="btns-on-settings">
        <label class="btn" id="close-settings-btn" for="show-settings">
          <img src="./images/back-icon.svg" alt="Close settings">
        </label>

        <div class='grounds-no-container'>
          <p style="text-align: center;">Pisos</p>

          <?php echo "
          <input type='range' name='grounds-number' id='grounds-number' step='1' value='$groundsNo' min='1' max='10'>
          
          <div class='steps-line'>";
          for ($i = 1; $i <= 10; $i++) { 
            echo "
            <span>|</span>
            ";
            if ($i == 10){
              echo "</div>
              <div class='steps-number'>";
              for ($ii = 1; $ii <= 10; $ii++) { 
                echo "<span>$ii</span>";
                if ($ii == 10){
                  echo "</div>";
                }
              } 
            }
          }
          ?>

        </div>
        <input id="save-btn" type="submit" value="Salver configurações">
        <label class="btn" id="close-settings-btn" for="save-btn">
          <img src="./images/save-icon.svg" alt="Save settings">
        </label>
      </div>
    </form>
  </div>
</main>
</body>
</html>
