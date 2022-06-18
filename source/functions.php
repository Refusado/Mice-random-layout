<?php
require_once('set.php');

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