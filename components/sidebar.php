<?php 
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');

$usuarioDao = new UsuarioDaoDB($pdo);

$userPerfil = false;

$id = $_SESSION['user_id'];

if($id) {
  $perfil = $usuarioDao->findById($id);
}

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
</head>

<body>
  <aside class="close">
    <div class="header-sidebar">
      <img src="/assets/imgs/logo.png" alt="Logo da +Vet" id="logo" />
      <i class="fa-solid fa-bars" onclick="sidebar()"></i>
    </div>

    <div class="menu-sections">
      <button data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard" class="">
        <a href="../pages/dashboard.php" class="sections">
          <i class="fa-solid fa-house"></i>
          <span>Dashboard</span>
        </a>
      </button>

      <button data-bs-toggle="tooltip" data-bs-placement="right" title="Clientes" class="">
        <a href="../pages/listClients.php" class="sections">
          <i class="fa-solid fa-users"></i>
          <span>Clientes</span>
        </a>
      </button>

      <button data-bs-toggle="tooltip" data-bs-placement="right" title="Usuários" class="">
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
        <a href="#" class="sections">
          <i class="fa-solid fa-building"></i>
          <span>Empresas</span>
        </a>
      </button>

      <div class="line"></div>

      <button data-bs-toggle="tooltip" data-bs-placement="right" title="Perfil" class="">
        <a href="../pages/perfil.php" class="sections">
          <i class="fa-solid fa-user-gear"></i>
          <span>Editar Perfil</span>
        </a>
      </button>

    </div>

    <div class="footer-sidebar close">
      <div class="info-user">
        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Foto do usuário" width="100px" id="user-photo" />
        <div class="text-info">
          <span id="user-name"><?= $perfil->getName(); ?></span>
          <p id="user-office"><?= $perfil->getFunction(); ?></p>
        </div>
      </div>

      <div class="log-out" id="log-out">

        <a href="../index.php"><i class="fa-solid fa-right-from-bracket"></i></a>
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