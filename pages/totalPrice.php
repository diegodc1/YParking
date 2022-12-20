<?php
session_start();
require_once('../db/config.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');


$checkoutDao = new CheckoutDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);

$lastCheckOut = $checkoutDao->findLastCheckout();

$idVechicle = $lastCheckOut->getVehicleId();
$idClient = $lastCheckOut->getClientId();

$vehicle = $vehicleDao->findById($idVechicle);
$client = $clientDao->findById($idClient);


$interSec = filter_input(INPUT_GET, 'sec');
$interMin = filter_input(INPUT_GET, 'min');
$interHours = filter_input(INPUT_GET, 'hours');



$interHours = intval($interHours);


if($interHours > 0) {
  $interHours = substr($interHours, 0, 2);
} else {
  $interHours = 0;
}


$interMin = intval($interMin);

if($interMin > 9) {
  $interMin = substr($interMin, 0, 2);
} else {
  $interMin = substr($interMin, 0, 1);
}

$dateCkeckout = new DateTime($lastCheckOut->getDate());
$dateCkeckin = new DateTime($lastCheckOut->getCkinDate());

?>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="stylesheet" href="../styles/totalPrice.css">
</head>

<body>
  <?php require_once('../components/sidebar.php');?> 

  <header class="price-header">
    <h1>CHECK-OUT REALIZADO COM SUCESSO!</h1>
  </header>


  <main class="main-price">
      <div class="box-content">
        <div class="box-header">
          <i class="fa-solid fa-circle-check"></i>
          <h5>Checkout Realizado</h5>
        </div>
        <div class="content-items">
            <div class="info-col-1">
              <p>Modelo: <span class="text"> <?= $vehicle->getModel()?></span></p>
              <p>Categoria: <span class="text"> <?= $vehicle->getCategory()?></span></p>
              <p>Data Check-in: <span class="text"> <?= $dateCkeckin->format('d/m/Y')?></span></p>
              <p>Data Check-out: <span class="text">  <?= $dateCkeckout->format('d/m/Y')?></span></p>
              <p>Tempo estacionado: <span class="text"> <?= $interHours?>h <?= $interMin?>m</span></p>

            </div>

            <div class="info-col-2">
              <p>Placa:  <span class="text">  <?= $vehicle->getPlate()?></span></p>
              <p>Cliente:  <span class="text"><?= $client->getName()?></span></p>
              <p>Horário Check-in:  <span class="text"> <?= substr($lastCheckOut->getCkinTime(), 0,8)?></span></p>
              <p>Horário Check-out:  <span class="text"> <?= $lastCheckOut->getTime()?></span></p>
            </div>
        </div>

         <div class="div-line"></div>

         <div class="price-box">
            <h3>Valor Total:</h3>
            <p class="price-value">
               <?= $lastCheckOut->getTotalValue()?> 
            </p>
         </div>

         <a href="../pages/checkin.php" class="btn-return">Finalizar</a>  
      </div>
  </main>
</body>
