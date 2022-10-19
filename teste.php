<?php
require_once('./db/config.php');

$name = "Empresa 2";
$email = "teste2@teste2.com";
$slots = 20;
$phone = 41997017823;

$sql = $pdo->prepare("INSERT INTO companys (company_name, company_email, company_slots) VALUES (:name, :email, :slots)");
$sql->bindValue(':name', $name);
$sql->bindValue(':email', $email);
$sql->bindValue(':slots', $slots);
$sql->execute();

echo "Foi";
