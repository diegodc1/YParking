<?php 
require_once('../db/config.php');
require_once('../dao/SectionDao.php');
session_start();

$sectionDao = new SectionDaoDB($pdo);

$id = filter_input(INPUT_GET, 'id');
$name = filter_input(INPUT_POST, 'inputSectionName');
$slots = filter_input(INPUT_POST, 'inputSlotsSection');
$color = filter_input(INPUT_POST, 'inputSectionColor');

echo $id . '<br>';
echo $name . '<br>';
echo $slots . '<br>';
echo $color . '<br>';

if(!empty($id)) {
  $section = new Section();
  $section->setId($id);
  $section->setName($name);
  $section->setSlots($slots);
  $section->setColor($color);

  $sectionDao->update($section);

  $_SESSION['message-type'] = 'success';
  $_SESSION['icon-message'] = '#check-circle-fill';
  $_SESSION['insert_user_message'] = "Seção atualizada com sucesso!";
  header("Location: ../pages/parking.php");
}