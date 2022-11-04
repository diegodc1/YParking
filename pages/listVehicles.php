<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
session_start();

$vechicleDao = new VehicleDaoDB($pdo);
$vehicles = $vechicleDao->findAll();

$clientDao  = new ClientDaoDB($pdo);

?>

<head>
  <title>Clientes Cadastrados</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../stylesstyle.css">
  <link rel="stylesheet" href="../styles/listVehicles.css">
</head>

<body>
  <?php require_once("../components/sidebar.php") ?>
  <header class="list-clients-header">
    <h1>VEÍCULOS CADASTRADOS</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box">
        <a href="/pages/addClient.php" class="add-user-button">Cadastrar Veículo</a>
      </div>

      <div class="table-list">
        <table id="listClientsVehicles" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Marca</th>
              <th>Cor</th>
              <th>Categoria</th>
              <th>Cliente</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($vehicles as $vehicle) { ?>
                <tr>
                  <td><?= $vehicle->getModel(); ?></td>
                  <td><?= $vehicle->getPlate(); ?></td>       // Erro aqui
                  <td><?= $vehicle->getBrand(); ?></td>
                  <td><?= $vehicle->getColor(); ?></td>
                  <td><?= $vehicle->getCategory(); ?></td>
                  <?php 
                    $idClient = $vehicle->getClientId();
                    $client = $clientDao->findByVehicle($idClient);
                    echo $client->getName();

                  ?>  
           
                  <td><?=print_r($client); ?></td>

                  <td>
                    <div class="action-buttons">
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                    </div>
                  </td>
                </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>

</body>



</html>