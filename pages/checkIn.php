<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/SectionDao.php');
require_once('../dao/CheckinDao.php');
session_start();

$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$sectionDao = new SectionDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$vehicle = [];

$vehiclePlate = trim(filter_input(INPUT_POST, 'vehicle-plate'));

if($vehiclePlate) {
  $vehicle = $vehicleDao->findByPlate($vehiclePlate);
  $clientId = $vehicle->getClientId();
  $client = $clientDao->findById($clientId);
  $vehiclePlate = '';
} 

$sections = $sectionDao->findAll();
$checkinsToday = $checkinDao->findAllDaily();

?>
<head>

  <title>Check-in</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="../stylesstyle.css">
  <link rel="stylesheet" href="../styles/checkIn.css">

</head>

<body>
  <?php require_once('../components/sidebar.php') ?>

  <header class="checkin-header">
    <h1>ENTRADA DE VEÍCULO</h1>
  </header>

  <main>
    <div class="checkin-box">
      <div class="header-box">
        <h2>REALIZAR ENTRADA DE VEÍCULO</h2>
      </div>

      <div class="line"></div>

      <div class="search-box">
        <form action="../pages/checkIn.php" method="POST">
          <input type="text" class="input-search" name="vehicle-plate" placeholder="Digite a placa do veículo" value="">
          <input type="submit" class="search-button" value="Pesquisar"></input>
        </form>
      </div>

      <!-- Searching Vehicle Table -->
      <table id="" class="table">
        <thead>
          <tr>
            <th>Modelo</th>
            <th>Placa</th>
            <th>Cor</th>
            <th>Categoria</th>
            <th>Cliente</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php if($vehicle){echo $vehicle->getModel();} else {echo '';};?></td>
            <td><?php if($vehicle){echo $vehicle->getPlate();}else {echo '';};?></td>
            <td><?php if($vehicle){echo $vehicle->getColor();} else {echo '';};?></td>
            <td><?php if($vehicle){echo $vehicle->getCategory();} else {echo '';};?></td>
            <td><?php if($vehicle){echo $client->getName();} else {echo '';};?></td>
            <td>
              <?php if($vehicle) { ?>
                  <a href="" data-bs-toggle="modal" data-bs-target="#checkinModal<?= $vehicle->getId()?>" class="checkin-button">Realizar Entrada</a>
             <?php } ?>
            </td>
          </tr>
          <tr>
        </tbody>
      </table>
      <?php require('../components/alertMessage.php')?>

    </div>

    <div class="checkin-historic-box">
      <div class="header box2">
        <h2>HISTÓRICO DE ENTRADAS DE HOJE</h2>
      </div>

      <div class="line"></div>

      <!-- Historic Table -->
      <div class="table-list">
        <table id="checkin" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Cor</th>
              <th>Cliente</th>
              <th>Horár. Entrada</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($checkinsToday as $checkin) { 
                  $vehicleCheckin = $vehicleDao->findById($checkin->getVehicleId());
                  $clientCheckin = $clientDao->findById($checkin->getClientId());
                ?>
              
                <tr>
                  <td><?= $vehicleCheckin->getModel()?></td>
                  <td><?= $vehicleCheckin->getPlate()?></td>
                  <td><?= $vehicleCheckin->getColor()?></td>
                  <td><?= $clientCheckin->getName()?></td>
                  <td><?= substr($checkin->getTime(), 0, 5)?></td>
                  <td>
                  <?php if($_SESSION['user_access'] == 1) { ?>
                      <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
                  <?php } else { ?>
                      <a href="#" class="delete-checkin-button" style="pointer-events: none; opacity: 0.5;">Cancelar / Excluir</a>
                  <?php }?>
                  
                    
                  </td>
              </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>



      <!-- ------------------------------------ -->

    </div>
  </main>


   <!-- Ckeck-in modal-->
  <div class="modal fade" id="checkinModal<?= $vehicle->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="modal-body-1">
            <i class="fa-solid fa-square-parking"></i>
            <h5 class="modal-title" id="exampleModalLabel">Selecione uma seção para o veículo</h5>
          </div>
          <div class="modal-body-2">
            <section class="occupation">
              <div class="boxes-occupation">
                <?php 
                  foreach($sections as $section) { 
                    $sectionSlots = $section->getSlots();
                    $checkinDaily = $checkinDao->returnSlotsBySectionId($section->getId());
                    $fillPorcent = round(($checkinDaily * 100) / $sectionSlots) . "%";
                    ?>

                    <div class="box-occu 1">

                      <div class="box-occu-header" style="background-color: <?= $section->getColor(); ?>">
                        <span><?= $section->getName(); ?></span>
                      </div>

                      <div class="line-info">
                        <p>Ocupação: <span style="color: <?= $section->getColor(); ?>"><?= $fillPorcent ?></span></p>
                        <div class="line-occupation">
                          <div class="fill-line" style="background-color: <?= $section->getColor()?>; width:<?= $fillPorcent?>" ></div>
                        </div>
                      </div>

                      <?php if($fillPorcent == '100%') { ?>
                         <a href="../actions/checkinAction.php?vehicle=<?=$vehicle->getId()?>&section=<?= $section->getId(); ?>" class="select-section-button" style="pointer-events: none; opacity: 0.5">Selecionar</a> 
                      <?php } else { ?>
                        <a href="../actions/checkinAction.php?vehicle=<?=$vehicle->getId()?>&section=<?= $section->getId(); ?>" class="select-section-button">Selecionar</a>
                      <?php } ?>        
                    </div>                                 
                  <?php } ?>
              </div>
            </section>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/tooltip.js"></script>
  <script src="../js/dataTable.js"></script>

</body>

</html>