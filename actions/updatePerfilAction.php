<?php 
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

$usuarioDao = new UsuarioDaoDB($pdo);

$id = filter_input(INPUT_POST, 'inputPerfilId');
$name = filter_input(INPUT_POST, 'inputName');
$email = filter_input(INPUT_POST, 'inputEmail');
$password = filter_input(INPUT_POST, 'inputPerfilPassword');
$confirmPassword = filter_input(INPUT_POST, 'inputConfirmPassword');

$pass = false;

if(!empty($id)) {
  $perfil = new Usuario();
  $perfil->setId($id);
  $perfil->setName($name);
  $perfil->setEmail($email);

  if(!empty($password) && !empty($confirmPassword)) {
    if($password === $confirmPassword) {
      $pass = true;
      $perfil->setPassword($password);
      $usuarioDao->updatePerfil($perfil, $pass);
      $_SESSION['message-type'] = 'success';
      $_SESSION['icon-message'] = '#check-circle-fill';
      $_SESSION['insert_user_message'] = "Usuário atualizado com sucesso!";
      header("Location: ../pages/perfil.php");
      exit;
    } else {
      $_SESSION['message-type'] = 'danger';
      $_SESSION['icon-message'] = '#exclamation-triangle-fill';
      $_SESSION['insert_user_message'] = "As senhas devem ser iguais!";
      header("Location: ../pages/perfil.php");
      exit();
    }
  } else {
      $pass = false;
      $usuarioDao->updatePerfil($perfil, $pass);
      $_SESSION['message-type'] = 'success';
      $_SESSION['icon-message'] = '#check-circle-fill';
      $_SESSION['insert_user_message'] = "Usuário atualizado com sucesso!";
      header("Location: ../pages/perfil.php");
  }
}


?>