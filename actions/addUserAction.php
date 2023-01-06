<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

$usuarioDao = new UsuarioDaoDB($pdo);

$name = ucwords(strtolower(trim(filter_input(INPUT_POST, 'inputName'))));
$email = trim(filter_input(INPUT_POST, 'inputEmail'));
$function = trim(filter_input(INPUT_POST, 'inputFunction'));
$password = trim(filter_input(INPUT_POST, 'inputPassword'));
$confirmPassword = trim(filter_input(INPUT_POST, 'inputConfirmPassword'));
$access = trim(filter_input(INPUT_POST, 'inputAccess'));
$status = 'Ativo';

date_default_timezone_set('America/Sao_Paulo');
$cadDate = date("d-m-Y");
$cadTime = date('H:i:s');


if($usuarioDao->findByEmail($email) === false) {
  if($password === $confirmPassword) {
    $newUser = new Usuario();
    $newUser->setName($name);
    $newUser->setEmail($email);
    $newUser->setFunction($function);
    $newUser->setPassword($password);
    $newUser->setAccess($access);
    $newUser->setStatus($status);
    $newUser->setCadDate($cadDate);
    $newUser->setCadTime($cadTime);

    $usuarioDao->add($newUser);

    $_SESSION['message-type'] = 'success';
    $_SESSION['icon-message'] = '#check-circle-fill';
    $_SESSION['insert_user_message'] = "Usuário cadastrado com sucesso!";
    header("Location: ../pages/addUser.php");
    exit();
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = "As senhas devem ser iguais!";
    header("Location: ../pages/addUser.php");
    exit();
  }
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Usuário já cadastrado!";
  header("Location: ../pages/addUser.php");
  exit();
}

