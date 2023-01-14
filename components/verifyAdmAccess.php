<?php
if($_SESSION['user_access'] == 0 ){
  header("Location: ../pages/dashboard.php");
}