<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
session_start();

$clientDao = new ClientDaoDB($pdo);

$name = filter_input(INPUT_POST, 'inputName');
$email = filter_input(INPUT_POST, 'inputEmail');
$phone = filter_input(INPUT_POST, 'inputPhoneNumber');
$zip = filter_input(INPUT_POST, 'inputZipCode');
$road = filter_input(INPUT_POST, 'inputRoad');
$district = filter_input(INPUT_POST, 'inputDistrict');
$city = filter_input(INPUT_POST, 'inputCity');
$state = filter_input(INPUT_POST, 'inputState');
$number = filter_input(INPUT_POST, 'inputNumber');
$typeUse = filter_input(INPUT_POST, 'inputType');
$bussinesPlan = filter_input(INPUT_POST, 'inputBussinesPlan');
$companyId = filter_input(INPUT_POST, 'inputCompanyUse');
$departureTime = '11:40';
$address = $road . ", " .  $number . " - " . $district . ", " . $city . " - " . $state;

$newClient = new Client();
$newClient->setName($name);
$newClient->setEmail($email);
$newClient->setPhone($phone);
$newClient->setCep($zip);
$newClient->setAddress($address);
$newClient->setType($typeUse);
$newClient->setBussinesPlan($bussinesPlan);
$newClient->setDepartureTime($departureTime);
$newClient->setCompanyId($companyId);

$clientDao->add($newClient);
header("Location: ../pages/addClient.php");