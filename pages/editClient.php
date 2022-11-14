<?php 
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
session_start();

$clientId = filter_input(INPUT_GET, 'id');

$clientDao = new ClientDaoDB($pdo);
$clients = $clientDao->findAll();
$vechicleDao = new VehicleDaoDB($pdo);
$vehicles = $vechicleDao->findByClientId($clientId);

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
  <?php require_once('../components/headConfig.php') ?>
  <link rel="stylesheet" href="/styles/addClient.css">
  <link rel="stylesheet" href="/styles/editClient.css">
  <title>Editar Cliente</title>
</head>


<body class="addClient-body">
  <?php 
  require_once('../components/sidebar.php');
  ?>

  <header>
    <h1>EDITAR CADASTRO DE CLIENTE</h1>
  </header>

  <main>
    <section class="client-info">
      <?php require_once('../components/alertMessage.php'); ?>
      <form action="../actions/updateClientAction.php" method="POST" class="row">
        <input type="hidden" name="inputClientId" value="<?= $client->getId(); ?>">

        <div class="form-box1">
          
          <h2>DADOS GERAIS</h2>
          <div class="line"></div>
          <div class="inputs1 row gx-3 gy-2 align-items-center">
            

            <div class="col-md-3">
              <label for="inputName" class="form-label">Nome:</label>
              <input type="text" class="form-control" name="inputName" value="<?= $client->getName() ?>">
            </div>
            <div class="col-3">
              <label for="inputEmail" class="form-label">Email:</label>
              <input type="email" class="form-control" name="inputEmail" placeholder="" value="<?= $client->getEmail() ?>">
            </div>
            <div class="col-md-3">
              <label for="inputPhoneNumber" class="form-label">Telefone:</label>
              <input type="text" class="form-control" name="inputPhoneNumber" value="<?= $client->getPhone() ?>">
            </div>
            <div class="col-3">
              <label for="inpuZip" class="form-label">CEP:</label>
              <input type="text" class="form-control" name="inputZip" placeholder="" value="<?= $client->getCep() ?>">
            </div>
            <div class="col-md-4">
              <label for="inputAddress" class="form-label">Endereço:</label>
              <input type="text" class="form-control" name="inputAddress" value="<?= $client->getAddress() ?>">
            </div>

            <div class="type-user-use col-md-3">
              <label for="inputType" class="form-label">Tipo de Uso:</label>
              <select name="inputType" name="inputType" class="form-select" require>
                <option selected value="<?= $client->getType() ?>"><?= $client->getType() ?></option>
                <option value="Horista">Horista</option>
                <option value="Mensalista">Mensalista</option>
              </select>
      
            </div>

            <div class="company-use type-user-use col-md-2">
              <label for="inputBussinesPlan" class="form-label">Convênio de Empresa?:</label>
              <select name="inputBussinesPlan" name="inputBussinesPlan" class="form-select" require>
                <option selected value="<?= $client->getBussinesPlan() ?>"><?= $client->getBussinesPlan() ?></option>
                <option value="Não">Não</option>
                <option value="Sim">Sim</option>
              </select>
            </div>

            

          </div>
        </div>

        <div class="col-12 buttons-group">
          <a href="../pages/listClients.php" class="btn btn-primary cancel-button">Cancelar</a>
          <button type="submit" class="btn btn-primary submit-button">Atualizar Dados</button>
        </div>
        
      </form>

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
                  <th class="th-delete">Excluir</th>
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
                      <td>
                    <div class="action-buttons">
                      <p></p>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDelModal<?= $vehicle->getId()?>"><i class="fa-solid fa-trash-can trash"></i></a></button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Excluir este veículo?</h5>
                          </div>
                          <div class="modal-body-2">
                            <p class="p-modal-warning"><span>Atenção!</span> Não será possível reverter essa ação!</p>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                          <a href="../actions/deleteVehicleAction.php?id=<?= $vehicle->getId(); ?>" class="btn btn-primary button-confirm-modal">Excluir</a>
                        </div>
                      </div>
                  </div>
                <?php } ?>
              </tbody>
            </table>
          </div>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>
</body>

</html>