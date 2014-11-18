<?php

$secondes = 2;  // les secondes  < 60

?>

<html>
<head>
<title>Demo compte a rebour</title>
<script type="text/javascript">
var temps = <?php echo $secondes;?>;
var timer =setInterval('CompteaRebour()',1000);
function CompteaRebour(){

  temps-- ;
  s = parseInt((temps%3600)%60) ;
  document.getElementById('decompte').innerHTML= (s<10 ? "0"+s : s) + ' s ';
}
</script>
</head>

<body onload="timer">

<span style="font-size: 36px;">Il vous reste comme temps</span>
<div id="minutes" style="font-size: 36px;"></div></span>

<body>
<html>