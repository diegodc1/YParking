<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/MovementDao.php');
require_once('../dao/CompanyDao.php');

$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$movementDao = new movementDaoDB($pdo);
$companyDao = new companyDaoDB($pdo);

//Busca o veículo no BD
$vehicleId = filter_input(INPUT_GET, 'vehicle');
$vehicle = $vehicleDao->findById($vehicleId);

//Pega os id's do cliente, da seção e do user.
$clientId = $vehicle->getClientId();
$sectionId = filter_input(INPUT_GET, 'section');
$userId = $_SESSION['user_id'];
$client = $clientDao->findById($clientId);

//se existir, pega a empresa vinculada com o cliente
$company = $companyDao->findById($client->getCompanyId());

//Pega a data atual
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y/m/d");

//Procura no BD se já existe um checkin com o id do veículo
$checkinsVehicle = $checkinDao->findAllDailyVehicleId($date, $vehicleId);

$time = date('H:i:s');
$date = date("d/m/Y");
$status = "Ativo"; 
$type = 'ckin';

//Verifica se o cliente está com o cadastro ativo
if($client->getStatus() === 'Ativo') {

  //Verifica se o veículo está com o cadastro ativo
  if($vehicle->getStatus() === 'Ativo'){

    //Verifica se o cliente tem convenio de empresa
    if($client->getBussinesPlan() === 'Não') {
      if($checkinsVehicle === false) {
      //add checkin
      $newCheckIn = new Checkin;
      $newCheckIn->setVehicleId($vehicleId);
      $newCheckIn->setClientId($clientId);
      $newCheckIn->setSectionId($sectionId);
      $newCheckIn->setUserId($userId);
      $newCheckIn->setTime($time);
      $newCheckIn->setStatus($status);
      $newCheckIn->setDate($date);

      $checkinDao->add($newCheckIn);

      //add movement
      $newMovement = new Movement;
      $newMovement->setType($type);
      $newMovement->setDate($date);
      $newMovement->setTime($time);
      $newMovement->setVehicleId($vehicleId);
      $newMovement->setClientId($clientId);
      $newMovement->setUserId($userId);
      $newMovement->setStatus($status);

      $movementDao->add($newMovement);


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

    } else if ($client->getBussinesPlan() === 'Sim' && $company->getStatus() === 'Ativo') {
        if($checkinsVehicle === false) {
        //add checkin
        $newCheckIn = new Checkin;
        $newCheckIn->setVehicleId($vehicleId);
        $newCheckIn->setClientId($clientId);
        $newCheckIn->setSectionId($sectionId);
        $newCheckIn->setUserId($userId);
        $newCheckIn->setTime($time);
        $newCheckIn->setStatus($status);
        $newCheckIn->setDate($date);

        $checkinDao->add($newCheckIn);

        //add movement
        $newMovement = new Movement;
        $newMovement->setType($type);
        $newMovement->setDate($date);
        $newMovement->setTime($time);
        $newMovement->setVehicleId($vehicleId);
        $newMovement->setClientId($clientId);
        $newMovement->setUserId($userId);
        $newMovement->setStatus($status);

        $movementDao->add($newMovement);


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
    } else {
      $_SESSION['message-type'] = 'danger';
      $_SESSION['icon-message'] = '#exclamation-triangle-fill';
      $_SESSION['insert_user_message'] = "A empresa em que este cliente está vinculado está com o cadastro desativado!";
      header("Location: ../pages/checkin.php");
    }
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = "Veículo está com o cadastro desativado! Reative para prosseguir com está ação!";
    header("Location: ../pages/checkin.php");
  }
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Proprietário do veículo está com seu cadastro desativado! Reative para prosseguir com está ação!";
  header("Location: ../pages/checkin.php");
}


