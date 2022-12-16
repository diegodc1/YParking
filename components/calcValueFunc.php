<?php 
session_start();
// function calcValue($ckinDate, ) {
//   require_once('../dao/PriceDao.php');
//   $priceDao = new PriceDaoDB($pdo);
//   date_default_timezone_set('America/Sao_Paulo');

//   $dateNow = date("d/m/Y"); 
//   $timeNow = date('H:i:s');




// }

$entrada = new DateTime("2022-05-30 15:30:30");
$saida   = new DateTime("2022-05-30  15:30:60");

echo $saida->getTimestamp() - $entrada->getTimestamp() . " segundos. <br>"; 