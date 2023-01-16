<?php
session_start();
require_once('../components/verifyLogin.php');
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
$genGraphSection = filter_input(INPUT_POST, 'geGraphSection');
$genGraphCkinPerDay = filter_input(INPUT_POST, 'geGraphCkinPerDay');
$genGraphStatus = filter_input(INPUT_POST, 'geGraphStatus');


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
  $user2 = "";
} else {
  $user = "AND ckin_user_id = $userId";
  $user2 = "ckin_user_id = $userId";
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

// ============================== Dados para os gráficos ============================

// Faz a busca de todos as seções do estacionamento.
$sql = $pdo->query("SELECT DISTINCT ckin_section_id FROM checkin WHERE $status $section $user AND ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal' ORDER BY ckin_section_id");
$distSections = $sql->fetchAll(PDO::FETCH_ASSOC);

// Soma a quantidade de checkins realizados em cada seção
function getSumDistSections($section, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal) {
  $sql = $pdo->query("SELECT count(ckin_section_id) as qtd FROM checkin WHERE $status $user AND ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal'AND ckin_section_id = $section ");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}



// Faz a busca de todos os dias diferentes
$sql = $pdo->query("SELECT DISTINCT ckin_date FROM checkin WHERE $status $section $user AND ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal' ORDER BY ckin_date");
$distDates = $sql->fetchAll(PDO::FETCH_ASSOC);

// Soma a quantidade de checkins realizados em cada dia.
function getSumCkinPerDay($date, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal) {
  $sql = $pdo->query("SELECT count(ckin_date) as qtd FROM checkin WHERE $status $user AND ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckin_date = '$date'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}


// Faz a busca de todos status
$sql = $pdo->query("SELECT DISTINCT ckin_status FROM checkin WHERE $status $section $user AND ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal'");
$distStatus = $sql->fetchAll(PDO::FETCH_ASSOC);

function getSumDistStatus($status, $section, $pdo, $user2, $dateInicial, $dateFinal, $timeInitial, $timeFinal) {
  $sql = $pdo->query("SELECT count(ckin_status) as qtd FROM checkin WHERE $user2 $section ckin_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckin_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckin_status = '$status'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}

//========= Dados para as informações totais ================
$totalActiveCkin = getSumDistStatus('Ativo', $section, $pdo, $user2, $dateInicial, $dateFinal, $timeInitial, $timeFinal);
$totalFinishCkin = getSumDistStatus('Finalizado', $section, $pdo, $user2, $dateInicial, $dateFinal, $timeInitial, $timeFinal);
$totalCancelCkin = getSumDistStatus('Cancelado', $section, $pdo, $user2, $dateInicial, $dateFinal, $timeInitial, $timeFinal);

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

  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script> google.charts.load('current', {packages: ['corechart']}); </script>
</head>


<body>
  <?php 
  require_once('../components/verifyAdmAccess.php');
  require_once("../components/sidebar.php") ;
  ?>
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

          <div class="line-div-black"></div>


          <table class="mt-4 mb-4">
            <tbody>
              <tr>
                <td class="title-infos-relat">Total de Registros Encontrados:  </td>
                <td class="div-table-infos">=</td>
                <td><?php echo ' ' . count($checkins)?></td>
    
                <td class="div-table-infos">================</td>
                <td class="title-infos-relat">Total Checkins Ativos:</td>
                <td class="div-table-infos">=</td>
                <td><?= $totalActiveCkin ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td class="title-infos-relat">Total Checkins Finalizados:  </td>
                <td></td>
                <td><?= $totalFinishCkin?></td>
                <td></td>
                <td class="title-infos-relat">Total Checkins Cancelados:  </td>
                <td></td>
                <td><?= $totalCancelCkin ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
 
            </tbody>
          </table>

          <div class="line-div-black"></div>

          <h3 class="title-graph">Gráficos</h3>

          <div class="graph1-box">
              <?php if($genGraphSection == 'Sim' && count($distSections) > 0): ?>
                <div class="graph-1">
                  <h4>Checkins por seção</h4>
                  <div id="donutchart" style="width: 500px; height: 300px;"></div>
                </div>
              <?php endif ?>
               
              <?php if($genGraphStatus == 'Sim' && count($distStatus) > 0): ?>
                <div class="graph-2">
                  <h4>Checkins por status</h4>
                  <div id="graphStatus" style="width: 500px; height: 300px;"></div>
                </div>
              <?php endif ?>
          </div>

          <div class="line-div two"></div>
          
          <?php if($genGraphCkinPerDay == 'Sim' && count($distDates) > 0): ?>
             <div class="graph2">
              <h4>Checkins por data</h4>
              <div id="columnchart_values" style="width: 1000px"></div>
            </div>
          <?php endif ?>
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
  <script src="../js/scripts.js"></script>


  <script type="text/javascript">
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawCheckisPerDay);
    google.charts.setOnLoadCallback(drawCheckinStatus);

    //======================= GRAFICO DE CHECKINS POR SEÇÃO ==================================== 
    // Desenha o grafico na tela
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Checkins por seção'],
        <?php
          for($i = 0; $i < count($distSections); $i++){
            $text = $distSections[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumDistSections($text, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal); 
            $sectionCkin = $sectionDao->findById($text);
            $sectionName = $sectionCkin->getName();
            ?>
            ['<?= $sectionName ?>',  <?= $qtd ?>],
          <?php }
        ?>
      ]); 
      var options = {
        // title: 'Checkins por seção',
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }


    //======================= GRAFICO DE CHECKINS STATUS ==================================== 
    function drawCheckinStatus() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Checkins por seção'],
         <?php
          for($i = 0; $i < count($distStatus); $i++){
            $text = $distStatus[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumDistStatus($text, $section, $pdo, $user2, $dateInicial, $dateFinal, $timeInitial, $timeFinal); 
            ?>
            ["<?=$text ?>",  <?= $qtd?>],
          <?php } ?>
      ]); 
      var options = {
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('graphStatus'));
      chart.draw(data, options);
    }



    //======================= GRAFICO DE CHECKINS POR DIA ==================================== 
    function drawCheckisPerDay() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Checkins", { role: "style" } ],
         <?php
          for($i = 0; $i < count($distDates); $i++){
            $text = $distDates[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumCkinPerDay($text, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal); 
            $text = date('d/m/Y', strtotime($text));
            $text = substr($text, 0, 5);
            ?>
            ["<?=$text ?>",  <?= $qtd?>, "color: #DC3912"],
          <?php } ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        width: 900,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
    };
  </script>
</body>
</html>