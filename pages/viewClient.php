<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/CompanyDao.php');
require_once('../dao/ClientDao.php');
session_start();

$clientId = filter_input(INPUT_GET, 'id');

$vechicleDao = new VehicleDaoDB($pdo);
$vehicles = $vechicleDao->findByClientId($clientId);
$clientDao = new ClientDaoDB($pdo);
$companyDao = new CompanyDaoDB($pdo);

if($clientId){
  $client = $clientDao->findById($clientId);
}

if($client === false) {
  header("Location: listClients.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php require_once('../components/headConfig.php');?>
  <link rel="stylesheet" href="/styles/viewClient.css">
  <title>Cadastrar Cliente </title>

    <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>
<body class="addClient-body">
  <?php require_once('../components/sidebar.php') ?>
  <header>
    <h1>CADASTRO DE CLIENTE</h1>
  </header>

  <main>
    <section class="client-info">
      <form action="../actions/clientAddAction.php" method="POST" class="row">

        <div class="form-box1">
          <h2>DADOS GERAIS DO CLIENTE</h2>
          <div class="line"></div>

          <div class="inputs1 row gx-3 gy-2 align-items-center">
            <div class="col-md-2">
              <p class="title-info">Nome:</p>
              <span><?= $client->getName();?></span>
            </div>
            <div class="col-2">
              <p class="title-info">Email:</p>
              <span><?= $client->getEmail();?></span>
            </div>
            <div class="col-2">
              <p class="title-info">Telefone:</p>
              <span><?= $client->getPhone();?></span>
            </div>
            <div class="col-2">
              <p class="title-info">CEP:</p>
              <span><?= $client->getCep();?></span>
            </div>
            <div class="col-3">
              <p class="title-info">Endereço:</p>
              <span><?= $client->getAddress();?></span>
            </div>
            <div class="col-2">
              <p class="title-info">Tipo de Uso:</p>
              <span><?= $client->getType();?></span>
            </div>
            <div class="col-2">
              <p class="title-info">Convênio de Empresa:</p>
              <span><?= $client->getBussinesPlan();?></span>
            </div>

            <?php $companyName = $companyDao->findById($client->getCompanyId()); ?>
            <div class="col-2">
              <p class="title-info">Empresa:</p>
              <span><?= $companyName->getName();?></span>
            </div>
          </div>
        </div>

        <div class="table-list">
          <h2>VEÍCULOS DO CLIENTE</h2>
          <div class="line"></div>
            <table id="listVehiclesToClients" class="table" style="width:100%">
              <thead>
                <tr>
                  <th>Modelo</th>
                  <th>Placa</th>
                  <th>Marca</th>
                  <th>Cor</th>
                  <th>Categoria</th>
                  <th>Horário de Saída</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  foreach($vehicles as $vehicle) { ?>
                    <tr>
                      <td><?= $vehicle->getModel(); ?></td>
                      <td><?= $vehicle->getPlate(); ?></td>       
                      <td><?= $vehicle->getBrand(); ?></td>
                      <td><?= $vehicle->getColor(); ?></td>
                      <td><?= $vehicle->getCategory(); ?></td>
                      <td><?= $vehicle->getDepartureTime(); ?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          
          <a href="listClients.php" class="btn clear-button"><i class="fa-solid fa-arrow-left"></i>Voltar</a>

      </form>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>
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