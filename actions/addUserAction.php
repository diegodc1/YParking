<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');

$usuarioDao = new UsuarioDaoDB($pdo);

$name = filter_input(INPUT_POST, 'inputName');
$email = filter_input(INPUT_POST, 'inputEmail');
$function = filter_input(INPUT_POST, 'inputFunction');
$password = filter_input(INPUT_POST, 'inputPassword');
$confirmPassword = filter_input(INPUT_POST, 'inputConfirmPassword');
$access = filter_input(INPUT_POST, 'inputAccess');


if($usuarioDao->findByEmail($email) === false) {
  if($password === $confirmPassword) {
    $newUser = new Usuario();
    $newUser->setName($name);
    $newUser->setEmail($email);
    $newUser->setFunction($function);
    $newUser->setPassword($password);
    $newUser->setAccess($access);

    $usuarioDao->add($newUser);

    header("Location: ../pages/dashboard.php");
    exit();
  } else {
    header("Location: ../pages/perfil.php.php");
    exit();
  }
} else {
  header("Location: ../pages/perfil.php");
  exit();
}

