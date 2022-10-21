<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

$usuarioDao = new UsuarioDaoDB($pdo);

$email = filter_input(INPUT_POST, 'inputEmail');
$password = filter_input(INPUT_POST, 'inputPassword');

if($usuarioDao->findUserLogin($email, $password) != false) {
  $user = $usuarioDao->findByEmail($email);
  $_SESSION['user_id'] = $user->getId();
 
  header("Location: ../pages/dashboard.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Usuário ou senha incorretos!";
  header("Location: ../index.php");

}