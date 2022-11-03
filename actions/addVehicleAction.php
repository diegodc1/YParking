<?php
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
session_start();

if(!empty($_POST['selectedClients'])) {
  $idClient = null;
  $idClient = $_POST['selectedClients'];

  echo count($idClient);

  if(count($idClient) < 2) {
    $vehicleDao = new VehicleDaoDB($pdo);
    
    $brand = filter_input(INPUT_POST, 'inputVehicleBrand');
    $model = filter_input(INPUT_POST, 'inputVehicleModel');
    $plate = filter_input(INPUT_POST, 'inputVehiclePlate');
    $color = filter_input(INPUT_POST, 'inputVehicleColor');
    $category = filter_input(INPUT_POST, 'inputVehicleCategory');
    $departureTime = filter_input(INPUT_POST, 'inputHourOut');
    $clientId = $idClient[0];

    $newVehicle = new Vehicle();
    $newVehicle->setBrand($brand);
    $newVehicle->setModel($model);
    $newVehicle->setPlate($plate);
    $newVehicle->setColor($color);
    $newVehicle->setCategory($category);
    $newVehicle->setDepartureTime($departureTime);
    $newVehicle->setClientId($clientId);

    $vehicleDao->add($newVehicle);
    $_SESSION['message-type'] = 'success';
    $_SESSION['icon-message'] = '#check-circle-fill';
    $_SESSION['insert_user_message'] = "Veículo cadastrado com sucesso!";
    header("Location: ../pages/addVehicle.php");
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = "Por favor, selecione somente 1 cliente!";
    header("Location: ../pages/addVehicle.php");

  }
  print_r($idClient[0]);
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Por favor, selecione um cliente!";
  header("Location: ../pages/addVehicle.php");
}

