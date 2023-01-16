<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CompanyDao.php');
session_start();

$companyDao = new CompanyDaoDB($pdo);

$id = filter_input(INPUT_GET, 'id');

if($id){
  $companyDao->reactivate($id);
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Empresa reativada com sucesso!';
  header("Location: ../pages/listCompanys.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listCompanys.php");
}