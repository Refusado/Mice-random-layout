<?php
$proportionMult = 50; // OPÇÕES = 200, 100, 80, 50, 40, 25, 20, 16, 10, 8, 5, 4, 2, 1
$maxGroundWidth = 200;
$maxGroundHeight = 200;
$showGrid = true;
$showInfoBar = true;
$firstGroundsNo = 8; // QUANDO NÃO CONFIGURADO PELO USUÁRIO
$firstTypeExceptions = array(5, 6, 7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18); // QUANDO NÃO CONFIGURADO PELO USUÁRIO
$typeDisable = array(13, 14);
$typeColors = array(
  "#324650","#89A7F5","#6D4E94","#D84801","#2E190C","#324650","#324650","#324650","#f3faf86b","#6d9fb85d","#324650","#E7F0F2","#324650","#324650","#00000000","#f3faf86b","#324650","#324650","#324650","#51A317"
);
$allGroundTypes = array(
  "Madeira","Gelo","Trampolim","Lava","Chocolate","Terra","Grama","Areia","Nuvem","Água","Pedra","Neve","Retângulo","Circulo","Invisível","Teia","Madeira II","Grama II","Grama III","Ácido"
);

// ESSAS VARIÁVEIS DE SESSÃO IRÃO MOSTRAR O ÚLTIMO VALOR CONFIGURADO PELO USUÁRIO COMO VALOR PADRÃO DOS INPUTS
$_SESSION['lastGroundsNo'] = $groundsNo = $_POST['grounds-number'] ?? $_SESSION['lastGroundsNo'] ?? $firstGroundsNo;

if (@$_POST['edited']) {
  $typeExceptions = array();

  for ($i = 0; $i < 20; $i++) {
    if (isset($_POST['e-' . $i])) {
      array_push($typeExceptions, $i);
    }
  }

  $_SESSION['lastExceptions'] = $typeExceptions;
} else {
  $typeExceptions = $_SESSION['lastExceptions'] ?? $firstTypeExceptions;
}

if (count($typeExceptions) >= count($typeColors) - count($typeDisable)) {
  $typeExceptions = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19);
}


// TODAS AS FUNÇÕES
function generateNewGround($id) {
  global $grounds;

  global $proportionMult;

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
  
  $groundOriginX = $grounds[$id]['originX'] = gMult(0, (800 - $grounds[$id]['width']), $proportionMult);
  $groundOriginY = $grounds[$id]['originY'] = gMult(0, (400 - $grounds[$id]['height']), $proportionMult);
  
  $groundEndX = $grounds[$id]['endX'] = $groundOriginX + $groundWidth;
  $groundEndY = $grounds[$id]['endY'] = $groundOriginY + $groundHeight;
}

function generateGroundType($id) {
  global $typeExceptions;
  global $typeColors;
  global $typeDisable;
  global $grounds;
  
  $grounds[$id]['type'] = random_int(0, count($typeColors) - 1);

  for ($ii = 0; $ii < count($typeExceptions); $ii++) { 
    if ($grounds[$id]['type'] == $typeExceptions[$ii]) {
      $grounds[$id]['type'] = random_int(0, count($typeColors) - 1);
      $ii = -1;
    }
    
    for ($iii = 0; $iii < count($typeDisable); $iii++) { 
      if ($grounds[$id]['type'] == $typeDisable[$iii]) {
        $grounds[$id]['type'] = random_int(0, count($typeColors) - 1);
        $ii = -1;
      }
    }
  };
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
function isValid($value) {
  if (isset($value) && $value != 0 && !is_null($value)) {
    return true;
  }
}

?>