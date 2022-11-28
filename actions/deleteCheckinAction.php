<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');

$checkinDao = new CheckinDaoDB($pdo);

$checkin_id = filter_input(INPUT_GET, 'checkinid');

if($checkin_id){
  $checkinDao->delete($checkin_id);
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Checkin excluído com sucesso!";
  header("Location: ../pages/checkin.php");
} else {
  header("Location: ../pages/checkin.php");
}



