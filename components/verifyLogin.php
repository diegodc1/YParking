<?php
if($_SESSION['user_logado'] == false ){
  header("Location: ../index.php");
}