<?php 
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');

$usuarioDao = new UsuarioDaoDB($pdo);

$userPerfil = false;

$id = $_SESSION['user_id'];

if($id) {
  $perfil = $usuarioDao->findById($id);
}
$color = '#109cf1';
if(isset($_SESSION['colorTheme'])) {
  $color = $_SESSION['colorTheme'];
} 

$userAccess = $_SESSION['user_access'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sidebar</title>

  <!-- Styles -->
  <link rel="stylesheet" href="/styles/sidebar.css" />
  <link rel="stylesheet" href="/styles/style.css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="apple-touch-icon" sizes="180x180" href="../assets/imgs/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/imgs/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/imgs/favicon-16x16.png">
  <link rel="manifest" href="../assets/imgs/site.webmanifest">
  <link rel="mask-icon" href="../assets/imgs/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

      <link rel="apple-touch-icon" sizes="180x180" href="../assets/imgs/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/imgs/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/imgs/favicon-16x16.png">
  <link rel="manifest" href="../assets/imgs/site.webmanifest">
  <link rel="mask-icon" href="../assets/imgs/safari-pinned-tab.svg color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <?php require_once('../components/favicon.php') ?>

</head>
<style>
  :root {
    --blue-light: <?= $color?>;
  }

  <?php if($userAccess == 0){ ?>
      .admin {
        display: none !important;
      }
  <?php }?>

</style>

<body class="sidebar-body">
    <div class="bg-sidebar remove-bg-sidebar"></div>
    <aside class="close">
      <div class="header-sidebar">
        <img src="/assets/imgs/logo.png" alt="Logo da +Vet" id="logo" />
        <i class="fa-solid fa-bars" onclick="sidebar()"></i>
      </div>

      <div class="menu-sections close">
        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard" class="">
          <a href="../pages/dashboard.php" class="sections">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Check-in/Check-out" class="">
          <a href="../pages/checkin.php" class="sections">
            <i class="fa-solid fa-repeat"></i>
            <span>Entrad./Saída</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Clientes" class="">
          <a href="../pages/listClients.php" class="sections">
            <i class="fa-solid fa-users"></i>
            <span>Clientes</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Usuários" class="admin">
          <a href="../pages/listUsers.php" class="sections">
            <i class="fa-solid fa-users-gear"></i>
            <span>Usuários</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Veículos" class="">
          <a href="../pages/listVehicles.php" class="sections">
            <i class="fa-solid fa-car"></i>
            <span>Veículos</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Empresas" class="">
          <a href="../pages/listCompanys.php" class="sections">
            <i class="fa-solid fa-building"></i>
            <span>Empresas</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Relatórios" class="admin">
          <a href="../pages/relatorios.php" class="sections">
            <i class="fa-regular fa-file-lines"></i>
            <span>Relatorios</span>
          </a>
        </button>

        <div class="line"></div>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Estacionamento" class="admin">
          <a href="../pages/parking.php" class="sections">
            <i class="fa-solid fa-square-parking"></i>
            <span>Estacionamento</span>
          </a>
        </button>

        <button data-bs-toggle="tooltip" data-bs-placement="right" title="Perfil" class="">
          <a href="../pages/perfil.php" class="sections">
            <i class="fa-solid fa-user-gear"></i>
            <span>Editar Perfil</span>
          </a>
        </button>

      </div>

      <div class="footer-sidebar close">
        <div class="info-user">
          <div class="text-info">
            <span id="user-name"><?= $perfil->getName(); ?></span>
            <p id="user-office"><?= $perfil->getFunction(); ?></p>
          </div>
        </div>

        <div class="log-out" id="log-out">
          <a href="../actions/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
      </div>
    </aside>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="/js/sidebar.js"></script>
  <script>



    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  </script>
</body>

</html>