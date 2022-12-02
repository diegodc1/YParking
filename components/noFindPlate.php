<?php 
  session_start();

  $_SESSION['message-type'] = 'danger';
  $_SESSION['icon-message'] = '#exclamation-triangle-fill';
  $_SESSION['insert_user_message'] = "Veículo não encontrado ou a placa está incorreta!";
  header("Location: ../pages/checkin.php");
?>