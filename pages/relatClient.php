<?php
session_start();
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/CompanyDao.php');

$clientDao = new ClientDaoDB($pdo);
$companyDao = new CompanyDaoDB($pdo);

$relatName = filter_input(INPUT_POST, 'inputRelatName');
$status = filter_input(INPUT_POST, 'inputStatus');
$type = filter_input(INPUT_POST, 'inputType');
$bussinesPlan = filter_input(INPUT_POST, 'inputBussinesPlan');
$genGraphType = filter_input(INPUT_POST, 'generateGraphType');
$genGraphBussinesPlan = filter_input(INPUT_POST, 'genGraphBussinesPlan');

date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$user = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

//Verificação se o filtro é para todos os dados ou não.
if($status == 'all') {
 $status = "client_status LIKE '%'";
} else {
 $status = "client_status LIKE '%$status%'";
}

if($type == 'all') {
 $type = " AND client_type LIKE '%'";
} else {
 $type = "AND client_type LIKE '%$type%'";
}

if($bussinesPlan == 'all') {
  $bussinesPlan = "AND client_bussines_plan LIKE '%'";
} else {
  $bussinesPlan = "AND client_bussines_plan LIKE '%$bussinesPlan%'";
}


$sql = $pdo->query("SELECT * FROM clients WHERE $status $type $bussinesPlan ORDER BY client_name");

$clients = [];

if ($sql->rowCount() > 0) {
  $data = $sql->fetchAll();

  foreach ($data as $client) {
    $u = new Client;
    $u->setId($client['client_id']);
    $u->setName($client['client_name']);
    $u->setEmail($client['client_email']);
    $u->setPhone($client['client_phone']);
    $u->setAddress($client['client_address']);
    $u->setCep($client['client_cep']);
    $u->setType($client['client_type']);
    $u->setBussinesPlan($client['client_bussines_plan']);
    $u->setDepartureTime($client['client_departure_time']);
    $u->setCompanyId($client['client_company_id']);
    $u->setStatus($client['client_status']);

    $clients[] = $u;
  }
}


// Faz a busca de todos os tipos de clientes do estacionamento.
$sql = $pdo->query("SELECT DISTINCT client_type FROM clients WHERE $status $type $bussinesPlan");
$distTypes = $sql->fetchAll(PDO::FETCH_ASSOC);


// Soma a partir dos filtros, quantos clientes há em cada cargo.
function getSumDistTypes($type, $pdo, $status, $bussinesPlan) {
  $sql = $pdo->query("SELECT count(client_type) as qtd FROM clients WHERE $status $bussinesPlan AND client_type = '$type'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}


// Faz a busca de todos os cargos do estacionamento.
$sql = $pdo->query("SELECT DISTINCT client_bussines_plan FROM clients WHERE $status $type $bussinesPlan");
$distBussinesPlan = $sql->fetchAll(PDO::FETCH_ASSOC);


// Soma a partir dos filtros, quantos funcionários há em cada cargo.
function getSumDistBussinessPlan($bussinesPlan, $pdo, $status, $type) {
  $sql = $pdo->query("SELECT count(client_bussines_plan) as qtd FROM clients WHERE $status $type AND client_bussines_plan  = '$bussinesPlan'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

      <div class="content-relat" id="content-relat">
        <div class="header-relat">
          <div class="header-relat-title">
            <img src="../assets/imgs/logo.png" alt="Logo YParking" class="img-logo">
            <div class="title-relat">
              <h1><?= $relatName ?></h1>
            </div>
          </div>
          <div class="box-info-head">
            <div class="info-col-1">
              <p>Relatório de: <span>Clientes</span></p>
              <p>Data de Emissão: <span><?= $date ?></span></p>
              <p>Horário de Emissão: <span><?= $time ?></span></p>
            </div>

            <div class="info-col-2">
              <p>Emitido por: <span><?= $user ?></span></p>
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
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Horário Saída</th>  
                <th>Convênio</th>0
                <th>Empresa</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              
                foreach($clients as $client): 
                  if($client->getCompanyId()) {
                    $company = $companyDao->findById($client->getCompanyId()); 
                    $companyName = $company->getName();
                  } else {
                    $companyName = '-';
                  }

                  if($client->getDepartureTime()) {
                    $dpTime = $client->getDepartureTime();
                  } else {
                    $dpTime = '-';
                  }
                ?>
                  <tr>
                    <td><?= $client->getName(); ?></td>
                    <td><?= $client->getEmail(); ?></td>       

                    <td><?= $client->getType(); ?></td>
                    <td><?= $dpTime ?></td>
                    <td><?= $client->getBussinesPlan(); ?></td>
                    <td><?= $companyName ?></td>
                    <td><?= $client->getStatus()?></td>
                  </tr>
                <?php endforeach ?>
            </tbody>
          </table>

          <div class="line-div two"></div>
           <?php 
            if((count($distTypes) > 0  && $genGraphType == 'Sim') || (count($distBussinesPlan) > 0 && $genGraphBussinesPlan == 'Sim')): ?>
              <h3 class="title-graph">Gráfico</h3>
              <div class="graphs-box">
                <?php if(count($distTypes) > 0  && $genGraphType == 'Sim'): ?>
                  <div id="donutchart" style="width: 500px; height: 300px;"></div>
                 <?php endif ?>

                 <?php if(count($distBussinesPlan) > 0 && $genGraphBussinesPlan == 'Sim'): ?>
                  <div id="bussinePlanGraph" style="width: 500px; height: 300px;"></div>           
                 <?php endif ?>
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script> google.charts.load('current', {packages: ['corechart']}); </script>


  <script type="text/javascript">
    google.charts.setOnLoadCallback(drawChartTypes);
    google.charts.setOnLoadCallback(drawChartBussinesPlan);

    // Desenha o grafico na tela
    function drawChartTypes() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Quantidade de funcionários por cargo'],
        <?php
        
          for($i = 0; $i < count($distTypes); $i++){
            $text = $distTypes[$i]; 
            $text = implode(" ", $text);
            
            $qtd = getSumDistTypes($text, $pdo, $status, $bussinesPlan); ?>
            ['<?= $text ?>',  <?= $qtd ?>],
          <?php }
        ?>
      ]);
      var options = {
        title: 'Clientes por tipo de cadastro',
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }


    function drawChartBussinesPlan() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Clientes Conveniados de Empresas'],
        <?php
        
          for($i = 0; $i < count($distBussinesPlan); $i++){
            $text = $distBussinesPlan[$i]; 
            $text = implode(" ", $text);
            
            $qtd = getSumDistBussinessPlan($text, $pdo, $status, $type); ?>
            ['<?= $text ?>',  <?= $qtd ?>],
          <?php }
        ?>
      ]);
      var options = {
        title: 'Clientes conveniados ou não',
        pieHole: 0.4,
        colors: ['#2ed47a', '#ECEF5B']
      };

      var chart = new google.visualization.PieChart(document.getElementById('bussinePlanGraph'));
      chart.draw(data, options);
    }
  </script>
  
 
</body>



</html>