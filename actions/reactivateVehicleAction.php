<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
session_start();

$vehicleDao= new VehicleDaoDB($pdo);

$page = filter_input(INPUT_GET, 'page');
$vehicleId = filter_input(INPUT_GET, 'id');
$clientId = filter_input(INPUT_GET, 'clientId');

//Se a pagina de origem for a pagina de edit client.
if($clientId) {
  $_SESSION['clientIdReturn'] = $clientId;
}

if($vehicleId) {
  $vehicleDao->reactivate($vehicleId);
  
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Veículo reativado com sucesso!';
  header("Location: ../pages/$page.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/$page.php");
}