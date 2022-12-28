<?php
require_once('../db/config.php');
require_once('../dao/ClientDao.php');

$clientDao = new ClientDaoDB($pdo);


$relatName = filter_input(INPUT_POST, 'inputRelatName');
$status = filter_input(INPUT_POST, 'inputStatus');
$type = filter_input(INPUT_POST, 'inputType');
$bussinesPlan = filter_input(INPUT_POST, 'inputBussinesPlan');

$clients = [];

if($status == 'all' && $type == 'all' && $bussinesPlan == 'all') {
  $sql = $pdo->query("SELECT * FROM clients");
} else if($status != 'all' && $type == 'all' && $bussinesPlan == 'all') {
  $sql = $pdo->query("SELECT * FROM clients WHERE client_status == $status");
} else if($status == 'all' && $type != 'all' && $bussinesPlan == 'all') {
  $sql = $pdo->query("SELECT * FROM clients WHERE client_type == $type");
} else if($status == 'all' && $type == 'all' && $bussinesPlan != 'all') {
  $sql = $pdo->query("SELECT * FROM clients WHERE client_bussines_plan == $bussinesPlan");
} else if($status != 'all' && $type != 'all' && $bussinesPlan == 'all') {
  $sql = $pdo->query("SELECT * FROM clients WHERE client_status == $status AND client_type == $type");
} else if($status != 'all' && $type == 'all' && $bussinesPlan != 'all') {
  $sql = $pdo->query("SELECT * FROM clients WHERE client_status == $status AND client_bussines_plan == $bussinesPlan");
} else if($status == 'all' && $type != 'all' && $bussinesPlan != 'all') {
  $sql = $pdo->query("SELECT * FROM clients WHERE client_type == $type AND client_bussines_plan == $bussinesPlan");
}

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
 


session_start();

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

      <div class="content-relat" id="content-relat">
        <div class="header-relat">
          <div class="header-relat-title">
            <img src="../assets/imgs/logo.png" alt="Logo YParking" class="img-logo">
            <h1><?= $relatName?></h1>
            
          </div>
          <div class="box-info-head">
            <div class="info-col-1">
              <p>Relatório de: <span>Clientes</span></p>
              <p>Data de Emissão: <span>28/12/2022</span></p>
              <p>Horário de Emissão: <span>10:30</span></p>
            </div>

            <div class="info-col-2">
              <p>Emitido por: <span>Diego Alves</span></p>
              <p>Cargo: <span>Gerente</span></p>
              <p>IP do usuário: <span><?php echo get_client_ip()?></span></p>
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
                <!-- <th>Endereço</th> -->
                <th>Tipo</th>
                <th>Convênio</th>
                <th>Horário Saída</th>  
                <th>ID empresa</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach($clients as $client): ?>
                  <tr>
                    <td><?= $client->getName(); ?></td>
                    <td><?= $client->getEmail(); ?></td>       

                    <td><?= $client->getType(); ?></td>
                    <td><?= $client->getBussinesPlan(); ?></td>
                    <td><?= $client->getDepartureTime(); ?></td>
                    <td><?= $client->getCompanyId()?></td>
                    <td><?= $client->getStatus()?></td>
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