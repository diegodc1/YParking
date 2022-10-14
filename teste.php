<?php
require_once('./db/config.php');

$name = "Empresa Teste";
$email = "teste@teste.com";
$slots = 10;
$phone = 41997017892;

$sql = $pdo->prepare("INSERT INTO companys (company_name, company_email, company_slots) VALUES (:name, :email, :slots)");
$sql->bindValue(':name', $name);
$sql->bindValue(':email', $email);
$sql->bindValue(':slots', $slots);
$sql->execute();

echo "Foi";
