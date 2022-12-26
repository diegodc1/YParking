<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/MovementDao.php');

$checkinDao = new CheckinDaoDB($pdo);
$movementDao = new movementDaoDB($pdo);

$checkin_id = filter_input(INPUT_GET, 'checkinid');
$cancel_reason = filter_input(INPUT_POST, 'cancelReasonInput');
$user_id = filter_input(INPUT_GET, 'userId');

date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");
$status = "Ativo"; 
$type = 'cnclCkin';

if($checkin_id){
  $checkinDao->cancel($checkin_id, $cancel_reason, $user_id);

  //add movement
  $newMovement = new Movement;
  $newMovement->setType($type);
  $newMovement->setDate($date);
  $newMovement->setTime($time);
  $newMovement->setUserId($user_id);
  $newMovement->setStatus($status);
  $newMovement->setCkinId($checkin_id);

  $movementDao->add($newMovement);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Checkin cancelado com sucesso!";
  header("Location: ../pages/checkin.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Houve um erro ao realizar esta operação! Tente novamente!";
  header("Location: ../pages/checkin.php");
}



