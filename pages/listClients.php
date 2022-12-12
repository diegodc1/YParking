<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
session_start();

$clientDao = new ClientDaoDB($pdo);
$clients = $clientDao->findAll();

$vehicleDao = new VehicleDaoDB($pdo);
?>

<head>
  <title>Clientes Cadastrados</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/listClients.css">
</head>

<body>
  <?php 
  require_once("../components/sidebar.php") ;
    ?>

  <header class="list-clients-header">
    <h1>CLIENTES CADASTRADOS</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box">
        <a href="/pages/addClient.php" class="add-user-button">Cadastrar Cliente</a>
      </div>

      <div class="table-list">
        <?php require('../components/alertMessage.php')?>
        <table id="listClientsVehicles" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Telefone</th>
              <th>Tipo</th>
              <th>Convênio</th>
              <th>Veículos</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($clients as $client) {
                $clientVehicleQtd = $vehicleDao->findByClientIdQtd($client->getId()); ?>
                <tr>
                  <td><?= $client->getName(); ?></td>
                  <td><?= $client->getPhone()?></td>
                  <td><?= $client->getType();?></td>
                  <td><?= $client->getBussinesPlan();?></td>
                  <td><?= $clientVehicleQtd ?></td>
                  <td><?= $client->getStatus();?></td>
                  <td>
                    <div class="action-buttons">
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="../pages/viewClient.php?id=<?= $client->getId() ?>"><i class="fa-solid fa-eye eye"></i></a></button>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="../pages/editClient.php?id=<?= $client->getId() ?>"><i class="fa-solid fa-pencil pencil"></i></a></button>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDelModal<?= $client->getId();?>"><i class="fa-solid fa-trash-can trash"></i></a></button>
                    </div>
                  </td>
                </tr>

                          
              <!-- Confirm delete modal-->
            <div class="modal fade" id="confirmDelModal<?= $client->getId();?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="modal-body-1">
                      <i class="fa-solid fa-circle-exclamation"></i>
                      <h5 class="modal-title" id="exampleModalLabel">Desativar Cliente</h5>
                    </div>
                    <div class="modal-body-2">
                      <p class="p-modal-warning"><span>Você realmente deseja desativar este cliente?</p>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                    <a href="../actions/deleteClientAction.php?id=<?= $client->getId(); ?>" class="btn btn-primary button-confirm-modal" >Desativar</a>
                  </div>
                </div>
              </div>
            </div>
             <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/dataTable.js"></script>

</body>



</html>