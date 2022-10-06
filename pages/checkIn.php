<head>

  <title>Check-in</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/checkIn.css">
  <link rel="stylesheet" href="../stylesstyle.css">

</head>

<body>
  <?php require_once('../components/sidebar.php') ?>

  <header class="checkin-header">
    <h1>ENTRADA DE VEÍCULO</h1>
  </header>

  <main>
    <div class="checkin-box">
      <div class="header-box">
        <h2>REALIZAR ENTRADA DE VEÍCULO</h2>
      </div>

      <div class="line"></div>

      <div class="search-box">
        <form action="" method="POST">
          <input type="text" class="input-search" placeholder="Digite a placa do veículo">
          <button type="submit">Pesquisar</button>
        </form>
      </div>

      <table id="listDashboard" class="table">
        <thead>
          <tr>
            <th>Modelo</th>
            <th>Placa</th>
            <th>Cor</th>
            <th>Categoria</th>
            <th>Cliente</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>
              <a href="#" class="checkin-button">Realizar Entrada</a>
            </td>
          </tr>
          <tr>
        </tbody>
      </table>
    </div>

    <div class="checkin-historic-box">
      <div class="header box2">
        <h2>HISTÓRICO DE ENTRADAS</h2>
      </div>

      <div class="line"></div>

      <!-- Certo -->
      <table id="checkin-historic" class="table" style="width:100%">
        <thead>
          <tr>
            <th>Modelo</th>
            <th>Placa</th>
            <th>Cor</th>
            <th>Categoria</th>
            <th>Cliente</th>
            <th>Horário de Entrada</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
            <td>Hb20</td>
            <td>FAE2E13</td>
            <td>Branco</td>
            <td>Hatch</td>
            <td>Pedro Silva</td>
            <td>12:30</td>
            <td>
              <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
            </td>
          </tr>
          <tr>
        </tbody>
      </table>



      <!-- ------------------------------------ -->

    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>
</body>

</html>