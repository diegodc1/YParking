<?php 

require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
session_start();

$companyDao = new CompanyDaoDB($pdo);

$name = trim(filter_input(INPUT_POST, 'inputName'));
$email = trim(filter_input(INPUT_POST, 'inputEmail'));
$phone = trim(filter_input(INPUT_POST, 'inputPhone'));
$slots = trim(filter_input(INPUT_POST, 'inputSlots'));
$status = 'Ativo';

date_default_timezone_set('America/Sao_Paulo');
$cadDate = date("d-m-Y");
$cadTime = date('H:i:s');

$newCompany = new Company();
$newCompany->setName($name);
$newCompany->setEmail($email);
$newCompany->setPhone($phone);
$newCompany->setSlots($slots);
$newCompany->setStatus($status);
$newCompany->setCadDate($cadDate);
$newCompany->setCadTime($cadTime);

$companyDao->add($newCompany);

$_SESSION['message-type'] = 'success';
$_SESSION['icon-message'] = '#check-circle-fill';
$_SESSION['insert_user_message'] = "Empresa cadastrada com sucesso!";
header("Location: ../pages/addCompany.php");
exit();

