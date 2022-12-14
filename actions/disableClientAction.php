<?php 
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/CheckinDao.php');

session_start();

$clientDao= new ClientDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);

$id = filter_input(INPUT_GET, 'id');
$client = $clientDao->findById($id);
$vehicleDao->findByClientIdQtd($id);
$clientVehicleQtd = $vehicleDao->findByClientIdQtd($id);

$clientCheckin = $checkinDao->findActiveByClientId($id);

if ($id) {

  //verifica se o cliente possui check-ins ativos
  if(sizeof($clientCheckin) === 0) {
    $clientDao->disable($id);
    $_SESSION['message-type'] = 'success';
    $_SESSION['icon-message'] = '#check-circle-fill';
    $_SESSION['insert_user_message'] = 'Cliente desativado com sucesso!';
    header("Location: ../pages/listClients.php");
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = 'Este cliente possui um check-in ativo! Realize o check-out e tente novamente.';
    header("Location: ../pages/listClients.php");
  }
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listClients.php");
}
