<?php
session_start();
require_once('../db/config.php');
require_once('../dao/VehicleDao.php');
require_once('../dao/UsuarioDao.php');

$vehicleDao = new VehicleDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);


$relatName = filter_input(INPUT_POST, 'inputRelatName');
$status = filter_input(INPUT_POST, 'inputStatus');
$function = filter_input(INPUT_POST, 'inputFunction');
$levelAccess = filter_input(INPUT_POST, 'inputAccessLevel');


date_default_timezone_set('America/Sao_Paulo');
$time = date('H:i:s');
$date = date("d/m/Y");

$user = $_SESSION['user_name'];
$funcUser = $_SESSION['user_function'];

//Verificação se o filtro é para todos os dados ou não.
if($status == 'all') {
 $status = 'ti';
} else {
  $status = '%'.$status.'%';
}

if($function === 'all') {
  $function = '%';
} else {
  $function = '%'.$function.'%';
}

if($levelAccess === 'all') {
  $levelAccess = '%';
}

// echo $function . '<br>';
// echo $levelAccess . '<br>';

// if($function != 'all' && $levelAccess != 'all') {
//   $sql = $pdo->query("SELECT * FROM users WHERE user_status LIKE '%$status%' AND user_function LIKE '%$function%' AND user_access LIKE '$levelAccess'");
// } else {
//   if($function === 'all') {
//     $function = '%';
//   }
//   if($levelAccess === 'all') {
//     $levelAccess = '%';
//   }
//   $sql = $pdo->query("SELECT * FROM users WHERE user_status LIKE '$status'");

// }

$sql = $pdo->query("SELECT * FROM users WHERE user_function LIKE '$function' AND user_status LIKE '$status'");

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
              <p>Relatório de: <span>Usuários</span></p>
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
                <th>Cargo</th>
                <th>Nivel de Acesso</th>  
                <th>Status</th>0
              </tr>
            </thead>
            <tbody>
              <?php 
               echo $status . '<br>';
                  echo $function . '<br>';
                  echo $levelAccess . '<br>';
                foreach($users as $user): 
                 
                ?>
                  <tr>
                    <td><?= $user->getName(); ?></td>
                    <td><?= $user->getEmail(); ?></td>       
                    <td><?= $user->getFunction(); ?></td>
                    <td><?= $user->getAccess(); ?></td>
                    <td><?= $user->getStatus(); ?></td>
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