<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/MovementDao.php');

$checkoutDao = new CheckoutDaoDB($pdo);
$movementDao = new movementDaoDB($pdo);

$checkout_id = filter_input(INPUT_GET, 'checkoutid');
$cancel_reason = filter_input(INPUT_POST, 'cancelCkOutReasonInput');
$user_id = filter_input(INPUT_GET, 'userId');
$ckin_id = filter_input(INPUT_GET, 'ckin');

date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");
$status = "Ativo"; 
$type = 'cnclCkout';

if($checkout_id){
  $checkoutDao->cancel($checkout_id, $cancel_reason, $user_id, $ckin_id);

  
  //add movement
  $newMovement = new Movement;
  $newMovement->setType($type);
  $newMovement->setDate($date);
  $newMovement->setTime($time);
  $newMovement->setUserId($user_id);
  $newMovement->setStatus($status);
  $newMovement->setCkoutId($checkout_id);

  $movementDao->add($newMovement);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Checkout cancelado com sucesso!";
  header("Location: ../pages/checkin.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Houve um erro ao realizar esta operação! Tente novamente!";
  header("Location: ../pages/checkin.php");
}

