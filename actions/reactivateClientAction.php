<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');

session_start();

$clientDao= new ClientDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);

$id = filter_input(INPUT_GET, 'id');
$vehicleDao->findByClientIdQtd($id);
$clientVehicleQtd = $vehicleDao->findByClientIdQtd($id);

if($id){
  $clientDao->reactivate($id);
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Cliente reativado com sucesso!';
  header("Location: ../pages/listClients.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listClients.php");
}