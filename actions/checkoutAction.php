<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/PriceDao.php');

$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$checkoutDao = new CheckoutDaoDB($pdo);
$priceDao = new PriceDaoDB($pdo);

$vehicleId = filter_input(INPUT_GET, 'vehicle');
$vehicle = $vehicleDao->findById($vehicleId);
$clientId = $vehicle->getClientId();
$client = $clientDao->findById($clientId);
$ckinId = filter_input(INPUT_GET, 'ckin');
$sectionId = filter_input(INPUT_GET, 'section');
$userId = $_SESSION['user_id'];
$prices = $priceDao->findAll();

$checkin = $checkinDao->findById($ckinId);

$ckinTime = $checkin->getTime();
$ckinDate = $checkin->getDate();



//Pega a data e horario atual
date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d-m-Y");
$status = "Finalizado"; 

$CkinDateTime = $ckinDate . ' ' . $ckinTime;
$CkoutDateTime = $date . ' ' . $time;

$checkInDateTime = new DateTime($CkinDateTime);
$checkOutDateTime = new DateTime($CkoutDateTime);

$interval = $checkOutDateTime->getTimestamp() - $checkInDateTime->getTimestamp(); 

if($vehicle->getModel() != 'Moto') {
  if($interval <= 900) {
    $value = $prices->getPrcCar15();
  } else if($interval > 900 && $interval <= 1800) {
    $value = $prices->getPrcCar30();   
  } else if($interval > 1800 && $interval <= 3600) {
    $value = $prices->getPrcCar1h();   
  } else if($interval > 3600 && $interval <= 7200) {
    $value = $prices->getPrcCar2h();   
  } else if($interval > 7200 && $interval <= 10800) {
    $value = $prices->getPrcCar3h();   
  } else if($interval > 10800 && $interval <= 21600) {
    $value = $prices->getPrcCar6h();   
  }  else if($interval > 21600) {
    $value = $prices->getPrcCarDay();   
  } 
} else {
  if($interval <= 900) {
    $value = $prices->getPrcMtbike15();
  } else if($interval > 900 && $interval <= 1800) {
    $value = $prices->getPrcMtbike30();   
  } else if($interval > 1800 && $interval <= 3600) {
    $value = $prices->getPrcMtbike1h();   
  } else if($interval > 3600 && $interval <= 7200) {
    $value = $prices->getPrcMtbike2h();   
  } else if($interval > 7200 && $interval <= 10800) {
    $value = $prices->getPrcMtbike3h();   
  } else if($interval > 10800 && $interval <= 21600) {
    $value = $prices->getPrcMtbike6h();   
  }  else if($interval > 21600) {
    $value = $prices->getPrcMtbikeDay();   
  } 
}


if($vehicleId) {
  $newCheckout = new Checkout;
  $newCheckout->setVehicleId($vehicleId);
  $newCheckout->setClientId($clientId);
  $newCheckout->setSectionId($sectionId);
  $newCheckout->setUserId($userId);
  $newCheckout->setTime($time);
  $newCheckout->setStatus($status);
  $newCheckout->setDate($date);
  $newCheckout->setCkinTime($ckinTime);
  $newCheckout->setCkinDate($ckinDate);
  $newCheckout->setCkinId($ckinId);
  $newCheckout->setTotalValue($value);

  $checkoutDao->add($newCheckout);

  $updateCheckin = new Checkin;
  $updateCheckin->setStatus($status);

  $checkinDao->updateStatus($status, $ckinId);
  $_SESSION['checkinId'] = $ckinId;
  $_SESSION['showModalCkout'] = 'true';
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Check-out do veículo realizado com sucesso!";
  header("Location: ../pages/checkin.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/checkin.php");
}


