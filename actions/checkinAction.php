<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CheckinDao.php');

$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);

//Busca o veículo no BD
$vehicleId = filter_input(INPUT_GET, 'vehicle');
$vehicle = $vehicleDao->findById($vehicleId);

//Pega os id's do cliente, da seção e do user.
$clientId = $vehicle->getClientId();
$sectionId = filter_input(INPUT_GET, 'section');
$userId = $_SESSION['user_id'];

//Pega a data atual
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y/m/d");

//Procura no BD se já existe um checkin com o id do veículo
$checkinsVehicle = $checkinDao->findAllDailyVehicleId($date, $vehicleId);

$time = date('H:i:s');
$date = date("d/m/Y");
$status = "Ativo"; 

if($checkinsVehicle === false) {
  $newCheckIn = new Checkin;
  $newCheckIn->setVehicleId($vehicleId);
  $newCheckIn->setClientId($clientId);
  $newCheckIn->setSectionId($sectionId);
  $newCheckIn->setUserId($userId);
  $newCheckIn->setTime($time);
  $newCheckIn->setStatus($status);
  $newCheckIn->setDate($date);

  $checkinDao->add($newCheckIn);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Checkin do veículo realizado com sucesso!";
  header("Location: ../pages/checkin.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Este veículo já está com um check-in ativo!";
  header("Location: ../pages/checkin.php");
}



