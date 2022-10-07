<head>

  <title>Check-in</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="../stylesstyle.css">
  <link rel="stylesheet" href="../styles/checkIn.css">

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

      <!-- Searching Vehicle Table -->
      <table id="" class="table">
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

      <!-- Historic Table -->
      <div class="table-list">
        <table id="checkin" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Cor</th>
              <th>Cliente</th>
              <th>Horár. Entrada</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Hb20</td>
              <td>FAE2E13</td>
              <td>Branco</td>
              <td>Pedro Silva</td>
              <td>12:30</td>
              <td>
                <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
              </td>
            </tr>
            <tr>
              <td>Hb20</td>
              <td>BLAE2E13</td>
              <td>Branco</td>
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
              <td>Pedro Silva</td>
              <td>12:30</td>
              <td>
                <a href="#" class="delete-checkin-button">Cancelar / Excluir</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>



      <!-- ------------------------------------ -->

    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/tooltip.js"></script>
  <script src="../js/dataTable.js"></script>

</body>

</html>