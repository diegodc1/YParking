<?php 
require_once('../db/config.php');
require_once('../dao/PriceDao.php');
require_once('../dao/UsuarioDao.php');
session_start();

$priceDao = new PriceDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);

$password = filter_input(INPUT_POST, 'inputPassword');
$email =  $_SESSION['user_email'];

$car15Price = filter_input(INPUT_POST, 'car15Price');
$car30Price = filter_input(INPUT_POST, 'car30Price');
$car1hPrice = filter_input(INPUT_POST, 'car1hPrice');
$car2hPrice = filter_input(INPUT_POST, 'car2hPrice');
$car3hPrice = filter_input(INPUT_POST, 'car3hPrice');
$car6hPrice = filter_input(INPUT_POST, 'car6hPrice');
$carDayPrice = filter_input(INPUT_POST, 'carDayPrice');
$mtbike15Price = filter_input(INPUT_POST, 'mtbike15Price');
$mtbike30Price = filter_input(INPUT_POST, 'mtbike30Price');
$mtbike1hPrice = filter_input(INPUT_POST, 'mtbike1hPrice');
$mtbike2hPrice = filter_input(INPUT_POST, 'mtbike2hPrice');
$mtbike3hPrice = filter_input(INPUT_POST, 'mtbike3hPrice');
$mtbike6hPrice = filter_input(INPUT_POST, 'mtbike6hPrice');
$mtbikeDayPrice = filter_input(INPUT_POST, 'mtbikeDayPrice');

$updatePrices = new Price();

if($usuarioDao->findUserLogin($email, $password) != false) {
  $updatePrices->setPrcCar15($car15Price);
  $updatePrices->setPrcCar30($car30Price);
  $updatePrices->setPrcCar1h($car1hPrice);
  $updatePrices->setPrcCar2h($car2hPrice);
  $updatePrices->setPrcCar3h($car3hPrice);
  $updatePrices->setPrcCar6h($car6hPrice);
  $updatePrices->setPrcCarDay($carDayPrice);
  $updatePrices->setPrcMtbike15($mtbike15Price);
  $updatePrices->setPrcMtbike30($mtbike30Price);
  $updatePrices->setPrcMtbike1h($mtbike1hPrice);
  $updatePrices->setPrcMtbike2h($mtbike2hPrice);
  $updatePrices->setPrcMtbike3h($mtbike3hPrice);
  $updatePrices->setPrcMtbike6h($mtbike6hPrice);
  $updatePrices->setPrcMtbikeDay($mtbikeDayPrice);

  $priceDao->update($updatePrices);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Valores atualizados com sucesso!";
  header("Location: ../pages/parking.php");
  exit();
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Atualização de preços negada! Senha informada está incorreta!";
  header("Location: ../pages/parking.php");
  exit();
}