<?php 

require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/SectionDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/MovementDao.php');
session_start();
require_once('../components/verifyLogin.php');

$vehicleDao = new VehicleDaoDB($pdo);
$sectionDao = new SectionDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$checkoutDao = new CheckoutDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$movementDao = new MovementDaoDB($pdo);

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y/m/d");

$sections = $sectionDao->findAll();
$checkinsToday = $checkinDao->findAllDaily($date);
$nextOutsCkout = $clientDao->findAllTimeAvgCkinActive();
$movements = $movementDao->findAll();
?>

<!DOCTYPE html>
<html lang="pt_br">
  

<head>
  <?php require_once('../components/headConfig.php')?>; 
  <link rel="stylesheet" href="/styles/dashboard.css">
  <title>Dashboard</title>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>


<body class="dashboard-body">
  <?php require_once('../components/sidebar.php');?>
  <header>
    <h1>DASHBOARD</h1>
  </header>

  <main>
    <div class="main-content">

      <div class="main-box1">
        <div class="box1">

          <section class="secLarge">
            <a href="../pages/checkIn.php" class="big-button">
              <div class="car-entry-button">
                <i class="fa-solid fa-arrow-turn-up"></i>
                <p>ENTRADA</p>
              </div>

              <div class="car-out-button">
                <i class="fa-solid fa-arrow-turn-down"></i>
                <p>SAÍDA</p>
              </div> 
            </a> 
          </section>
        
          <section class="section-main">
            <section class="sect1">
              <a href="/pages/addClient.php">
                <div class="buttons-section">
                  <i class="fa-solid fa-user-plus"></i>
                  <p>CADASTRAR CLIENTE</p>
                </div>
              </a>

              <a href="/pages/addVehicle.php">
                <div class="buttons-section">
                  <i class="fa-solid fa-car"></i>
                  <p>CADASTRAR VEÍCULO</p>
                </div>
              </a>
              
              
              <a href="/pages/addCompany.php">
                <div class="buttons-section">
                  <img src="../assets/imgs/icon-add-companys.png"/>
                  <p>CADASTRAR EMPRESA</p>
                </div>
              </a>
              
              <a href="/pages/addUser.php">
                <div class="buttons-section">
                  <i class="fa-solid fa-user-gear"></i>
                  <p>CADASTRAR USUÁRIO</p>
                </div>
              </a>

              <a href="/pages/relatorios.php">
                <div class="buttons-section">
                  <i class="fa-regular fa-file-lines"></i>
                  <p>RELATÓRIOS</p>
                </div>
              </a>
            
            </section>

            <section class="sect2">
            
      
              <a href="../pages/listClients.php">
                <div class="buttons-section">
                  <i class="fa-solid fa-users"></i>
                  <p>CLIENTES CADASTRADOS</p>
                </div>
              </a>
      
              <a href="../pages/listVehicles.php">
                <div class="buttons-section">
                  <img src="../assets/imgs/icon-vehicles.png"/>
                  <p>VEÍCULOS CADASTRADOS</p>
                </div>
              </a>
      
              
              <a href="/pages/listCompanys.php">
                <div class="buttons-section">
                  <i class="fa-solid fa-building-user"></i>
                  <p>EMPRESAS CONVENIADAS</p>
                </div>
              </a>
              
              <a href="/pages/listUsers.php">
                <div class="buttons-section">
                  <i class="fa-solid fa-users-gear"></i>
                  <p>USUÁRIOS CADASTRADOS</p>
                </div>
              </a>

      
            </section>
          </section>
          
        </div>
      
        <div class="box2">
          <section class="next-out">
            <h2>Próximas possíveis saídas de veículos</h2>
            <div class="line"></div>
            
            <table class="next-out-table table" id="listDashboard">
              <thead>
                <tr class="collums-list">
                  <th class="col-4-table">Carro</th>
                  <th class="col-4-table">Placa</th>
                  <th class="col-4-table">Cliente</th>
                  <th class="col-4-table">Hr. Saída</th>
                </tr>
              </thead>
              
              <tbody>
                <?php 
                  
                foreach($nextOutsCkout as $next): 
                  $nextClient = $clientDao->findById($next['client_id']);
                  $nextVehicle = $vehicleDao->findById($next['ckin_vehicle_id']); ?>
                  <tr class="item-table">
                    <td class="item1"><?= $nextVehicle->getModel()?></td>
                    <td><?= $nextVehicle->getPlate()?></td>
                    <td><?= $nextClient->getName()?></td>
                    <td class="item4"><?= substr($next['client_departure_time'], 0, 5)?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </section>

          <section class="movements">
            <h2>Histórico de Movimentações</h2>
            <div class="line"></div>
              <table class="next-out-table table" id="listDashboardMovements">
                <thead>
                  <tr class="collums-list">
                    <th class="col-4-table">Movimento</th>
                    <th class="col-4-table">Veículo</th>
                    <th class="col-4-table">Placa</th>
                    <th class="col-4-table">Cliente</th>
                    <th class="col-4-table">Horário</th>
                  </tr>
                </thead>
                
                <tbody>
                  <?php 
                    foreach($movements as $movement):
                     
                      switch($movement->getType()){
                        case 'ckin':
                          $typeMovement = 'Entrada';         
                          $vehicleMov = $vehicleDao->findById($movement->getVehicleId());
                          $clientMov = $clientDao->findById($vehicleMov->getClientId());
                          break;
                        case 'ckout':
                          $typeMovement = 'Saída';
                          $vehicleMov = $vehicleDao->findById($movement->getVehicleId());
                          $clientMov = $clientDao->findById($vehicleMov->getClientId());
                          break;
                        case 'cnclCkin':
                          $typeMovement = 'Canc. Entrad.';
                          $checkinMov = $checkinDao->findById($movement->getCkinId());
                          $vehicleMov = $vehicleDao->findById($checkinMov->getVehicleId());
                          $clientMov = $clientDao->findById($checkinMov->getClientId());
                          break;
                        case 'cnclCkout':
                          $typeMovement = 'Canc. Saída';
                          $checkoutMov = $checkoutDao->findById($movement->getCkoutId());
                          $vehicleMov = $vehicleDao->findById($checkoutMov->getVehicleId());
                          $clientMov = $clientDao->findById($checkoutMov->getClientId());
                          break;
                      }

                    ?>
                      <tr class="item-table">
                        <td class="item1"><?= $typeMovement ?></td>
                        <td><?= $vehicleMov->getModel()?></td></td>
                        <td><?= $vehicleMov->getPlate()?></td>
                        <td><?= $clientMov->getName() ?></td>
                        <td class="item4"><?= substr($movement->getTime(), 0, 5) ?></td>
                      </tr>
                    <?php endforeach?>
                </tbody>
              </table>
          </section>
        </div>
      </div>

      <div class="main-box2">
        <section class="occupation">
            <h2>Ocupação do Estacionamento</h2>
            <div class="boxes-occupation">

              <?php 
                  foreach($sections as $section) { 
                    $sectionSlots = $section->getSlots();
                    $checkinDaily = $checkinDao->returnSlotsCkeckin($section->getId());
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
                    </div>                                 
                  <?php } ?>


            </div>
          </section>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>
</body>

</html>