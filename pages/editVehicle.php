<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../components/verifyLogin.php');


$vehicleId = filter_input(INPUT_GET, 'id');

$vehicleDao = new VehicleDaoDB($pdo);

if($vehicleId) {
  $vehicle = $vehicleDao->findById($vehicleId);
}

if($vehicle === false) {
  header("Location: listVehicles.php");
  exit;
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php require_once('../components/favicon.php') ?>;
  <?php require_once('../components/headConfig.php')?> ;
  <link rel="stylesheet" href="/styles/addClient.css">
  <title>Editar Veículo</title>
</head>

<body class="addClient-body">
  <?php require_once('../components/sidebar.php') ?>

  <header>
    <h1>EDITAR VEÍCULO</h1>
  </header>

  <main>
    <section class="client-info">
      <?php require_once('../components/alertMessage.php') ?>

      <form action="../actions/updateVehicleAction.php" method="POST" class="row">
        <div class="form-box1">
          
          <h2>DADOS DO VEÍCULO</h2>
          <div class="line"></div>

          <input type="hidden" name="inputVehicleId" value="<?= $vehicle->getId(); ?>">

          <div class="inputs2 row gx-3 gy-2 align-items-center">
            <div class="col-md-2">
              <label for="inputVehicleModel" class="form-label">Modelo:</label>
              <input type="text" class="form-control" name="inputVehicleModel" value="<?= $vehicle->getModel()?>">
            </div>
            <div class="col-md-2">
              <label for="inputVehicleBrand" class="form-label">Marca:</label>
              <input type="text" class="form-control" name="inputVehicleBrand" value="<?= $vehicle->getBrand()?>">
            </div>
            <div class="col-md-1">
              <label for="inputVehiclePlate" class="form-label">Placa:</label>
              <input type="text" class="form-control" name="inputVehiclePlate" value="<?= $vehicle->getPlate()?>">
            </div>
            <div class="col-md-2">
              <label for="inputVehicleColor" class="form-label">Cor:</label>
              <input type="text" class="form-control" name="inputVehicleColor" value="<?= $vehicle->getColor()?>">
            </div>

            <div class="col-md-2">
              <label for="inputVehicleCategory" class="form-label">Categoria:</label>

              <select name="inputVehicleCategory" class="form-select">
                <option value="<?= $vehicle->getCategory()?>" selected><?= $vehicle->getCategory()?></option>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Hatch">Hatch</option>
                <option value="Caminhonete">Caminhonete</option>
                <option value="Moto">Moto</option>
                <option value="Caminhao">Caminhão</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="inputHourOut" class="form-label">Horário Previsto de Saída:</label>
              <input type="text" class="form-control" name="inputHourOut" value="<?= $vehicle->getDepartureTime()?>">
            </div>
          </div>
        </div>

        <div class="col-12 buttons-group">
          <a href="listVehicles.php" class="btn btn-primary clear-button">Voltar</a>
          <button type="submit" class="btn btn-primary submit-button">Atualizar Veículo</button>
        </div>
      </form>
    </section>
  </main>

  
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="/js/datatable.js"></script>
  <script>
    function formatar(mascara, documento) {
      var i = documento.value.length;
      var saida = mascara.substring(0, 1);
      var texto = mascara.substring(i)

      if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
      }

    }
  </script>
</body>

</html>