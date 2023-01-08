<?php
session_start();
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
require_once('../dao/UsuarioDao.php');
require_once('../dao/CheckinDao.php');
require_once('../dao/CheckoutDao.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/SectionDao.php');

$companyDao = new CompanyDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);
$checkinDao = new CheckinDaoDB($pdo);
$checkoutDao = new CheckoutDaoDB($pdo);
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
$genGraphSection = filter_input(INPUT_POST, 'genGraphSection');
$genGraphCkoutPerDay = filter_input(INPUT_POST, 'genGraphCkoutPerDay');


date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$userSystem = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

//Verificação se o filtro é para todos os dados ou não.
if($status == 'all') {
 $status = "ckout_status LIKE '%o%'";
} else {
 $status = "ckout_status LIKE '%$status%'";
}

if($sectionId == 'all') {
  $section = "";
} else {
  $section = "AND ckout_section_id = $sectionId";
}

if($userId == 'all') {
  $user = "";
} else {
  $user = "AND ckout_user_id = $userId";
}

$valueInitial = number_format($valueInitial, 2, ',', '.');
$valueFinal = number_format($valueFinal, 2, ',', '.');

$sql = $pdo->query("SELECT * FROM checkout WHERE $status $section $user AND ckout_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckout_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckout_total_value BETWEEN '$valueInitial' AND '$valueFinal' ORDER BY ckout_date ASC, ckout_time DESC");

$checkouts = [];

if ($sql->rowCount() > 0) {
  $data = $sql->fetchAll();

  foreach ($data as $checkout) {
    $u = new Checkout;
    $u->setId($checkout['ckout_id']);
    $u->setVehicleId($checkout['ckout_vehicle_id']);
    $u->setClientId($checkout['ckout_client_id']);
    $u->setSectionId($checkout['ckout_section_id']);
    $u->setTime($checkout['ckout_time']);
    $u->setDate($checkout['ckout_date']);
    $u->setUserId($checkout['ckout_user_id']);
    $u->setStatus($checkout['ckout_status']);
    $u->setCancelReason($checkout['ckout_cancel_reason']);
    $u->setCancelUser($checkout['ckout_cancel_user']);
    $u->setTotalValue($checkout['ckout_total_value']);
    $u->setCkinId($checkout['ckout_ckin_id']);

    $checkouts[] = $u;
  }
}

// ========== Dados para os gráficos =============

// Faz a busca de todos as seções do estacionamento.
$sql = $pdo->query("SELECT DISTINCT ckout_section_id FROM checkout WHERE $status $section $user AND ckout_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckout_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckout_total_value BETWEEN '$valueInitial' AND '$valueFinal' ORDER BY ckout_section_id");
$distSections = $sql->fetchAll(PDO::FETCH_ASSOC);

// Soma a quantidade de checkouts realizados em cada seção
function getSumDistSections($section, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal) {
  $sql = $pdo->query("SELECT count(ckout_section_id) as qtd FROM checkout WHERE $status $user AND ckout_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckout_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckout_total_value BETWEEN '$valueInitial' AND '$valueFinal' AND ckout_section_id = $section");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}



// Faz a busca de todos os dias diferentes
$sql = $pdo->query("SELECT DISTINCT ckout_date FROM checkout WHERE $status $section $user AND ckout_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckout_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckout_total_value BETWEEN '$valueInitial' AND '$valueFinal' ORDER BY ckout_date");
$distDates = $sql->fetchAll(PDO::FETCH_ASSOC);

// Soma a quantidade de checkouts realizados em cada dia.
function getSumCkoutPerDay($date, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal) {
  $sql = $pdo->query("SELECT count(ckout_date) as qtd FROM checkout WHERE $status $user AND ckout_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckout_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckout_total_value BETWEEN '$valueInitial' AND '$valueFinal' AND ckout_date = '$date'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}


// Soma a quantidade de checkouts realizados em cada dia.
function getSumValueCkoutPerDay($date, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal) {
  $sql = $pdo->query("SELECT sum(ckout_total_value) as value FROM checkout WHERE $status $user AND ckout_date BETWEEN '$dateInicial' AND '$dateFinal' AND ckout_time BETWEEN time '$timeInitial' AND time '$timeFinal' AND ckout_total_value BETWEEN '$valueInitial' AND '$valueFinal' AND ckout_date = '$date'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['value'];
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

  
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script> google.charts.load('current', {packages: ['corechart']}); </script>
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
              <p>Relatório de: <span>Checkouts</span></p>
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
                <th>Data Checkin</th>  
                <th>Horário Checkin</th>  
                <th>Valor</th>  
                <th>Usuário</th>  
                <th>Status</th>  
                <th>Motivo Cancel.</th>  
                <th>Cancel. por</th>  
              </tr>
            </thead>
            <tbody>
              <?php      
              // print_r($distDates);
                for($i = 0; $i < count($distDates); $i++){
                  $text = $distDates[$i]; 
                  $text = implode(" ", $text);
                  $qtd = getSumValueCkoutPerDay($text, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal); 
                  $qtd = substr($qtd, 2, 7);
                  // echo $qtd;

                  $qtd = floatval($qtd);
                  $qtd = number_format($qtd, 2, ',', '.');
    

                  // echo $qtd;
                  // echo gettype($qtd);
                  $text = date('d/m/Y', strtotime($text));
                  $text = substr($text, 0, 5);
                  
                  // echo $text .'<- data '.' valor -> ' . $qtd?>;
                <?php } 


              $totalValueCkout = 0;
              echo $totalValueCkout;
                foreach($checkouts as $checkout): 
                  $vehicleCkout = $vehicleDao->findById($checkout->getVehicleId());
                  $clientCkout = $clientDao->findById($checkout->getClientId());
                  $sectionCkout = $sectionDao->findById($checkout->getSectionId());
                  $usuarioCkout = $usuarioDao->findById($checkout->getUserId());
                  $checkinCkout = $checkinDao->findById($checkout->getCkinId());
                  if($checkout->getCancelUser()) {
                    $userCkout = $usuarioDao->findById($checkout->getCancelUser()); 
                    $userNameCkout = $userCkout->getName();
                  } else {
                    $userNameCkout = '-';
                  }

                  $price = substr($checkout->getTotalValue(), 2, 4);
                  $price =floatval($price);
                  // $price = number_format($price, 2, ',', '.');
                  $price =floatval($price);

                  $totalValueCkout = floatval($totalValueCkout);
                  $totalValueCkout = $totalValueCkout + $price;

                  $totalValueCkout = number_format($totalValueCkout, 2, ',', '.');
                ?>
                  <tr>
                    <td><?= $vehicleCkout->getModel(); ?></td>
                    <td><?= $vehicleCkout->getPlate(); ?></td>
                    <td><?= $clientCkout->getName(); ?></td>       
                    <td><?= $sectionCkout->getName(); ?></td>
                    <td><?= date('d/m/Y', strtotime($checkout->getDate())); ?></td>
                    <td><?= $checkout->getTime()?></td>
                    <td><?= date('d/m/Y', strtotime($checkinCkout->getDate())); ?></td>
                    <td><?= $checkinCkout->getTime()?></td>
                    <td><?= $checkout->getTotalValue()?></td>
                    <td><?= $usuarioCkout->getName(); ?></td>
                    <td><?= $checkout->getStatus(); ?></td>
                    <td><?= $checkout->getCancelReason(); ?></td>
                    <td><?= $userNameCkout ?></td>
                  </tr>
                    <?php endforeach ?>
                  </tbody>
                  <tfoot> 
                    <tr>
                      <td class="total-value">Valor Total:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="total-value">R$ <?= $totalValueCkout ?></td>
                    </tr>
                  </tfoot>    
          </table>

          <div class="line-div two"></div>


          <h3 class="title-graph">Gráficos</h3>


           <div class="graph1-box">
              <?php if($genGraphSection == 'Sim'): ?>
                <div class="graph-1">
                  <h4>Checkouts por seção</h4>
                  <div id="donutchart" style="width: 500px; height: 300px;"></div>
                </div>
              <?php endif ?>
               
            </div>

            <div class="line-div two"></div>
            
            <?php if($genGraphCkoutPerDay == 'Sim'): ?>
                <div class="graph2">
                  <h4>Checkouts por data</h4>
                  <div id="columnchart_values" style="width: 1000px"></div>
                </div>
            <?php endif ?>

            <div class="line-div two"></div>

            <?php if($genGraphCkoutPerDay == 'Sim'): ?>
                <div class="graph2">
                  <h4>Valor total por dia</h4>
                  <div id="totalValuePerDay" style="width: 1000px"></div>
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

  <script type="text/javascript">
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawCheckoutPerDay);
    google.charts.setOnLoadCallback(drawTotalValuePerDay);

//======================= GRAFICO DE CHECKINS POR SEÇÃO ==================================== 
    // Desenha o grafico na tela
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Checkouts por seção'],
        <?php
          for($i = 0; $i < count($distSections); $i++){
            $text = $distSections[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumDistSections($text, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal); 
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



//======================= GRAFICO DE CHECKOUT POR DIA ==================================== 
    function drawCheckoutPerDay() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Checkins", { role: "style" } ],
         <?php
          for($i = 0; $i < count($distDates); $i++){
            $text = $distDates[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumCkoutPerDay($text, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal); 
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


    //======================= GRAFICO DE VALOR POR DIA ==================================== 
    function drawTotalValuePerDay() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Valor Total", { role: "style" } ],
         <?php
          for($i = 0; $i < count($distDates); $i++){
            $text = $distDates[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumValueCkoutPerDay($text, $pdo, $status, $user, $dateInicial, $dateFinal, $timeInitial, $timeFinal, $valueInitial, $valueFinal); 
            $qtd = substr($qtd, 2, 7);
            $qtd = floatval($qtd);
            // $qtd = number_format($qtd, 2, ',', '.');
    
            $text = date('d/m/Y', strtotime($text));
            $text = substr($text, 0, 5);

            ?>
            ["<?=$text ?>", <?=$qtd ?>, "color: #DC3912"],
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
      var chart = new google.visualization.ColumnChart(document.getElementById("totalValuePerDay"));
      chart.draw(view, options);
    };
  </script>
</body>
</html>