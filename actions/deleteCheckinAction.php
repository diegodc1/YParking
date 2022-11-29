<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');

$checkinDao = new CheckinDaoDB($pdo);

$checkin_id = filter_input(INPUT_GET, 'checkinid');

if($checkin_id){
  $checkinDao->cancel($checkin_id);
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



