<?php
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
session_start();

$idClient = filter_input(INPUT_GET, 'lastId');
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);

$client = $clientDao->findById($idClient);


$brand = filter_input(INPUT_POST, 'inputVehicleBrand');
$model = filter_input(INPUT_POST, 'inputVehicleModel');
$plate = filter_input(INPUT_POST, 'inputVehiclePlate');
$color = filter_input(INPUT_POST, 'inputVehicleColor');
$category = filter_input(INPUT_POST, 'inputVehicleCategory');
// $departureTime = filter_input(INPUT_POST, 'inputHourOut');

if($client->getStatus() != 'Desativado'){
  $newVehicle = new Vehicle();
  $newVehicle->setBrand($brand);
  $newVehicle->setModel($model);
  $newVehicle->setPlate($plate);
  $newVehicle->setColor($color);
  $newVehicle->setCategory($category);
  // $newVehicle->setDepartureTime($departureTime);
  $newVehicle->setClientId($idClient);

  $vehicleDao->add($newVehicle);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Veículo cadastrado com sucesso!";
  header("Location: ../pages/addClient.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "O cliente selecionado está com seu cadastro desativado!";
  header("Location: ../pages/addClient.php");
}





