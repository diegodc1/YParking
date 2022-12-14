<?php 
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

$usuarioDao= new UsuarioDaoDB($pdo);

$id = filter_input(INPUT_GET, 'id');
if ($id) {
  $usuarioDao->reactivate($id);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Usuário reativado com sucesso!';
  header("Location: ../pages/listUsers.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/listUsers.php");
}