<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/CheckinDao.php');
session_start();

$vehicleDao= new VehicleDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);


$vehicleId = filter_input(INPUT_GET, 'id');
$vehicleCheckin =  $checkinDao->findActiveByVehicleId($vehicleId);

if($vehicleId) {
  if(sizeof($vehicleCheckin) === 0) {
    $vehicleDao->disable($vehicleId);
    
    $_SESSION['message-type'] = 'success';
    $_SESSION['icon-message'] = '#check-circle-fill';
    $_SESSION['insert_user_message'] = 'Veículo desativado com sucesso!';
    header("Location: ../pages/listVehicles.php");
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = 'Não foi possível realizar está ação! Este veículo possui check-in ativo, realize o check-out e tente novamente!';
    header("Location: ../pages/listVehicles.php");
  }
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listVehicles.php");
}