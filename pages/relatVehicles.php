<?php
session_start();
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/ClientDao.php');

$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new clientDaoDB($pdo);

$relatName = filter_input(INPUT_POST, 'inputRelatName');
$status = filter_input(INPUT_POST, 'inputStatus');
$category = filter_input(INPUT_POST, 'inputCategory');
$genGraphCategory = filter_input(INPUT_POST, 'genGraphCategory');


date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$user = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

//Verificação se o filtro é para todos os dados ou não.
if($status == 'all') {
 $status = "vehicle_status LIKE '%'";
} else {
 $status = "vehicle_status LIKE '%$status%'";
}

if($category == 'all') {
  $category = "AND vehicle_category LIKE '%'";
} else {
  $category = "AND vehicle_category LIKE '%$category%'";
}

$sql = $pdo->query("SELECT * FROM vehicles WHERE $status $category ORDER BY vehicle_model");


$vehicles = [];


if ($sql->rowCount() > 0) {
  $data = $sql->fetchAll();

  foreach ($data as $vehicle) {
    $u = new Vehicle;
    $u->setId($vehicle['vehicle_id']);
    $u->setModel($vehicle['vehicle_model']);
    $u->setPlate($vehicle['vehicle_plate']);
    $u->setColor($vehicle['vehicle_color']);
    $u->setCategory($vehicle['vehicle_category']);
    $u->setBrand($vehicle['vehicle_brand']);
    $u->setClientId($vehicle['vehicle_client_id']);
    $u->setStatus($vehicle['vehicle_status']);


    $vehicles[] = $u;
  }
}


// Faz a busca de todos os tipos de clientes do estacionamento.
$sql = $pdo->query("SELECT DISTINCT vehicle_category FROM vehicles WHERE $status $category ");
$distCategory = $sql->fetchAll(PDO::FETCH_ASSOC);


// Soma a partir dos filtros, quantos clientes há em cada cargo.
function getSumDistCategory($category, $pdo, $status) {
  $sql = $pdo->query("SELECT count(vehicle_category) as qtd FROM vehicles WHERE $status AND vehicle_category = '$category'");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
} 


// print_r($vehicles);
 
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
              <p>Relatório de: <span>Veículos</span></p>
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
                <th>Modelo</th>
                <th>Marca</th>
                <th>Placa</th>
                <th>Cor</th>  
                <th>Categoria</th>0
                <th>Cliente</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach($vehicles as $vehicle): 
                  $client = $clientDao->findById($vehicle->getClientId()); 
                  $clientName = $client->getName();
                ?>
                  <tr>
                    <td><?= $vehicle->getModel(); ?></td>
                    <td><?= $vehicle->getBrand(); ?></td>       
                    <td><?= $vehicle->getPlate(); ?></td>
                    <td><?= $vehicle->getColor(); ?></td>
                    <td><?= $vehicle->getCategory(); ?></td>
                    <td><?= $clientName ?></td>
                    <td><?= $vehicle->getStatus()?></td>
                  </tr>
                <?php endforeach ?>
            </tbody>
          </table>

          <div class="line-div two"></div>
          
          <?php if(count($distCategory) > 0 && $genGraphCategory == 'Sim'): ?>
            <h3 class="title-graph">Gráfico</h3>
            <div class="graphs-box">
                <div id="donutchart" style="width: 500px; height: 300px;"></div>
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

    // Desenha o grafico na tela
    function drawChartTypes() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Quantidade de veículos por categoria'],
        <?php
        
          for($i = 0; $i < count($distCategory); $i++){
            $text = $distCategory[$i]; 
            $text = implode(" ", $text);
            
            $qtd = getSumDistCategory($text, $pdo, $status); ?>
            ['<?= $text ?>',  <?= $qtd ?>],
          <?php }
        ?>
      ]);
      var options = {
        title: 'Veículos por categoria',
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }

  </script>
  
  
 
</body>



</html>