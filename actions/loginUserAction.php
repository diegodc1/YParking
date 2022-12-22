<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

$usuarioDao = new UsuarioDaoDB($pdo);

$email = filter_input(INPUT_POST, 'inputEmail');
$password = filter_input(INPUT_POST, 'inputPassword');

if($usuarioDao->findUserLogin($email, $password) != false) {
  $user = $usuarioDao->findByEmail($email);
  if($user->getStatus() === 'Ativo') {
    $_SESSION['user_id'] = $user->getId();
    $_SESSION['user_email'] = $user->getEmail();
    $_SESSION['user_name'] = $user->getName();
    $_SESSION['user_function'] = $user->getFunction();
    $_SESSION['user_access'] = $user->getAccess();
    $_SESSION['user_logado'] = true;
  
    header("Location: ../pages/dashboard.php");
  } else {
    $_SESSION['message-type'] = 'danger';
    $_SESSION['icon-message'] = '#exclamation-triangle-fill';
    $_SESSION['insert_user_message'] = "Usuário desativado! Entre em contato com o administrador!";
    header("Location: ../index.php");
  }
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Usuário ou senha incorretos!";
  header("Location: ../index.php");

}