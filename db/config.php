<?php
// $servidor = "localhost";
// $porta = 5433;
// $bancoDeDados = "yparking";
// $usuario = "postgres";
// $senha = "892112";

try {
  $pdo = new PDO("pgsql:host=localhost dbname=yparking user=postgres password=123");
  // echo "Foi";
} catch (PDOException $e) {
  print $e->getMessage();
}
