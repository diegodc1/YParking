<?php 
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/SectionDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/CheckoutDao.php');
session_start();
require_once('../components/verifyLogin.php');


$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$sectionDao = new SectionDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$checkoutDao = new CheckoutDaoDB($pdo);
$vehicle = [];

$plate = trim(filter_input(INPUT_POST, 'vehicle-plate'));
$vehiclePlate = preg_replace('/[-\@\.\;\" "]+/', '', $plate);

if($vehiclePlate) {
  $vehicle = $vehicleDao->findByPlate($vehiclePlate);

  if($vehicle != false){
    $clientId = $vehicle->getClientId();
    $client = $clientDao->findById($clientId);
    $vehiclePlate = '';
  } else {
    header("Location: ../components/noFindPlate.php");
  }
  
} 

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y/m/d");


$sections = $sectionDao->findAll();
$checkinsToday = $checkinDao->findAllDaily($date);
$checkinsActive = $checkinDao->findAllCheckinActive();
$lastCheckouts = $checkoutDao->findAll();
$allCheckins = $checkinDao->findAll();

?>
<head>

  <title>Entrada e Saída de Veículos</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="../js/tooltip.js"></script>
  <script src="../js/dataTable.js"></script>
  <script src="../js/tooltip.js"></script>

  <!-- Style -->
  <link rel="stylesheet" href="../stylesstyle.css">
  <link rel="stylesheet" href="../styles/checkIn.css">


</head>

<body class="body-checkin">
  <?php require_once('../components/sidebar.php') ;
  
    if(isset($_SESSION['showModalCkout']) && ($_SESSION['showModalCkout']) === 'true') {
      echo "<script>
              $(document).ready(() => {
                $('#totalValueModal').addClass('open');
              })
              document.querySelector('#totalValueModal').classList.add('open');
              console.log(document.querySelector('#totalValueModal'));
            </script>";
    } 

    unset($_SESSION['showModalCkout']);
  ?>

  

  <header class="checkin-header">
    <h1>REALIZAR ENTRADA E SAÍDA DE VEÍCULO</h1>
  </header>

  <main>
  
    <div class="box-left">
      <!------------------------- CHECK-IN ---------------------------------->
      <div class="checkin-box">
        <div class="header-box">
          <h2>ENTRADA DE VEÍCULO</h2>
        </div>
        <div class="line"></div>
        <div class="search-box">
          <form action="../pages/checkIn.php" method="POST">
            <input type="text" class="input-search" name="vehicle-plate" placeholder="Digite a placa do veículo" value="">
            <input type="submit" class="search-button" value="Pesquisar"></input>
          </form>
        </div>
        <table id="" class="table">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Cor</th>
              <th>Categoria</th>
              <th>Cliente</th>
              <th>Check-in</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php if($vehicle){echo $vehicle->getModel();} else {echo '  ';};?></td>
              <td><?php if($vehicle){echo $vehicle->getPlate();}else {echo '  ';};?></td>
              <td><?php if($vehicle){echo $vehicle->getColor();} else {echo '  ';};?></td>
              <td><?php if($vehicle){echo $vehicle->getCategory();} else {echo '  ';};?></td>
              <td><?php if($vehicle){echo $client->getName();} else {echo '  ';};?></td>
              <td>
                <?php if($vehicle) { ?>
                  <a href="" data-bs-toggle="modal" data-bs-target="#checkinModal<?= $vehicle->getId()?>" class="checkin-button"><i class="fa-solid fa-circle-up"></i></a>
                <?php } ?>
              </td>
            </tr>
            <tr>
          </tbody>
        </table>
        <?php require('../components/alertMessage.php')?>
      </div>

      <!------------------------ CHECK-IN HISTORIC ---------------------------->
      <div class="checkin-historic-box">
        <div class="header box2">
          <h2>HISTÓRICO DE ENTRADAS</h2>
          <?php if($_SESSION['user_access'] == 1) { ?>
              <a type="" class="delete-checkin-button" data-bs-toggle="modal" data-bs-target="#cancelModal"> Cancelar um check-in </a>
          <?php } else { ?>
              <a href="#" class="delete-checkin-button" style="pointer-events: none; opacity: 0.5;">Cancelar</a>
          <?php }?>
        </div>

        <div class="line"></div>
        <div class="table-list">
          <table id="checkin" class="table" style="width:100%">
            <thead>
              <tr>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Cliente</th>
                <th>Seção</th>
                <th>Data</th>
                <th>Horár. Entrada</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach($allCheckins as $checkin) { 
                    $vehicleCheckin = $vehicleDao->findById($checkin->getVehicleId());
                    $clientCheckin = $clientDao->findById($checkin->getClientId());
                    $section = $sectionDao->findById($checkin->getSectionId());
                    $dateAllCkin = $checkin->getDate();
                  ?>               
                  <tr>
                    <td><?= $vehicleCheckin->getModel()?></td>
                    <td><?= $vehicleCheckin->getPlate()?></td>
                    <td><?= $clientCheckin->getName()?></td>
                    <td><?= $section->getName()?></td>
                    <td><?= date('d/m/Y', strtotime($dateAllCkin))?></td>
                    <td><?= substr($checkin->getTime(), 0, 5)?></td>
                    <td><?= $checkin->getStatus()?></td>
                  </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <!---------------------- CHECK-OUT  ---------------------------->
    <div class="box-right">
      <div class="checkout-box">
        <div class="header-box checkout-box">
          <h2>SAÍDA DE VEÍCULO</h2>
          <?php if($_SESSION['user_access'] == 1) { ?>
              <a type="" class="delete-checkin-button" data-bs-toggle="modal" data-bs-target="#cancelCkOutModal"> Chekouts Realizados </a>
          <?php } else { ?>
              <a href="#" class="delete-checkin-button" style="pointer-events: none; opacity: 0.5;">Cancelar</a>
          <?php }?>
        </div>
        <div class="line"></div>
        <table id="listCheckoutVehicles" class="table">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Cor</th>
              <th>Cliente</th>
              <th>Seção</th>
              <th class="td-prepare">Data Entr.</th>
              <th class="td-prepare">Ações</th></th>
            </tr>
          </thead>
          <tbody>

          <?php
            foreach($checkinsActive as $active) {
              $vehicleIdCk =  $active->getVehicleId();
              $vehicleCk = $vehicleDao->findById($vehicleIdCk);
              $clientCk = $clientDao->findById($vehicleCk->getClientId());
              $sectionck = $sectionDao->findById($active->getSectionId());
              $dateCkin = $active->getDate();
              ?>        
              <tr>
                <td><?= $vehicleCk->getModel()?></td>
                <td><?= $vehicleCk->getPlate()?></td>
                <td><?= $vehicleCk->getColor()?></td>
                <td class="td-cliente"><?= $clientCk->getName()?></td>
                <?php if($active->getStatus() == 'Aguardando Saída') { ?>
                    <td class="td-section">Saída</td>
                  <?php } else { ?>
                    <td class="td-section"><?= $sectionck->getName()?></td>
                <?php } ?>
                <td class="td-date"><?= date('d/m/Y', strtotime($dateCkin))?></td>

                <td class="action-buttons">
                  <?php if($active->getStatus() == 'Aguardando Saída'){ ?>
                      <button data-bs-toggle="tooltip" data-bs-placement="right" title="Preparar Saída" disabled class="disable-icon"><i class="fa-regular fa-hourglass-half "></i></button>
                  <?php } else { ?>
                      <button data-bs-toggle="tooltip" data-bs-placement="right" title="Preparar Saída"><a href="" data-bs-toggle="modal" data-bs-target="#prepareOutModal<?= $vehicleCk->getId()?>" class="checkout-button td-prepare"><i class="fa-regular fa-hourglass-half"></i></a></button>
                  <?php } ?>
                  <button data-bs-toggle="tooltip" data-bs-placement="right" title="Check-out"><a href="" data-bs-toggle="modal" data-bs-target="#checkoutModal<?= $vehicleCk->getId()?>" class="checkout-button"><img src="../assets/imgs/icon-checkout.png" alt="" class="checkout-img"></a></button>       
                </td>

               
                
              </tr>

               <!------------------------- Ckeck-out modal-------------------------->
              <div class="modal fade" id="checkoutModal<?= $vehicleCk->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                  <div class="modal-content checkout">

                    <div class="modal-header checkout">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="modal-body-1">
                        <img src="../assets/imgs/icon-checkout.png" alt="" class="checkout-img modal-ck">
                        <h5 class="modal-title" id="exampleModalLabel">Realizar check-out deste veículo?</h5>
                      </div>

                      <div class="modal-body-2">
                        <section class="info-vehicle-checkout">
                            <div class="info-col-1">
                              <p>Modelo: <a><?= $vehicleCk->getModel()?></a></p>
                              <p>Categoria: <a><?= $vehicleCk->getCategory()?></a></p>
                              <p>Cor: <a><?= $vehicleCk->getColor()?></a></p>
                            </div>
                            <div class="info-col-2">
                              <p>Placa: <a><?= $vehicleCk->getPlate()?></a></p>                              
                              <p>Cliente: <a><?= $clientCk->getName()?></a></p>
                            </div>
                        </section>
                      </div>
                    </div>

                    <div class="modal-footer ckout">
                      <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a href="../actions/checkoutAction.php?vehicle=<?=$vehicleCk->getId() ?>&section=<?= $active->getSectionId();?>&ckin=<?= $active->getId()?>&page=checkin" class="btn btn-secondary btn-confirm-checkout" >Confirmar</a>
                    </div>

                  </div>
                </div>
              </div>

               <!------------------------- Prepare Out-------------------------->
              <div class="modal fade" id="prepareOutModal<?= $vehicleCk->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                  <div class="modal-content checkout">

                    <div class="modal-header checkout">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="modal-body-1">
                        <i class="fa-regular fa-hourglass-half"></i>
                        <h5 class="modal-title" id="exampleModalLabel">Preparar para Saída?</h5>
                        <p>O veículo deve ser posicionado na seção de Saída!</p>
                      </div>

                      <div class="modal-body-2">
                        <section class="info-vehicle-checkout">
                            <div class="info-col-1">
                              <p>Modelo: <a><?= $vehicleCk->getModel()?></a></p>
                              <p>Categoria: <a><?= $vehicleCk->getCategory()?></a></p>
                              <p>Cor: <a><?= $vehicleCk->getColor()?></a></p>
                            </div>
                            <div class="info-col-2">
                              <p>Placa: <a><?= $vehicleCk->getPlate()?></a></p>                              
                              <p>Cliente: <a><?= $clientCk->getName()?></a></p>
                            </div>
                        </section>
                      </div>
                    </div>

                    <div class="modal-footer ckout">
                      <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a href="../actions/prepareOutAction.php?vehicle=<?=$vehicleCk->getId() ?>&section=<?= $active->getSectionId();?>&ckin=<?= $active->getId()?>&page=checkin" class="btn btn-secondary btn-confirm-checkout" >Confirmar</a>
                    </div>

                  </div>
                </div>
              </div>
           <?php } ?>    
           <script></script>        
          </tbody>
        </table>
        
      </div>
      
    </div>
  </main>

  

  <!----------------------- Cancel check-in modal --------------------------->
  <div class="modal fade" id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content cancelCheckin">

        <div class="modal-header cancelCheckin">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        

        <div class="modal-body">
            <h5 class="modal-title" id="exampleModalLabel">Cancelar Check-in</h5>
            <div class="table-list">
              <table id="checkinCancel" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th class="col-4-table">Modelo</th>
                    <th class="col-4-table">Placa</th>
                    <th class="col-4-table">Cor</th>
                    <th class="col-4-table">Cliente</th>
                    <th class="col-4-table">Horár. Entrada</th>
                    <th class="col-4-table">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    foreach($checkinsToday as $checkin) { 
                        $vehicleCheckin = $vehicleDao->findById($checkin->getVehicleId());
                        $clientCheckin = $clientDao->findById($checkin->getClientId());
                        $sectionCheckin= $sectionDao->findById($checkin->getSectionId());
                      ?>
                    
                      <tr>
                        <td><?= $vehicleCheckin->getModel()?></td>
                        <td><?= $vehicleCheckin->getPlate()?></td>
                        <td><?= $vehicleCheckin->getColor()?></td>
                        <td><?= $clientCheckin->getName()?></td>
                        <td><?= substr($checkin->getTime(), 0, 5)?></td>
                        <td>  
                        <?php if($checkin->getStatus() == 'Cancelado' || $checkin->getStatus() == 'Finalizado') { ?>
                          <a href="" class="delete-checkin-button" style="pointer-events: none; opacity: 0.5;"> Cancelar</a>
                        <?php } else { ?>
                          <a href="" class="delete-checkin-button" data-bs-toggle="modal" data-bs-target="#confirmCancelCheckin<?= $checkin->getId(); ?>"> Cancelar</a>
                        <?php } ?>
                        </td>
                      </tr>


                       <div class="modal fade" id="confirmCancelCheckin<?= $checkin->getId(); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content cancelCheckin">

                            <div class="modal-header cancelCheckin">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-header">
                                  <i class="fa-solid fa-circle-xmark"></i>
                                  <h5 class="modal-title" id="exampleModalLabel">Cancelar Check-in</h5>
                                </div>
                                <div class="table-list">
                                  <section class="info-checkin-cancel">
                                      <div class="info-col-1">
                                        <?php $date = $checkin->getDate();
                                              $userCancelId = $_SESSION['user_id'];
                                        ;?>
                                        <p>Veículo: <a><?= $vehicleCheckin->getModel();?></a></p>
                                        <p>Cliente: <a><?= $clientCheckin->getName()?></a></p>
                                        <p>Data: <a><?= date('d/m/Y', strtotime($date)) ?></a></p> 
                                      </div>
                                      <div class="info-col-2">
                                        <p>Placa: <a><?= $vehicleCheckin->getPlate()?></a></p>  
                                        <p>Seção: <a><?= $sectionCheckin->getName()?></a></p>                            
                                        <p>Horário: <a><?= $checkin->getTime()?></a></p>                                                            
                                      </div>
                                  </section>
                                </div>

                                <div class="cancel-reason-box">
                                  <h5>Informe o motivo do cancelamento:</h5>
                                  <form action="../actions/cancelCheckinAction.php?checkinid=<?= $checkin->getId(); ?>&userId=<?=$userCancelId?>" method="POST">
                                    <textarea name="cancelReasonInput" id="cancelReasonInput" cols="50" rows="4" style="resize: none" required></textarea>

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                      <input type="submit" class="delete-checkin-button" value="Confirmar">                                  
                                    </div>
                                  </form>
                                </div>
                            </div>                      
                          </div>
                        </div>
                      </div>

                    <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>




  <!-- Historic Checkouts Modal --> 
  <div class="modal fade" id="cancelCkOutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content cancelCheckin">

        <div class="modal-header cancelCheckin">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        

        <div class="modal-body">
            <h5 class="modal-title" id="exampleModalLabel">Histórico de Check-outs</h5>
            <div class="table-list">
              <table id="checkoutCancel" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Horár. Saída</th>
                    <th></th>
        
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    foreach($lastCheckouts as $checkout) { 
                        $vehicleCheckout = $vehicleDao->findById($checkout->getVehicleId());
                        $clientCheckout = $clientDao->findById($checkout->getClientId());
                        $sectionCheckout = $sectionDao->findById($checkout->getSectionId());
                        $dateCkout = $checkout->getDate();
                      ?>
                    
                      <tr>
                        <td><?= $vehicleCheckout->getModel()?></td>
                        <td><?= $vehicleCheckout->getPlate()?></td>
                        <td><?= $clientCheckout->getName()?></td>
                        <td><?= date('d/m/Y', strtotime($dateCkout))?></td>
                        <td><?= substr($checkout->getTime(), 0, 5)?></td>
                        <td>  
                        <?php if($checkout->getStatus() == 'Cancelado') { ?>
                          <a href="" class="delete-checkin-button" style="pointer-events: none; opacity: 0.5;"> Cancelar</a>
                        <?php } else { ?>
                          <a href="" class="delete-checkin-button" data-bs-toggle="modal" data-bs-target="#confirmCancelCheckout<?= $checkout->getId(); ?>"> Cancelar</a>
                        <?php } ?>
                        </td>
                      </tr>


                       <div class="modal fade" id="confirmCancelCheckout<?= $checkout->getId(); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content cancelCheckin">

                            <div class="modal-header cancelCheckin">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-header">
                                  <i class="fa-solid fa-circle-xmark"></i>
                                  <h5 class="modal-title" id="exampleModalLabel">Cancelar Check-out</h5>
                                </div>
                                <div class="table-list">
                                  <section class="info-checkin-cancel">
                                      <div class="info-col-1">
                                        <?php $date = $checkout->getDate();
                                              $userCancelCkoutId = $_SESSION['user_id'];
                                        ;?>
                                        <p>Veículo: <a><?= $vehicleCheckout->getModel();?></a></p>
                                        <p>Cliente: <a><?= $clientCheckout->getName()?></a></p>
                                        <p>Data: <a><?= date('d/m/Y', strtotime($date)) ?></a></p> 
                                      </div>
                                      <div class="info-col-2">
                                        <p>Placa: <a><?= $vehicleCheckout->getPlate()?></a></p>  
                                        <p>Seção: <a><?= $sectionCheckout->getName()?></a></p>                            
                                        <p>Horário: <a><?= $checkout->getTime()?></a></p>                                                            
                                      </div>
                                  </section>
                                </div>

                                <div class="cancel-reason-box">
                                  <h5>Informe o motivo do cancelamento:</h5>
                                  <form action="../actions/cancelCheckoutAction.php?checkoutid=<?= $checkout->getId(); ?>&userId=<?=$userCancelCkoutId?>&ckin=<?=$checkout->getCkinId() ?>" method="POST">
                                    <textarea name="cancelCkOutReasonInput" id="cancelCkOutReasonInput" cols="50" rows="4" style="resize: none" required></textarea>

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                      <input type="submit" class="delete-checkin-button" value="Confirmar">                                  
                                    </div>
                                  </form>
                                </div>
                            </div>                      
                          </div>
                        </div>
                      </div>

                    <?php } ?>
                </tbody>
              </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>





  <!------------------------- Ckeck-in modal--------------------------->
  <div class="modal fade" id="checkinModal<?= $vehicle->getId()?>" tabindex="-1" aria-labelledby="exampleodalLabel" aria-hidden="true">
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
                    $checkinDaily = $checkinDao->returnSlotsCkeckin($section->getId());
                    $fillPorcent = round(($checkinDaily * 100) / $sectionSlots) . "%"; ?>

                    <div class="box-occu 1">

                      <div class="box-occu-header" style="background-color: <?= $section->getColor(); ?>">
                        <span><?= $section->getName(); ?></span>
                      </div>

                      <div class="line-info">
                        <p>Ocupação: <span style="color: <?= $section->getColor(); ?>"><?= $fillPorcent ?></span></p>
                        <div class="line-occupation">
                          <div class="fill-line" style="background-color: <?= $section->getColor()?>; width:<?= $fillPorcent ?>" ></div>
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





  
  


 

  

  <!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="../js/tooltip.js"></script>
  <script src="../js/dataTable.js"></script>
  <script src="../js/tooltip.js"></script> -->
 
</body>

</html>