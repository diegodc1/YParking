<?php 
session_start();
$color = filter_input(INPUT_POST, 'colorThemeInput');

$_SESSION['colorTheme'] = $color;

header('Location: ../pages/parking.php');

?>

<head>
  <title>Estacionamento</title>
</head>