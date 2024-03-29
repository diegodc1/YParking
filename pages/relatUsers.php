<?php
session_start();
require_once('../components/verifyLogin.php');
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/UsuarioDao.php');

$vehicleDao = new VehicleDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);


$relatName = filter_input(INPUT_POST, 'inputRelatName');
$status = filter_input(INPUT_POST, 'inputStatus');
$function = filter_input(INPUT_POST, 'inputFunction');
$levelAccess = filter_input(INPUT_POST, 'inputAccessLevel');
$generGrahpFunc = filter_input(INPUT_POST, 'generateGraph');


date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$userSystem = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

//Verificação se o filtro é para todos os dados ou não.
if($status == 'all') {
 $status = "user_status LIKE '%'";
 $status2 = "user_status LIKE '%'";
} else {
 $status = "user_status LIKE '%$status%'";
 $status2 = "AND user_status LIKE '%$status%'";
}

if($function == 'all') {
  $function = "AND user_function LIKE '%'";
  $function2 = "AND user_function LIKE '%'";
} else {
  $function = "AND user_function LIKE '%$function%'";
  $function2 = "AND user_function LIKE '%$function%'";
}

if($levelAccess == 'all') {
  $levelAccess = "";
  $levelAccess2 = "";
} else {
  $levelAccess = "AND user_access = $levelAccess";
  $levelAccess2 = "AND user_access = $levelAccess";
}

$sql = $pdo->query("SELECT * FROM users WHERE $status $function $levelAccess ORDER BY user_name");


$users = [];

if ($sql->rowCount() > 0) {
  $data = $sql->fetchAll();

  foreach ($data as $user) {
    $u = new Usuario;
    $u->setId($user['user_id']);
    $u->setName($user['user_name']);
    $u->setEmail($user['user_email']);
    $u->setFunction($user['user_function']);
    $u->setAccess($user['user_access']);
    $u->setStatus($user['user_status']);

    $users[] = $u;
  }
}


// Faz a busca de todos os cargos do estacionamento.
$sql = $pdo->query("SELECT DISTINCT user_function FROM users WHERE $status $function $levelAccess");
$disctFuncs = $sql->fetchAll(PDO::FETCH_ASSOC);

// Soma a partir dos filtros, quantos funcionários há em cada cargo.
function getSumDisct($function, $pdo, $status, $levelAccess) {
  $sql = $pdo->query("SELECT count(user_function) as qtd FROM users WHERE $status $levelAccess AND user_function = '$function' ");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}


// Soma a partir dos filtros, quantos funcionários há em cada cargo.
function getSumAccess($access, $function, $pdo, $status, $levelAccess) {
  $sql = $pdo->query("SELECT count(user_access) as qtd FROM users WHERE $status $function $levelAccess AND user_access = $access");
  $data = $sql->fetch(PDO::FETCH_ASSOC);

  return $data['qtd'];
}


//========= Dados para as informações totais ================
$totalAdmUsers = getSumAccess('1', $function, $pdo, $status, $levelAccess);
$totalComumUsers = getSumAccess('0', $function, $pdo, $status, $levelAccess);


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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/relatorioPdf.css">
  <link rel="stylesheet" href="../styles/style.css">
  <?php require_once('../components/favicon.php') ?>;

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script> google.charts.load('current', {packages: ['corechart']}); </script>
</head>


<body>
  <?php 
  require_once('../components/verifyAdmAccess.php');
  require_once("../components/sidebar.php");
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
              <p>Relatório de: <span>Usuários</span></p>
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
                <th>Nome</th>
                <th>Email</th>
                <th>Cargo</th>
                <th>Nivel de Acesso</th>  
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php          
                foreach($users as $user): 
                  $usuarioDao->findTotalByFunction($user->getFunction());
                  if($user->getAccess() == 0){
                    $userAccess = 'Comum';
                  } else {
                    $userAccess = 'Admin';
                  } ?>
                  <tr>
                    <td><?= $user->getName(); ?></td>
                    <td><?= $user->getEmail(); ?></td>       
                    <td><?= $user->getFunction(); ?></td>
                    <td><?= $userAccess ?></td>
                    <td><?= $user->getStatus(); ?></td>
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
                <td><?php echo ' ' . count($users)?></td>
    
                <td class="div-table-infos">================</td>
                <td></td></td>
                <td class="div-table-infos">=</td>
                <td></td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td class="title-infos-relat">Total Usuários Comum:  </td>
                <td></td>
                <td><?= $totalComumUsers ?></td>
                <td></td>
                <td class="title-infos-relat">Total Usuários Adm: </td>
                <td></td>
                <td><?= $totalAdmUsers ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
 
            </tbody>
          </table>

          <div class="line-div-black"></div>

          <?php if(count($users) > 0 && $generGrahpFunc == 'Sim'): ?>
            <h3 class="title-graph">Gráfico</h3>
            <div id="donutchart" style="width: 900px; height: 500px;"></div>
          <?php endif; ?>
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

    // Desenha o grafico na tela
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Quantidade de funcionários por cargo'],
        <?php
          for($i = 0; $i < count($disctFuncs); $i++){
            $text = $disctFuncs[$i]; 
            $text = implode(" ", $text);
            $qtd = getSumDisct($text, $pdo, $status, $levelAccess); ?>
            ['<?= $text ?>',  <?= $qtd ?>],
          <?php }
        ?>
      ]);
      var options = {
        title: 'Quantidade de funcionários por cargo',
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }
  </script>
</body>
</html>