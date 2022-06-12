<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Layout Generator - TFM maps</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <svg viewBox="0 0 800 400">
      <rect x="0" y="0" width="800" height="400" fill="#6A7495"/>
<?php
$typeColors = array(
  "#324650","#89A7F5","#6D4E94","#D84801","#2E190C","#324650","#324650","#324650","#f3faf86b","#6d9fb85d","#324650","#E7F0F2","#324650","#324650","#00000000","#f3faf86b","#324650","#324650","#324650","#51A317"
);

$groundsNo = 8;
$typeExceptions = array(
  11, 12, 13, 14, 16, 17, 18
);
for ($i=0; $i < $groundsNo; $i++) { 
  $groundWidth = $grounds[$i]['width'] = random_int(20, 400);
  $groundHeight = $grounds[$i]['height'] = random_int(20, 200);

  $groundOriginX = $grounds[$i]['originX'] = random_int(0, (800 - $grounds[$i]['width']));
  $groundOriginY = $grounds[$i]['originY'] = random_int(0, (400 - $grounds[$i]['height']));
  
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
  <div class="s"></div>
</main>
</body>
</html>
<!--
0 Madeira
1 Gelo
2 Trampolim
3 Lava
4 Chocolate
5 Terra
6 Grama
7 Areia
8 Nuvem
9  Água
10 Pedra
11 Grama com Neve
12 Retângulo
13 Circulo
14 Invisível
15 Teia de Aranha
16 Madeira2
17 Grama Laranja
18 Grama Rosa
19 Ácido
-->
