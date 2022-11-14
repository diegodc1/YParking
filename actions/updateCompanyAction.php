<?php 
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
session_start();

$companyDao = new CompanyDaoDB($pdo);

$id = filter_input(INPUT_POST, 'inputCompanyId');
$name = filter_input(INPUT_POST, 'inputName');
$email = filter_input(INPUT_POST, 'inputEmail');
$phone = filter_input(INPUT_POST, 'inputPhone');
$slots = filter_input(INPUT_POST, 'inputSlots');

if(!empty($id)) {
  $company = new Company();
  $company->setId($id);
  $company->setName($name);
  $company->setEmail($email);
  $company->setPhone($phone);
  $company->setSlots($slots);

  $companyDao->update($company);
  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Empresa atualizada com sucesso!";
  header("Location: ../pages/editCompany.php?id=".$id);
  exit;
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Houve um erro e não foi possível atualizar a empresa!";
  header("Location: ../pages/editCompany.php?id=".$id);
  exit;
}