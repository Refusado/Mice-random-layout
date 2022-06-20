<?php
echo "&ltC&gt&ltP/&gt&ltZ&gt&ltS&gt";

for ($i = 0; $i < count($grounds); $i++) {
  $w = $grounds[$i]["width"];
  $h = $grounds[$i]["height"];
  $x = $grounds[$i]["originX"] + $w / 2;
  $y = $grounds[$i]["originY"] + $h / 2;
  $t = $grounds[$i]["type"];

  switch ($grounds[$i]['type']) {
    case 0; case 5; case 6; case 14; case 17; case 18:
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0.3,0.2,0,0,0,0\"/&gt"; break;
    case 1: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0,0.2,0,0,0,0\"/&gt"; break;
    case 2: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0,1.2,0,0,0,0\"/&gt"; break;
    case 3: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0,20,0,0,0,0\"/&gt"; break;
    case 4: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,20,0.2,0,0,0,0\"/&gt"; break;
    case 7: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0.1,0.2,0,0,0,0\"/&gt"; break;
    case 8: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0.3,0.2,0,0,0,0\" c=\"2\"/&gt"; break;
    case 9; case 15: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0,0,0,0,0,0\"/&gt"; break;
    case 10; case 19: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0.3,0,0,0,0,0\"/&gt"; break;
    case 11: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0.05,0.1,0,0,0,0\"/&gt"; break;
    case 12: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\" H=\"$h\" P=\"0,0,0.3,0.2,0,0,0,0\" o=\"324650\"/&gt"; break;
    case 13: 
      echo "&ltS T=\"$t\" X=\"$x\" Y=\"$y\" L=\"$w\"        P=\"0,0,0.3,0.2,0,0,0,0\" o=\"324650\"/&gt"; break;
  }
}
echo "&lt/S&gt&ltD/&gt&ltO/&gt&ltL/&gt&lt/Z&gt&lt/C&gt";