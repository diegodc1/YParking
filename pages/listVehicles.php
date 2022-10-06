<head>
  <title>Clientes Cadastrados</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../stylesstyle.css">
  <link rel="stylesheet" href="../styles/listVehicles.css">
</head>

<body>
  <?php require_once("../components/sidebar.php") ?>

  <header class="list-clients-header">
    <h1>VEÍCULOS CADASTRADOS</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box">
        <a href="/pages/addClient.php" class="add-user-button">Cadastrar Veículo</a>
      </div>

      <div class="table-list">
        <table id="listClientsVehicles" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Modelo</th>
              <th>Placa</th>
              <th>Marca</th>
              <th>Cor</th>
              <th>Categoria</th>
              <th>Cliente</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>M3</td>
              <td>TYE2E13</td>
              <td>BMW</td>
              <td>Branco</td>
              <td>Sedan</td>
              <td>Elon Musk</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Onix</td>
              <td>FLO2E14</td>
              <td>Chevrolet</td>
              <td>Vermelho</td>
              <td>Hatch</td>
              <td>Monalisa</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Hb20</td>
              <td>AHT2E15</td>
              <td>Hyundai</td>
              <td>Preto</td>
              <td>Hatch</td>
              <td>Floriano Peixoto</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Palio</td>
              <td>FAE2E13</td>
              <td>Fiat</td>
              <td>Prata</td>
              <td>Hatch</td>
              <td>Bill Gates</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>

          </tbody>

        </table>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="../js/dataTable.js"></script>

</body>



</html>