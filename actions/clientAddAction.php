<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
session_start();

$clientDao = new ClientDaoDB($pdo);

$name = ucwords(strtolower(trim(filter_input(INPUT_POST, 'inputName'))));
$email = trim(filter_input(INPUT_POST, 'inputEmail'));
$phone = trim(filter_input(INPUT_POST, 'inputPhoneNumber'));
$zip = trim(filter_input(INPUT_POST, 'inputZipCode'));
$road = trim(filter_input(INPUT_POST, 'inputRoad'));
$district = trim(filter_input(INPUT_POST, 'inputDistrict'));
$city = trim(filter_input(INPUT_POST, 'inputCity'));
$state = trim(filter_input(INPUT_POST, 'inputState'));
$number = trim(filter_input(INPUT_POST, 'inputNumber'));
$typeUse = trim(filter_input(INPUT_POST, 'inputType'));
$bussinesPlan = trim(filter_input(INPUT_POST, 'inputBussinesPlan'));
$companyId = trim(filter_input(INPUT_POST, 'inputCompanyUse'));

$departureTime = '11:40';
$status = 'Ativo';
$address = $road . ", " .  $number . " - " . $district . ", " . $city . " - " . $state;
$newZip = preg_replace('/[-\@\.\;\" "]+/', '', $zip);

$newClient = new Client();
$newClient->setName($name);
$newClient->setEmail($email);
$newClient->setPhone($phone);
$newClient->setCep($newZip);
$newClient->setAddress($address);
$newClient->setType($typeUse);
$newClient->setBussinesPlan($bussinesPlan);
$newClient->setDepartureTime($departureTime);
$newClient->setStatus($status);

if($companyId) {
  $newClient->setCompanyId($companyId);
}

$clientDao->add($newClient);
$lastIdClient = $pdo->lastInsertId();
header("Location: ../pages/addVehicleToClient.php?lastId=$lastIdClient");
