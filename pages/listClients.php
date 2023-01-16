<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
session_start();
require_once('../components/verifyLogin.php');


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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/listClients.css">
  <link rel="stylesheet" href="../styles/style.css">
  <?php require_once('../components/favicon.php') ?>;

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
          <a href="dashboard.php" class="btn back-button"><i class="fa-solid fa-arrow-left"></i>Voltar</a>
        <a href="/pages/addClient.php" class="add-user-button">Cadastrar Cliente</a>
      </div>

      <div class="table-list">
        <?php require('../components/alertMessage.php')?>
        <table id="listClients" class="table" style="width:100%">
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
                      <?php 
                        if($client->getStatus() === 'Ativo'){ ?>
                            <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Desativar"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDelModal<?= $client->getId();?>"><i class="fa-solid fa-ban trash"></i></a></button>
                        <?php } else { ?>
                            <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reativar"><a href="" data-bs-toggle="modal" data-bs-target="#confirmActiveModal<?= $client->getId();?>"><i class="fa-solid fa-power-off reactivate"></i></a></button>
                        <?php } ?>  
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
                    <a href="../actions/disableClientAction.php?id=<?= $client->getId(); ?>" class="btn btn-primary button-confirm-modal" >Desativar</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="confirmActiveModal<?= $client->getId();?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="modal-body-1">
                      <i class="fa-solid fa-circle-exclamation"></i>
                      <h5 class="modal-title" id="exampleModalLabel">Reativar Cliente</h5>
                    </div>
                    <div class="modal-body-2">
                      <p class="p-modal-warning"><span>Você realmente deseja reativar este cliente?</p>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                    <a href="../actions/reactivateClientAction.php?id=<?= $client->getId(); ?>" class="btn btn-primary button-confirm-modal act" >Reativar</a>
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