<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
session_start();

$vehicleDao= new VehicleDaoDB($pdo);

$vehicleId = filter_input(INPUT_GET, 'id');

if($vehicleId) {
  $vehicleDao->reactivate($vehicleId);
  
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Veículo reativado com sucesso!';
  header("Location: ../pages/listVehicles.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listVehicles.php");
}