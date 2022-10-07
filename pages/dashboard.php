<!DOCTYPE html>
<html lang="pt_br">

<head>
  <?php require_once('../components/headConfig.php') ?>
  <link rel="stylesheet" href="/styles/dashboard.css">
  <title>Dashboard</title>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>


<body class="dashboard-body">
  <?php require_once('../components/sidebar.php') ?>

  <header>
    <h1>DASHBOARD</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="box1">
        <section class="sect1">
          <a href="../pages/checkIn.php">
            <div class="buttons-section car-entry-button">
              <i class="fa-solid fa-arrow-turn-up"></i>
              <p>ENTRADA DE VEÍCULO</p>
            </div>
          </a>

          <a href="../pages/listClients.php">
            <div class="buttons-section">
              <i class="fa-solid fa-users"></i>
              <p>CLIENTES CADASTRADOS</p>
            </div>
          </a>

          <a href="../pages/listVehicles.php">
            <div class="buttons-section">
              <i class="fa-solid fa-car"></i>
              <p>VEÍCULOS CADASTRADOS</p>
            </div>
          </a>

          <a href="#">
            <div class="buttons-section">
              <i class="fa-solid fa-building-user"></i>
              <p>EMPRESAS CONVENIADAS</p>
            </div>
          </a>
        </section>

        <section class="sect2">
          <a href="../pages/checkout.php">
            <div class="buttons-section car-out-button">
              <i class="fa-solid fa-arrow-turn-down"></i>
              <p>SAÍDA DE VEÍCULO</p>
            </div>
          </a>

          <a href="/pages/addClient.php">
            <div class="buttons-section">
              <i class="fa-solid fa-user-plus"></i>
              <p>CADASTRAR CLIENTE</p>
            </div>
          </a>

          <a href="">
            <div class="buttons-section">
              <i class="fa-solid fa-car"></i>
              <p>CADASTRAR VEÍCULO</p>
            </div>
          </a>

          <a href="/pages/addUser.php">
            <div class="buttons-section">
              <i class="fa-solid fa-users-gear"></i>
              <p>CADASTRAR USUÁRIO</p>
            </div>
          </a>
        </section>
      </div>

      <div class="box2">
        <section class="next-out">
          <h2>Próximas possíveis saídas de veículos</h2>
          <div class="line"></div>

          <table class="next-out-table table" id="listDashboard">
            <thead>
              <tr class="collums-list">
                <th class="col-4-table">Carro</th>
                <th class="col-4-table">Placa</th>
                <th class="col-4-table">Cliente</th>
                <th class="col-4-table">Saída</th>
              </tr>
            </thead>

            <tbody>
              <tr class="item-table">
                <td class="item1">Honda Civic - Preto</td>
                <td>BRA2E19</td>
                <td>Fernando Cunha</td>
                <td class="item4">18:10</td>
              </tr>

              <tr class="item-table">
                <td class="item1">S10 - Branca</td>
                <td>BEE4R22 </td>
                <td>Janaina Silva</td>
                <td class="item4">18:12</td>
              </tr>

              <tr class="item-table">
                <td class="item1">Sandero - Azul</td>
                <td>PLS0A00</td>
                <td>Pedro Santos</td>
                <td class="item4">18:19</td>
              </tr>

              <tr class="item-table">
                <td class="item1">HB20 - Prata</td>
                <td>LVS4A50</td>

                <td>Lulu Santos</td>
                <td class="item4">18:24</td>
              </tr>

              <tr class="item-table">
                <td class="item1">Logan - Vermelho</td>
                <td>ATY0A90</td>
                <td>Filho do Bill</td>
                <td class="item4">18:26</td>
              </tr>

              <tr class="item-table">
                <td class="item1">Bmw M3 - Azul</td>
                <td>LOJ0R03</td>
                <td>Pedro Alvarez</td>
                <td class="item4">18:31</td>
              </tr>
              <tr class="item-table">
                <td class="item1">Bmw M3 - Azul</td>
                <td>LOJ0R03</td>
                <td>Pedro Alvarez</td>
                <td class="item4">18:31</td>
              </tr>
              <tr class="item-table">
                <td class="item1">Bmw M3 - Azul</td>
                <td>LOJ0R03</td>
                <td>Pedro Alvarez</td>
                <td class="item4">18:31</td>
              </tr>
              <tr class="item-table">
                <td class="item1">Bmw M3 - Azul</td>
                <td>LOJ0R03</td>
                <td>Pedro Alvarez</td>
                <td class="item4">18:31</td>
              </tr>
              <tr class="item-table">
                <td class="item1">Bmw M3 - Azul</td>
                <td>LOJ0R03</td>
                <td>Pedro Alvarez</td>
                <td class="item4">18:31</td>
              </tr>
              <tr class="item-table">
                <td class="item1">Bmw M3 - Azul</td>
                <td>LOJ0R03</td>
                <td>Pedro Alvarez</td>
                <td class="item4">18:31</td>
              </tr>
            </tbody>
          </table>
        </section>

        <section class="occupation">
          <h2>Ocupação do Estacionamento</h2>
          <div class="circles-occupation">
            <div class="free-slots">
              <p>27</p>
              <span>Vagas disponíveis</span>
            </div>

            <div class="busy-slots">
              <p>84</p>
              <span>Vagas ocupadas</span>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>
</body>

</html>