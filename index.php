<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerador de layouts</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <svg viewBox="0 0 800 400">
      <rect x="0" y="0" width="800px" height="400" fill="#6A7495"/>
<?php
$groundTypes = array(
  "#324650",
  // "#757F96",
  "#89A7F5",
  "#D84801",
  "#6D4E94",
  "#2E190C",
  "#648ea360",
  // "#9BAABC"
);
for ($i=0; $i < 5; $i++) { 
  $ground['L'] = random_int(20, 400);
  $ground['X'] = random_int(0, (800 - $ground['L']));

  $ground['H'] = random_int(20, 200);
  $ground['Y'] = random_int(0, (400 - $ground['H']));
  
  $ground['C'] = $groundTypes[random_int(0, count($groundTypes) - 1)];

  echo "
  <rect x='{$ground['X']}' y='{$ground['Y']}' width='{$ground['L']}' height='{$ground['H']}' fill='{$ground['C']}'/>
  ";
};
?>
    <rect x="0" y="0" width="100%" height="22px" fill="#00000015"/>
  </svg>
  <div class="s">
?>
  </div>
</main>
</body>
</html>