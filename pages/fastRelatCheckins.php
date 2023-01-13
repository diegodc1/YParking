<?php
require_once('../db/config.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/SectionDao.php');
require_once('../dao/UsuarioDao.php');
session_start();
require_once('../components/verifyLogin.php');

date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");
$dateSearch = date("Y/m/d");

$userSystem = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

$relat = $_GET['typeRelat'];

$checkinDao = new CheckinDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$sectionDao = new SectionDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);
$checkis = $checkinDao->findAll();

$ckinsThisMonth = $checkinDao->findAllCheckinThisMonth($dateSearch);
$diffDaysThisMonth = $checkinDao->diffDatesThisMonth($dateSearch);
$ckinsCanceled = $checkinDao->canceledCkinsThisMonth($date);

$resultsRelat = [];
if($relat == 'month') {
  $titleRelat = 'Checkins deste mês';
  $resultsRelat = $ckinsThisMonth;
} else if ($relat == 'perDay') {
  $titleRelat = 'Checkins por dia - neste mês';
  $resultsRelat = $ckinsThisMonth;
} else if ($relat == 'canceled') {
  $titleRelat = 'Checkins Cancelados - neste mês';
  $resultsRelat = $ckinsCanceled;
}


function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>

<head>
  <title>Relatório</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/relatorioPdf.css">
  <link rel="stylesheet" href="../styles/style.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <?php require_once('../components/favicon.php') ?>;
</head>


<body>
  <?php require_once("../components/sidebar.php") ;?>
  <a href="#top" class="back-to-top"><i class="fa-solid fa-circle-up"></i></a>


  <header class="relat-header">
    <h1>RELATÓRIO</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box" id="top">
        <a href="/pages/relatorios.php" class="btn back-button"><i class="fa-solid fa-arrow-left"></i>Voltar</a>
        <button class="btn-pdf" onclick="downloadPDF()">Download PDF</button>  
      </div>

      <div class="content-relat">
        <div class="header-relat">
          <div class="header-relat-title">
            <img src="../assets/imgs/logo.png" alt="Logo YParking" class="img-logo">
            <div class="title-relat">
              <h1> Relatório de <?= $titleRelat ?></h1>
            </div>
          </div>
          <div class="box-info-head">
            <div class="info-col-1">
              <p>Relatório de: <span>Checkins</span></p>
              <p>Data de Emissão: <span><?= $date ?></span></p>
              <p>Horário de Emissão: <span><?= $time ?></span></p>
            </div>

            <div class="info-col-2">
              <p>Emitido por: <span><?= $userSystem ?></span></p>
              <p>Cargo: <span><?= $funcUser ?></span></p>
              <p>IP do usuário: <span><?= get_client_ip() ?></span></p>
            </div>
          </div>
          <div class="line-div"></div>
        </div>

        <div class="main-relat">
          <?php 
          if($relat == 'month') { 

           // Relatório de checkins no mes atual ?>
            <table id="listRelat" class="table" style="width:100%">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Horário</th>
                  <th>Veículo</th>
                  <th>Placa</th>
                  <th>Cliente</th>
                  <th>Seção</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php       
                  foreach($resultsRelat as $checkin):
                    $vehicle = $vehicleDao->findById($checkin->getVehicleId());
                    $client = $clientDao->findById($checkin->getClientId());
                    $section = $sectionDao->findById($checkin->getSectionId());
                  ?>
                    <tr>
                    
                      <td><?= date('d/m/Y', strtotime($checkin->getDate())); ?></td>
                      <td><?= $checkin->getTime(); ?></td>
                      <td><?= $vehicle->getModel(); ?></td>
                      <td><?= $vehicle->getPlate(); ?></td>
                      <td><?= $client->getName(); ?></td>
                      <td><?= $section->getName(); ?></td>
                      <td><?= $checkin->getStatus(); ?></td>
                 
                    </tr>
                  <?php endforeach ?>
              </tbody>
            </table>
          <?php } else if($relat == 'perDay') { 

              // Relatório de Checkins por dia
              for($i = 0; $i < count($diffDaysThisMonth); $i++) { 
                $text = $diffDaysThisMonth[$i]; 
                $text = implode(" ", $text);
                $ckinsPerDay = $checkinDao->findAllDaily($text);?>
                <table id="listRelat" class="table" style="width:100%">
                  <h5 class="day-title">Dia: <?=  date('d/m/Y', strtotime($text));?></h5>
                  <thead>
                    <tr>
                      <th>Data</th>
                      <th>Horário</th>
                      <th>Veículo</th>
                      <th>Placa</th>
                      <th>Cliente</th>
                      <th>Seção</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php       
                      foreach($ckinsPerDay as $checkin):
                        $vehicle = $vehicleDao->findById($checkin->getVehicleId());
                        $client = $clientDao->findById($checkin->getClientId());
                        $section = $sectionDao->findById($checkin->getSectionId()); ?>

                        <tr>
                          <td><?= date('d/m/Y', strtotime($checkin->getDate())); ?></td>
                          <td><?= $checkin->getTime(); ?></td>
                          <td><?= $vehicle->getModel(); ?></td>
                          <td><?= $vehicle->getPlate(); ?></td>
                          <td><?= $client->getName(); ?></td>
                          <td><?= $section->getName(); ?></td>
                          <td><?= $checkin->getStatus(); ?></td>
                        </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              <?php } ?>

          <?php } else if($relat == 'canceled') { ?>
              <!-- Relatório de checkins no mes atual  -->
              <table id="listRelat" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Veículo</th>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Seção</th>
                    <th>Status</th>
                    <th>Motivo Canc.</th>
                    <th>Canc. por</th>
                  </tr>
                </thead>
                <tbody>
                  <?php       
                    foreach($resultsRelat as $checkin):
                      $vehicle = $vehicleDao->findById($checkin->getVehicleId());
                      $client = $clientDao->findById($checkin->getClientId());
                      $section = $sectionDao->findById($checkin->getSectionId());
                      $user = $usuarioDao->findById($checkin->getCancelUser());
                    ?>
                      <tr>
                      
                        <td><?= date('d/m/Y', strtotime($checkin->getDate())); ?></td>
                        <td><?= $checkin->getTime(); ?></td>
                        <td><?= $vehicle->getModel(); ?></td>
                        <td><?= $vehicle->getPlate(); ?></td>
                        <td><?= $client->getName(); ?></td>
                        <td><?= $section->getName(); ?></td>
                        <td><?= $checkin->getStatus(); ?></td>
                        <td><?= $checkin->getCancelReason(); ?></td>
                        <td><?= $user->getName(); ?></td>
                  
                      </tr>
                    <?php endforeach ?>
                </tbody>
              </table>
          <?php }?>

          <div class="line-div-black"></div>


          <table class="mt-4 mb-4">
            <tbody>
              <tr>
                <td class="title-infos-relat">Total de Registros Encontrados:  </td>
                <td class="div-table-infos">=</td>
                <td><?php echo ' ' . count($resultsRelat)?></td>  
              </tr>
            </tbody>
          </table>

          <div class="line-div-black"></div>
        </div>
      </div> 
<?php unset($relat);?>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/dataTable.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="../js/relatorio.js"></script>
  <script src="../js/scripts.js"></script>


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


 
</body>



</html>