<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

$usuarioDao = new UsuarioDaoDB($pdo);

$id = filter_input(INPUT_POST, 'inputUserId');
$name = filter_input(INPUT_POST, 'inputName');
$email = filter_input(INPUT_POST, 'inputEmail');
$function = filter_input(INPUT_POST, 'inputFunction');
$access = filter_input(INPUT_POST, 'inputAccess');

if(!empty($id)) {
  $user = new Usuario();
  $user->setId($id);
  $user->setName($name);
  $user->setEmail($email);
  $user->setFunction($function);
  $user->setAccess($access);

  $usuarioDao->update($user);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Usuário atualizado com sucesso!";
  header("Location: ../pages/editUser.php?id=".$id);
  exit;
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Houve um erro e não foi possível atualizar o usuário!";
  header("Location: ../pages/dashboard.php");
  exit;
}