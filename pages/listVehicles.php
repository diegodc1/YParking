<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
session_start();

$vechicleDao = new VehicleDaoDB($pdo);
$vehicles = $vechicleDao->findAll();

$clientDao = new ClientDaoDB($pdo);


?>

<head>
  <title>Veículos Cadastrados</title>

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="stylesheet" href="../styles/listVehicles.css">
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->

  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>

<body>
  <?php require_once("../components/sidebar.php") ?>
  <header class="list-clients-header">
    <h1>VEÍCULOS CADASTRADOS</h1>
  </header>

  

  <main>
    <div class="main-content">
      
      <div class="button-box">
        <a href="dashboard.php" class="btn back-button"><i class="fa-solid fa-arrow-left"></i>Voltar</a>
        <a href="/pages/addVehicle.php" class="add-user-button">Cadastrar Veículo</a>
      </div>

      <div class="table-list">
         <?php require('../components/alertMessage.php')?>  
        <table id="listClientsVehicles" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Marca</th>
              <th>Cor</th>
              <th>Categoria</th>
              <th>Horário Saída</th>  
              <th>Cliente</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($vehicles as $vehicle): ?>
                <tr>
                  <td><?= $vehicle->getModel(); ?></td>
                  <td><?= $vehicle->getPlate(); ?></td>       
                  <td><?= $vehicle->getBrand(); ?></td>
                  <td><?= $vehicle->getColor(); ?></td>
                  <td><?= $vehicle->getCategory(); ?></td>
                  <td><?= $vehicle->getDepartureTime(); ?></td>
                  <td><?= $client = $clientDao->findByIdReturnName($vehicle->getClientId())?></td>
                  <td><?= $vehicle->getStatus()?></td>
                  <td>
                    <div class="action-buttons">
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="../pages/editVehicle.php?id=<?= $vehicle->getId()?>"><i class="fa-solid fa-pencil pencil"></i></a></button>
                      <?php 
                        if($vehicle->getStatus() === 'Ativo') { ?>
                          <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Desativar"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDelModal<?= $vehicle->getId()?>"><i class="fa-solid fa-ban trash"></i></a></button>
                        <?php } else { ?>
                          <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ativar"><a href="" data-bs-toggle="modal" data-bs-target="conf<?= $vehicle->getId()?>"><i class="fa-solid fa-power-off reactivate"></i></a></button>
                        <?php }?>
                    </div>
                  </td>
                </tr>
                
               

              <!-- Confirm delete modal-->
              <div class="modal fade" id="confirmDelModal<?= $vehicle->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="modal-body-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h5 class="modal-title" id="exampleModalLabel">Desativar este veículo?</h5>
                      </div>
                      <div class="modal-body-2">
                        <p class="p-modal-warning">Você realmente deseja desativar este veículo</p>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a href="../actions/disableVehicleAction.php?id=<?= $vehicle->getId(); ?>" class="btn btn-primary button-confirm-modal">Desativar</a>
                    </div>
                  </div>
              </div>


              <!-- Confirm active modal-->
              <div class="modal fade" id="#confirmReactModal<?= $vehicle->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                <div class="modal-dialog list-vehicles">
                  <div class="modal-content">
                    <div class="modal-header">
                      
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="modal-body-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h5 class="modal-title" id="exampleModalLabel">Reativar este veículo?</h5>
                      </div>
                      <div class="modal-body-2">
                        <p class="p-modal-warning">Você realmente deseja reativar este veículo?</p>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a href="../actions/reactivateVehicleAction.php?id=<?= $vehicle->getId(); ?>" class="btn btn-primary button-confirm-modal react">Reativar</a>
                    </div>
                  </div>
                </div>
              </div>            
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>


  
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
  <script src="../js/dataTable.js"></script>

</body>
</html>