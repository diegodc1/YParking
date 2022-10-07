<head>
  <title>Clientes Cadastrados</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/listClients.css">
</head>

<body>
  <?php require_once("../components/sidebar.php") ?>

  <header class="list-clients-header">
    <h1>CLIENTES CADASTRADOS</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box">
        <a href="/pages/addClient.php" class="add-user-button">Cadastrar Cliente</a>
      </div>

      <div class="table-list">
        <table id="listClientsVehicles" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Carro</th>
              <th>Placa do carro</th>
              <th>Convênio</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Monalisa Silva</td>
              <td>exemplo2@exemplo2.com</td>
              <td>Chevrolet Onix</td>
              <td>FAE2E13</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Filho do bill</td>
              <td>exemplo@exemplo.com</td>
              <td>Honda Civic</td>
              <td>BRA2E19</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Pedro Alvarez Cabral</td>
              <td>exemplo3@exemplo3.com</td>
              <td>Ford Focus</td>
              <td>KRA2E13</td>
              <td>Não</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Elon Musk</td>
              <td>exemplo5@exemplo5.com</td>
              <td>BMW M3</td>
              <td>LOA2E19</td>
              <td>Não</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Bill Gates</td>
              <td>exemplo6@exemplo6.com</td>
              <td>Fiat Palio</td>
              <td>LUA2E49</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Floriano Peixoto</td>
              <td>exemplo7@exemplo7.com</td>
              <td>Ford Ka</td>
              <td>GTO2H59</td>
              <td>Não</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Canse de exemplos</td>
              <td>exemplo@exemplo.com</td>
              <td>Honda Civic</td>
              <td>BRA2E19</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Filho do bill</td>
              <td>exemplo@exemplo.com</td>
              <td>Honda Civic</td>
              <td>BRA2E19</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Filho do bill</td>
              <td>exemplo@exemplo.com</td>
              <td>Honda Civic</td>
              <td>BRA2E19</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Filho do bill</td>
              <td>exemplo@exemplo.com</td>
              <td>Honda Civic</td>
              <td>BRA2E19</td>
              <td>Sim</td>
              <td>
                <div class="action-buttons">
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="#"><i class="fa-solid fa-eye eye"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="#"><i class="fa-solid fa-pencil pencil"></i></a></button>
                  <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="#"><i class="fa-solid fa-trash-can trash"></i></a></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Filho do bill</td>
              <td>exemplo@exemplo.com</td>
              <td>Honda Civic</td>
              <td>BRA2E19</td>
              <td>Sim</td>
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