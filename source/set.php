<?php
$proportionMult = 50; // OPÇÕES = 200, 100, 80, 50, 40, 25, 20, 16, 10, 8, 5, 4, 2, 1
$maxGroundWidth = 200;
$maxGroundHeight = 200;
$firstGroundsNo = 8; // QUANDO NÃO CONFIGURADO PELO USUÁRIO
$firstTypeExceptions = array(5, 6, 7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18); // QUANDO NÃO CONFIGURADO PELO USUÁRIO
$typeDisable = array(13, 14);
$typeColors = array(
  "#324650","#89A7F5","#6D4E94","#D84801","#2E190C","#324650","#324650","#324650","#f3faf86b","#6d9fb85d","#324650","#E7F0F2","#324650","#324650","#00000000","#f3faf86b","#324650","#324650","#324650","#51A317"
);

// SESSÃO
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