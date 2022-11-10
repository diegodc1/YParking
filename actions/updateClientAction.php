<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
session_start();

$clientDao = new ClientDaoDB($pdo);

$clientId = filter_input(INPUT_POST, 'inputClientId');
$name = filter_input(INPUT_POST, 'inputName');
$email = filter_input(INPUT_POST, 'inputEmail');
$phone = filter_input(INPUT_POST, 'inputPhoneNumber');
$zip = filter_input(INPUT_POST, 'inputZip');
$address = filter_input(INPUT_POST, 'inputAddress');
$type = filter_input(INPUT_POST, 'inputType');
$bussinesPlan = filter_input(INPUT_POST, 'inputBussinesPlan');

if($clientId) {
  $client = new Client();
  $client->setId($clientId);
  $client->setName($name);
  $client->setEmail($email);
  $client->setPhone($phone);
  $client->setCep($zip);
  $client->setAddress($address);
  $client->setType($type);
  $client->setBussinesPlan($bussinesPlan);

  $clientDao->update($client);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Cliente atualizado com sucesso!";
  header("Location: ../pages/editClient.php?id=".$clientId);
  exit;
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Houve um erro e não foi possível atualizar o usuário!";
  header("Location: ../pages/editClient.php?id=".$clientId);
  exit;
}
