<?php
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
session_start();

$vehicleDao = new VehicleDaoDB($pdo);

$id = filter_input(INPUT_POST, 'inputVehicleId');
$model = filter_input(INPUT_POST, 'inputVehicleModel');
$brand = filter_input(INPUT_POST, 'inputVehicleBrand');
$plate = filter_input(INPUT_POST, 'inputVehiclePlate');
$color = filter_input(INPUT_POST, 'inputVehicleColor');
$category = filter_input(INPUT_POST, 'inputVehicleCategory');


if(!empty($id)) {
  $vehicle = new Vehicle();
  $vehicle->setId($id);
  $vehicle->setModel($model);
  $vehicle->setBrand($brand);
  $vehicle->setPlate($plate);
  $vehicle->setColor($color);
  $vehicle->setCategory($category);

  $vehicleDao->update($vehicle);
  

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Veículo atualizado com sucesso!";
  header("Location: ../pages/editVehicle.php?id=".$id);
  exit;
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Houve um erro e não foi possível atualizar o veículo!";
  header("Location: ../pages/editVehicle.php?id=".$id);
  exit;
}