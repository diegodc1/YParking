<?php 
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
require_once('../dao/ClientDao.php');

session_start();
$companyId = filter_input(INPUT_GET, 'id');

$companyDao= new CompanyDaoDB($pdo);
$clientDao= new ClientDaoDB($pdo);
$clientCompanyQtd = $clientDao->findByClientIdQtd($companyId);

if($clientCompanyQtd > 0) {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Não é possível excluir uma empresa enquanto ela possui clientes vinculados!';
  header("Location: ../pages/listCompanys.php");
} else {
  if($companyId) {
    $companyDao->delete($companyId);
    
    $_SESSION['message-type'] = 'success';
    $_SESSION['icon-message'] = '#check-circle-fill';
    $_SESSION['insert_user_message'] = 'Empresa excluída com sucesso!';
    header("Location: ../pages/listCompanys.php");
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
    header("Location: ../pages/listCompanys.php");
  }
}