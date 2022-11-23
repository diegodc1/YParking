

<!DOCTYPE html>
<html lang="pt_br">
  

<head>
  <?php require_once('../components/headConfig.php'); 
    session_start();?>
  <link rel="stylesheet" href="/styles/dashboard.css">
  <title>Dashboard</title>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>


<body class="dashboard-body">
  <?php require_once('../components/sidebar.php');?>
  <header>
    <h1>DASHBOARD</h1>
  </header>

  <main>
    <div class="main-content">

      <div class="main-box1">
        <div class="box1">
        
        <section class="sect1">
          <a href="../pages/checkIn.php">
            <div class="buttons-section car-entry-button">
              <i class="fa-solid fa-arrow-turn-up"></i>
              <p>ENTRADA DE VEÍCULO</p>
            </div>
          </a>

          <a href="/pages/addClient.php">
            <div class="buttons-section">
              <i class="fa-solid fa-user-plus"></i>
              <p>CADASTRAR CLIENTE</p>
            </div>
          </a>

          <a href="/pages/addVehicle.php">
            <div class="buttons-section">
              <i class="fa-solid fa-car"></i>
              <p>CADASTRAR VEÍCULO</p>
            </div>
          </a>
          
          
          <a href="/pages/addCompany.php">
            <div class="buttons-section">
              <img src="../assets/imgs/icon-add-companys.png"/>
              <p>CADASTRAR EMPRESA</p>
            </div>
          </a>
          
          <a href="/pages/addUser.php">
            <div class="buttons-section">
              <i class="fa-solid fa-user-gear"></i>
              <p>CADASTRAR USUÁRIO</p>
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
          
  
          <a href="../pages/listClients.php">
            <div class="buttons-section">
              <i class="fa-solid fa-users"></i>
              <p>CLIENTES CADASTRADOS</p>
            </div>
          </a>
  
          <a href="../pages/listVehicles.php">
            <div class="buttons-section">
               <img src="../assets/imgs/icon-vehicles.png"/>
              <p>VEÍCULOS CADASTRADOS</p>
            </div>
          </a>
  
          
          <a href="/pages/listCompanys.php">
            <div class="buttons-section">
              <i class="fa-solid fa-building-user"></i>
              <p>EMPRESAS CONVENIADAS</p>
            </div>
          </a>
          
          <a href="/pages/listUsers.php">
            <div class="buttons-section">
              <i class="fa-solid fa-users-gear"></i>
              <p>USUÁRIOS CADASTRADOS</p>
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

          <section class="movements">
            <h2>Histórico de Movimentações</h2>
            <div class="line"></div>
              <table class="next-out-table table" id="listDashboardMovements">
                <thead>
                  <tr class="collums-list">
                    <th class="col-4-table">Movimento</th>
                    <th class="col-4-table">Veículo</th>
                    <th class="col-4-table">Placa</th>
                    <th class="col-4-table">Cliente</th>
                    <th class="col-4-table">Horário</th>
                  </tr>
                </thead>
                
                <tbody>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                  <tr class="item-table">
                    <td class="item1">Entrada</td>
                    <td>Renault Logan</td>
                    <td>BRA2E19</td>
                    <td>Fernando Cunha</td>
                    <td class="item4">18:10</td>
                  </tr>
                </tbody>
              </table>
          </section>
        </div>
      </div>

      <div class="main-box2">
        <section class="occupation">
            <h2>Ocupação do Estacionamento</h2>
            <div class="boxes-occupation">

              <div class="box-occu 1">
                <div class="box-occu-header">
                  <span>SEÇÃO A</span>
                </div>
                <div class="line-info">
                  <p>Ocupação: <span>87%</span></p>
                  <div class="line-occupation">
                    <div class="fill-line"></div>
                  </div>
                </div>
              </div>

              <div class="box-occu 2">
                <div class="box-occu-header">
                  <span>SEÇÃO A</span>
                </div>
                 <div class="line-info">
                  <p>Ocupação: <span>87%</span></p>
                  <div class="line-occupation">
                    <div class="fill-line"></div>
                  </div>
                </div>
              </div>

              <div class="box-occu 3">
                <div class="box-occu-header">
                  <span>SEÇÃO A</span>
                </div>
                 <div class="line-info">
                  <p>Ocupação: <span>87%</span></p>
                  <div class="line-occupation">
                    <div class="fill-line"></div>
                  </div>
                </div>
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