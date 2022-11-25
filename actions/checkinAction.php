<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);

$vehicleId = filter_input(INPUT_GET, 'vehicle');
$vehicle = $vehicleDao->findById($vehicleId);

$clientId = $vehicle->getClientId();
$sectionId = filter_input(INPUT_GET, 'section');
$userId = $_SESSION['user_id'];

date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');

$newCheckIn = new Checkin;
$newCheckIn->setVehicleId($vehicleId);
$newCheckIn->setClientId($clientId);
$newCheckIn->setSectionId($sectionId);
$newCheckIn->setUserId($userId);
$newCheckIn->setTime($time);

$checkinDao->add($newCheckIn);
$checkinDao->addDaily($newCheckIn);

$_SESSION['message-type'] = 'success';
$_SESSION['icon-message'] = '#check-circle-fill';
$_SESSION['insert_user_message'] = "Checkin do veículo realizado com sucesso!";
header("Location: ../pages/checkin.php");

