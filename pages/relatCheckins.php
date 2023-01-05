<?php
session_start();
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
require_once('../dao/UsuarioDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/SectionDao.php');

$companyDao = new CompanyDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$vehicleDao = new VehicleDaoDB($pdo);
$sectionDao = new SectionDaoDB($pdo);


$relatName = filter_input(INPUT_POST, 'inputRelatName');
$status = filter_input(INPUT_POST, 'inputStatus');
$sectionId = filter_input(INPUT_POST, 'inputSection');
$userId= filter_input(INPUT_POST, 'inputUser');
$dateInicial= filter_input(INPUT_POST, 'inputDateInicial');
$dateFinal = filter_input(INPUT_POST, 'inputDateFinal');
$timeInitial = filter_input(INPUT_POST, 'inputTimeInicial');
$timeFinal = filter_input(INPUT_POST, 'inputTimeFinal');
$valueInitial = filter_input(INPUT_POST, 'inputValueInitial');
$valueFinal = filter_input(INPUT_POST, 'inputValueFinal');


date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$userSystem = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

//Verificação se o filtro é para todos os dados ou não.
if($status == 'all') {
 $status = "ckin_status LIKE '%o%'";
} else {
 $status = "ckin_status LIKE '%$status%'";
}

if($sectionId == 'all') {
  $section = "";
} else {
  $section = "AND ckin_section_id = $sectionId";
}

if($userId == 'all') {
  $user = "";
} else {
  $user = "AND ckin_user_id = $userId";
}


$sql = $pdo->query("SELECT * FROM checkin WHERE $status $section $user AND ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal' ORDER BY ckin_date ASC, ckin_time DESC");

$checkins = [];

if ($sql->rowCount() > 0) {
  $data = $sql->fetchAll();

  foreach ($data as $checkin) {
    $u = new Checkin;
    $u->setId($checkin['ckin_id']);
    $u->setVehicleId($checkin['ckin_vehicle_id']);
    $u->setClientId($checkin['ckin_client_id']);
    $u->setSectionId($checkin['ckin_section_id']);
    $u->setTime($checkin['ckin_time']);
    $u->setUserId($checkin['ckin_user_id']);
    $u->setStatus($checkin['ckin_status']);
    $u->setDate($checkin['ckin_date']);
    $u->setCancelReason($checkin['ckin_cancel_reason']);
    $u->setCancelUser($checkin['ckin_cancel_user']);

    $checkins[] = $u;
  }
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
</head>


<body>
  <?php require_once("../components/sidebar.php") ;?>
   

  <header class="relat-header">
    <h1>RELATÓRIO</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box">
        <a href="/pages/relatorios.php" class="btn back-button"><i class="fa-solid fa-arrow-left"></i>Voltar</a>
        <button class="btn-pdf" onclick="downloadPDF()">Download PDF</button>  
      </div>

      <div class="content-relat">
        <div class="header-relat">
          <div class="header-relat-title">
            <img src="../assets/imgs/logo.png" alt="Logo YParking" class="img-logo">
            <div class="title-relat">
              <h1><?= $relatName ?></h1>
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
          <table id="listRelat" class="table" style="width:100%">
            <thead>
              <tr>
                <th>Veiculo</th>
                <th>Placa</th>
                <th>Cliente</th>
                <th>Seção</th>
                <th>Data</th>  
                <th>Horário</th>  
                <th>Usuário</th>  
                <th>Status</th>  
                <th>Motivo Cancel.</th>  
                <th>Cancel. por</th>  
              </tr>
            </thead>
            <tbody>
              <?php              
                foreach($checkins as $checkin): 
                  $vehicleCkin = $vehicleDao->findById($checkin->getVehicleId());
                  $clientCkin = $clientDao->findById($checkin->getClientId());
                  $sectionCkin = $sectionDao->findById($checkin->getSectionId());
                  $usuarioCkin = $usuarioDao->findById($checkin->getUserId());
                  if($checkin->getCancelUser()) {
                    $userCkin = $usuarioDao->findById($checkin->getCancelUser()); 
                    $userNameCkin = $userCkin->getName();
                  } else {
                    $userNameCkin = '-';
                  }
                 
                ?>
                  <tr>
                    <td><?= $vehicleCkin->getModel(); ?></td>
                    <td><?= $vehicleCkin->getPlate(); ?></td>
                    <td><?= $clientCkin->getName(); ?></td>       
                    <td><?= $sectionCkin->getName(); ?></td>
                    <td><?= date('d/m/Y', strtotime($checkin->getDate())); ?></td>
                    <td><?= $checkin->getTime()?></td>
                    <td><?= $usuarioCkin->getName(); ?></td>
                    <td><?= $checkin->getStatus(); ?></td>
                    <td><?= $checkin->getCancelReason(); ?></td>
                    <td><?= $userNameCkin ?></td>
                   
                  </tr>
                <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/dataTable.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="../js/relatorio.js"></script>
  
 
</body>



</html>