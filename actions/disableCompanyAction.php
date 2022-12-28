<?php 
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
require_once('../dao/ClientDao.php');

session_start();
$companyId = filter_input(INPUT_GET, 'id');

$companyDao= new CompanyDaoDB($pdo);
$clientDao= new ClientDaoDB($pdo);
$clientCompanyQtd = $clientDao->findByClientIdQtd($companyId);


if($companyId) {
  $companyDao->disable($companyId);
  
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Empresa desativada com sucesso!';
  header("Location: ../pages/listCompanys.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listCompanys.php");
}
