<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/PriceDao.php');
require_once('../dao/MovementDao.php');

$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$checkoutDao = new CheckoutDaoDB($pdo);
$priceDao = new PriceDaoDB($pdo);
$movementDao = new movementDaoDB($pdo);


$vehicleId = filter_input(INPUT_GET, 'vehicle');
$vehicle = $vehicleDao->findById($vehicleId);
$clientId = $vehicle->getClientId();
$client = $clientDao->findById($clientId);
$ckinId = filter_input(INPUT_GET, 'ckin');
$sectionId = filter_input(INPUT_GET, 'section');
$page = filter_input(INPUT_GET, 'page');
$userId = $_SESSION['user_id'];
$status = 'Aguardando Saída';

$checkinDao->updateStatus($status, $ckinId);


$_SESSION['message-type'] = 'success';
$_SESSION['icon-message'] = '#check-circle-fill';
$_SESSION['insert_user_message'] = "Veículo movido para a seção de Saída";

if($page == 'dashboard') {
  header("Location: ../pages/dashboard.php");
} else if($page == 'checkin') {
  header("Location: ../pages/checkIn.php");

}
