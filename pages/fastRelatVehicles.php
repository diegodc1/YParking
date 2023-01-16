<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
require_once('../dao/VehicleDao.php');
session_start();
require_once('../components/verifyLogin.php');

date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$userSystem = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

$relat = $_GET['typeRelat'];

$vehicleDao = new VehicleDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);

$vehicles = $vehicleDao->findAll(); 
$disctctCategorys = $vehicleDao->distinctCategorys(); 

$resultsRelat = [];

if($relat == 'activeDisable') {
  $titleRelat = 'Veículos Ativos e Desativados';
  $resultsRelat = $vehicles;
} else if($relat == 'category') {
  $titleRelat = 'Veículos por Categoria';
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
              <h1> Relatório de <?= $titleRelat ?></h1>
            </div>
          </div>
          <div class="box-info-head">
            <div class="info-col-1">
              <p>Relatório de: <span>Veículos</span></p>
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
          if($relat == 'activeDisable') { 
            ?>
            <table id="listRelat" class="table" style="width:100%">
              <thead>
                <tr>
                  <th>Model</th>
                  <th>Marca</th>
                  <th>Placa</th>
                  <th>Categoria</th>  
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php              
                  foreach($resultsRelat as $vehicle): ?>
                    <tr>
                      <td><?= $vehicle->getModel(); ?></td>
                      <td><?= $vehicle->getBrand(); ?></td>       
                      <td><?= $vehicle->getPlate(); ?></td>
                      <td><?= $vehicle->getCategory()?></td>
                      <td><?= $vehicle->getStatus(); ?></td>
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
                  <td><?php echo ' ' . count($resultsRelat)?></td>  
                </tr>
              </tbody>
            </table>

          <div class="line-div-black"></div>
          <?php } else if($relat == 'category') { ?>
            <div class="graph-fast-box">
              <h5>Veículos por Categoria</h5>
              <div id="donutchart" style="width: 1000px; height: 500px;"></div>
            </div>
          <?php } ?>

   
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
  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script> google.charts.load('current', {packages: ['corechart']}); </script>


  <script type="text/javascript">
    google.charts.setOnLoadCallback(drawChartTypes);

    // Desenha o grafico na tela
    function drawChartTypes() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Quantidade de veículos por categoria'],
        <?php
        
          for($i = 0; $i < count($disctctCategorys); $i++){
            $text = $disctctCategorys[$i]; 
            $text = implode(" ", $text);
            
            $qtd = $vehicleDao->vehiclesByCategorys($text); ?>
            ['<?= $text ?>',  <?= $qtd ?>],
          <?php }
        ?>
      ]);
      var options = {
        // title: 'Veículos por categoria',
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }

  </script>
  


 
</body>



</html>