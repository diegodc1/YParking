<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/CheckoutDao.php');

$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$checkoutDao = new CheckoutDaoDB($pdo);

$vehicleId = filter_input(INPUT_GET, 'vehicle');
$vehicle = $vehicleDao->findById($vehicleId);
$clientId = $vehicle->getClientId();
$ckinId = filter_input(INPUT_GET, 'ckin');
$sectionId = filter_input(INPUT_GET, 'section');
$userId = $_SESSION['user_id'];


$checkin = $checkinDao->findById($ckinId);

$ckinTime = $checkin->getTime();
$ckinDate = $checkin->getDate();


//Pega a data atual
date_default_timezone_set('America/Sao_Paulo');

$time = date('H:i:s');
$date = date("d/m/Y");
$status = "Finalizado"; 


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

$checkoutDao->add($newCheckout);


$updateCheckin = new Checkin;
$updateCheckin->setStatus($status);


$checkinDao->updateStatus($status, $ckinId);

$_SESSION['message-type'] = 'success';
$_SESSION['icon-message'] = '#check-circle-fill';
$_SESSION['insert_user_message'] = "Checkin do veículo realizado com sucesso!";
header("Location: ../pages/checkin.php");