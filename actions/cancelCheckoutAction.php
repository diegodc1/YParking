<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckoutDao.php');

$checkoutDao = new CheckoutDaoDB($pdo);

$checkout_id = filter_input(INPUT_GET, 'checkoutid');
$cancel_reason = filter_input(INPUT_POST, 'cancelCkOutReasonInput');
$user_id = filter_input(INPUT_GET, 'userId');
$ckin_id = filter_input(INPUT_GET, 'ckin');

if($checkout_id){
  $checkoutDao->cancel($checkout_id, $cancel_reason, $user_id, $ckin_id);
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

