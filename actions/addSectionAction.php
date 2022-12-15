<?php 
require_once('../db/config.php');
require_once('../dao/SectionDao.php');
session_start();

$sectionDao = new SectionDaoDB($pdo);

$name = ucwords(strtolower(trim(filter_input(INPUT_GET, 'inputNameSection'))));
$slots = trim(filter_input(INPUT_GET, 'inputSlotsSection'));
$color = filter_input(INPUT_GET, 'inputSectionColor');

$newSection = new Section();
$newSection->setName($name);
$newSection->setSlots($slots);
$newSection->setColor($color);

$sectionDao->add($newSection);

$_SESSION['message-type'] = 'success';
$_SESSION['icon-message'] = '#check-circle-fill';
$_SESSION['insert_user_message'] = "Seção cadastrada com sucesso!";
header("Location: ../pages/parking.php");
exit();
