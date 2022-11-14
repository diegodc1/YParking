<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/ClientDao.php');


$clientDao = new ClientDaoDB($pdo);
$clients = $clientDao->findAll();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/headConfig.php')?> ;
  <link rel="stylesheet" href="/styles/addClient.css">
  <title>Cadastrar Veículo</title>
</head>


<body class="addClient-body">
  <?php require_once('../components/sidebar.php') ?>

  <header>
    <h1>CADASTRO DE VEÍCULO</h1>
  </header>

  <main>
    <section class="client-info">
      <form action="../actions/addVehicleAction.php" method="POST" class="row">
        <div class="form-box1">
          <h2>DADOS DO VEÍCULO</h2>
          <div class="line"></div>
          <div class="inputs2 row gx-3 gy-2 align-items-center">
            <div class="col-md-2">
              <label for="inputVehicleBrand" class="form-label">Marca:</label>
              <input type="text" class="form-control" autocomplete="off" name="inputVehicleBrand" require>
            </div>
            <div class="col-md-2">
              <label for="inputVehicleModel" class="form-label">Modelo:</label>
              <input type="text" class="form-control" autocomplete="off" name="inputVehicleModel" require>
            </div>
            <div class="col-md-1">
              <label for="inputVehiclePlate" class="form-label">Placa:</label>
              <input type="text" class="form-control" name="inputVehiclePlate" autocomplete="off" require >
            </div>
            <div class="col-md-2">
              <label for="inputVehicleColor" class="form-label">Cor:</label>
              <input type="text" class="form-control" autocomplete="off" name="inputVehicleColor" require>
            </div>

            <div class="col-md-2">
              <label for="inputVehicleCategory" class="form-label">Categoria:</label>
              <select name="inputVehicleCategory" class="form-select" require>
                <option selected>Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Hatch">Hatch</option>
                <option value="Caminhonete">Caminhonete</option>
                <option value="Moto">Moto</option>
                <option value="Caminhao">Caminhão</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="inputHourOut" class="form-label">Horário Previsto de Saída:</label>
              <input type="text" class="form-control" name="inputHourOut" autocomplete="off" maxlength="5" OnKeyPress="formatar('##:##', this)" require>
            </div>
          </div>
        </div>

        <div class="form-box2">
          <h2>SELECIONAR CLIENTE</h2>
          <?php require('../components/alertMessage.php')?>
          <div class="line"></div>
          <table class="table table-select-users table align-middle" id="listSelectClient">
              <thead>
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">Telefone</th>
                  <th scope="col">Tipo de Plano</th>
                  <th scope="col">Convênio de Empresa</th>
                  <th scope="col ">Selecionar</th>
                </tr>
              </thead>
              <tbody class="table-striped">
                <?php 
                  foreach($clients as $client) { ?>
                    <tr>
                      <td scope="row" class="td-nome"> <?= $client->getName() ?></td>
                      <td scope="row" class="td-phone"><?= $client->getPhone() ?></td>
                      <td class=""><?= $client->getType() ?></td>
                      <td class=""><?= $client->getBussinesPlan() ?></td>
                      <td class="deleteIcon td-select"> <input type="checkbox" class="check-box-client" name="selectedClients[]" value="<?= $client->getId() ?>"></td>
                    </tr>
                  <?php }
                ?>
              </tbody>
          </table>
        </div>

        <div class="col-12 buttons-group">
          <button type="reset" class="btn btn-primary clear-button">Limpar</button>
          <button type="submit" class="btn btn-primary submit-button">Cadastrar Veículo</button>
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