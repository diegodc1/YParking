<?php 
require_once('../db/config.php');
require_once('../dao/SectionDao.php');
session_start();

$sectionDao= new SectionDaoDB($pdo);

$id = filter_input(INPUT_GET, 'id');
if ($id) {
  $sectionDao->delete($id);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = 'Seção excluída com sucesso!';
  header("Location: ../pages/parkingSections.php");
} else {
  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = 'Houve um erro neste processo!';
  header("Location: ../pages/parkingSections.php");
}

