<?php
session_start();
require_once('../components/verifyLogin.php');
require_once('../db/config.php');
require_once('../dao/SectionDao.php');
require_once('../dao/UsuarioDao.php');


$sectionDao = new SectionDaoDB($pdo);
$usuarioDao = new UsuarioDaoDB($pdo);

$sections = $sectionDao->findAll();
$users = $usuarioDao->findAll();




?>

<head>
  <title>Relatórios</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/relatorio.css">
  <link rel="stylesheet" href="../styles/style.css">
  <?php require_once('../components/favicon.php') ?>;

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>


<body>
  <?php require_once("../components/sidebar.php") ;?>
   

  <header class="relat-header">
    <h1>RELATÓRIO</h1>
  </header>

  <main>
    <div class="main-content">

        <?php require('../components/alertMessage.php')?>


      <div class="form-relat">
        <h5>Relatórios Rápidos:</h5>

        <div class="relats-buttons-box">

          <!------- Relatório Rápido Cliente ------->
          <div class="box-relat-rapid">
            <h6 class="title-box-relat">Clientes</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatClients.php?typeRelat=monthly">
                <div class="relat-btn">
                  <span>Mensalistas</span>
                  <i class="fa-regular fa-calendar-days"></i>
                </div>
              </a>

              <a href="../pages/fastRelatClients.php?typeRelat=hour">
                <div class="relat-btn">
                  <span>Horistas</span>
                  <i class="fa-regular fa-clock"></i>
                </div>
              </a>

              <a href="../pages/fastRelatClients.php?typeRelat=bussinesPlan">
                <div class="relat-btn">
                  <span>Conveniados de Empresa</span>
                  <i class="fa-solid fa-business-time"></i>
                </div>
              </a>

              <a href="../pages/fastRelatClients.php?typeRelat=noBussinesPlan">
                <div class="relat-btn">
                  <span>Não Conveniados</span>
                  <i class="fa-solid fa-business-time"></i>
                </div>
              </a>
            </div>
          </div>

          <!------- Relatório Rapido Usuarios ------->
           <div class="box-relat-rapid">
            <h6 class="title-box-relat">Usuários</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatUsers.php?typeRelat=levelAccess">
                <div class="relat-btn">
                  <span>Nível de Acesso</span>
                  <i class="fa-solid fa-layer-group"></i>
                </div>
              </a>

              <a href="../pages/fastRelatUsers.php?typeRelat=function">
                <div class="relat-btn">
                  <span>Cargo</span>
                  <i class="fa-solid fa-users-gear"></i>
                </div>
              </a>

              <a href="../pages/fastRelatUsers.php?typeRelat=status">
                <div class="relat-btn">
                  <span>Status</span>
                  <i class="fa-solid fa-circle-info"></i>
                </div>
              </a>
            </div>
          </div>

          <!------- Relatório Rápido Check-ins ------->
           <div class="box-relat-rapid">
            <h6 class="title-box-relat">Check-ins</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatCheckins.php?typeRelat=month">
                <div class="relat-btn">
                  <span>Todos do Mês</span>
                  <i class="fa-solid fa-calendar-check"></i>
                </div>
              </a>

              <a href="../pages/fastRelatCheckins.php?typeRelat=perDay">
                <div class="relat-btn">
                  <span>Por dia - neste mês </span>
                  <i class="fa-solid fa-calendar-day"></i>
                </div>
              </a>

              <a href="../pages/fastRelatCheckins.php?typeRelat=canceled">
                <div class="relat-btn">
                  <span>Cancelados - neste mês</span>
                  <i class="fa-regular fa-calendar-xmark"></i>
                </div>
              </a>
            </div>
          </div>


           <!------- Relatório Rápido Check-outs ------->
          <div class="box-relat-rapid">
            <h6 class="title-box-relat">Check-outs</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatCheckouts.php?typeRelat=month">
                <div class="relat-btn">
                  <span>Todos do Mês</span>
                  <i class="fa-solid fa-calendar-check"></i>
                </div>
              </a>

              <a href="../pages/fastRelatCheckouts.php?typeRelat=perDay">
                <div class="relat-btn">
                  <span>Por dia (deste mês)</span>
                  <i class="fa-solid fa-calendar-day"></i>
                </div>
              </a>

               <a href="../pages/fastRelatCheckouts.php?typeRelat=canceled">
                <div class="relat-btn">
                  <span>Cancelados - neste mês</span>
                  <i class="fa-regular fa-calendar-xmark"></i>
                </div>
              </a>
            </div>
          </div>

          <!------- Relatório Rápido Veículos ------->
          <div class="box-relat-rapid">
            <h6 class="title-box-relat">Veículos</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatVehicles.php?typeRelat=category">
                <div class="relat-btn">
                  <span>Quantidade por categoria</span>
                  <i class="fa-solid fa-car-side"></i>
                </div>
              </a>

              <a href="../pages/fastRelatVehicles.php?typeRelat=activeDisable">
                <div class="relat-btn">
                  <span>Ativos e Desativados</span>
                  <i class="fa-solid fa-toggle-off"></i>
                </div>
              </a>
            </div>
          </div>

          
           <!------- Relatório Rápido Financeiro ------->
           <div class="box-relat-rapid">
            <h6 class="title-box-relat">Financeiro</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatFinance.php?typeRelat=valuePerDay">
                <div class="relat-btn">
                  <span>Valor total por dia - neste mês</span>
                  <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
              </a>
            </div>

            <div class="client-relat-box">
              <a href="../pages/fastRelatFinance.php?typeRelat=type">
                <div class="relat-btn">
                  <span>Valor total por tipo - neste mês</span>
                  <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
              </a>
            </div>    
          </div>

                    <!------- Relatório Rápido Empresas ------->
          <div class="box-relat-rapid">
            <h6 class="title-box-relat">Empresas</h6>
            <div class="client-relat-box">
              <a href="../pages/fastRelatCompanys.php?typeRelat=slots">
                <div class="relat-btn">
                  <span>Vagas Reservadas</span>
                  <i class="fa-solid fa-car-tunnel"></i>
                </div>
              </a>
            </div>
          </div>


        
        </div>

        <div class="line-div two"></div>

        <h5 class="mt-3">Relatórios Personalizável:</h5>
        <div class="col-md-2">
          <label for="inputTypeRelat" class="form-label">Relatório de:</label>
          <select id="inputTypeRelat" name="inputTypeRelat" class="form-select" required onclick="showInput()">
            <option selected value="null">Selecione...</option>
            <option value="client">Clientes</option>
            <option value="vehicle">Veículos</option>
            <option value="checkin">Checkins</option>
            <option value="checkout">Checkouts</option>
            <option value="company">Empresas</option>
            <option value="user">Usuários</option>
          </select>
        </div>

        <!--============= Formulário Clientes ==============-->
        <form action="../pages/relatClient.php" method="POST" id="form-clients" class="row g-3">
          <div class="col-md-3">
            <label for="inputRelatName" class="form-label">Nome do relatório:</label>
            <input type="text" class="form-control" name="inputRelatName" autocomplete="off" required>
          </div>

          <div class="col-md-2">
            <label for="inputStatus" class="form-label">Status:</label>
            <select id="inputStatus" name="inputStatus" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Ativo">Ativo</option>
              <option value="Desativado">Desativado</option>
            </select>
          </div>

          <div class="col-md-2">
            <label for="inputType" class="form-label">Tipo:</label>
            <select id="inputType" name="inputType" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Mensalista">Mensalista</option>
              <option value="Horista">Horista</option>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputBussinesPlan" class="form-label">Convênio de Empresa:</label>
            <select id="inputBussinesPlan" name="inputBussinesPlan" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Sim">Sim</option>
              <option value="Não">Não</option>
            </select>
          </div>

          <div class="row mt-4">
            <div class="col-md-3 graphBox">
              <p class="form-label">Gráfico de tipo de cliente?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="generateGraphType" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="generateGraphType" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>

            <div class="col-md-3 graphBox">
              <p class="form-label">Gráfico de convênio?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="genGraphBussinesPlan" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="genGraphBussinesPlan" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
          </div>
          </div>


          <div class="row mt-3">
            <div class="col-md-2">
              <input type="submit" value="Gerar Relatório" class="submit-button">
            </div>
          </div>
        </form>

        <!--============= Formulário Veículos ==============-->
        <form action="../pages/relatVehicles.php" method="POST" id="form-vehicles" class="row g-3">
          <div class="col-md-3">
            <label for="inputRelatName" class="form-label">Nome do relatório:</label>
            <input type="text" class="form-control" name="inputRelatName" autocomplete="off" required>
          </div>

          <div class="col-md-2">
            <label for="inputStatus" class="form-label">Status:</label>
            <select id="inputStatus" name="inputStatus" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Ativo">Ativo</option>
              <option value="Desativado">Desativado</option>
            </select>
          </div>

          <div class="col-md-2">
            <label for="inputCategory" class="form-label">Categoria:</label>
            <select id="inputCategory" name="inputCategory" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Sedan">Sedan</option>
              <option value="SUV">SUV</option>
              <option value="Hatch">Hatch</option>
              <option value="Caminhonete">Caminhonete</option>
              <option value="Moto">Moto</option>
              <option value="Caminhao">Caminhão</option>
            </select>
          </div>

          <div class="row mt-4">
            <div class="col-md-3 graphBox">
              <p class="form-label">Gráfico de categoria?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="genGraphCategory" value="Sim" required>
                <label for="yes">Sim</label>

                <input type="radio" id="no" name="genGraphCategory" class="radiu-2" value="Não" required>
                <label for="no">Não</label>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-2">
              <input type="submit" value="Gerar Relatório" class="submit-button">
            </div>
          </div>
        </form>

        <!--============= Formulário Checkins ==============-->
        <form action="../pages/relatCheckins.php" method="POST" id="form-checkins" class="row g-3">
          <div class="col-md-3">
            <label for="inputRelatName" class="form-label">Nome do relatório:</label>
            <input type="text" class="form-control" name="inputRelatName" autocomplete="off" required>
          </div>

          <div class="col-md-3">
            <label for="inputStatus" class="form-label">Status:</label>
            <select id="inputStatus" name="inputStatus" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Ativo">Ativo</option>
              <option value="Finalizado">Finalizado</option>
              <option value="Cancelado">Cancelado</option>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputSection" class="form-label">Seção:</label>
            <select id="inputSection" name="inputSection" class="form-select" required">
              <option selected value="all">Todas</option>
             <?php foreach($sections as $section): ?>
                <option value="<?= $section->getId()?>"><?= $section->getName()?></option>
              <?php endforeach?>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputUser" class="form-label">Usuário:</label>
            <select id="inputUser" name="inputUser" class="form-select" required">
              <option selected value="all">Todos</option>
             <?php foreach($users as $user): ?>
                <option value="<?= $user->getId()?>"><?= $user->getName()?></option>
              <?php endforeach?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-3">
              <label for="inputDateInicial" class="form-label">Data Inicial:</label>
              <input type="date" class="form-control" name="inputDateInicial" autocomplete="off" required>
            </div>

            <div class="col-md-3">
              <label for="inputDateFinal" class="form-label">Data Final:</label>
              <input type="date" class="form-control" name="inputDateFinal" autocomplete="off" required>
            </div>

            <div class="col-md-2">
              <label for="inputTimeInicial" class="form-label">Horário Inicial:</label>
              <input type="time" class="form-control" name="inputTimeInicial" autocomplete="off" required>
            </div>

            <div class="col-md-2">
              <label for="inputTimeFinal" class="form-label">Horário Final:</label>
              <input type="time" class="form-control" name="inputTimeFinal" autocomplete="off" required>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-3 graphBox">
              <p class="form-label">Gerar gráfico de seção?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="geGraphSection" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="geGraphSection" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>

            <div class="col-md-3 graphBox">
              <p class="form-label">Gerar gráfico de status?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="geGraphStatus" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="geGraphStatus" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>

            <div class="col-md-4 graphBox">
              <p class="form-label">Gerar gráfico de Checkins por dia?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="geGraphCkinPerDay" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="geGraphCkinPerDay" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-2">
              <input type="submit" value="Gerar Relatório" class="submit-button">
            </div>
          </div>
        </form>

        <!--============= Formulário Ckeckouts ==============-->
        <form action="../pages/relatCheckout.php" method="POST" id="form-checkouts" class="row g-3">
          <div class="col-md-3">
            <label for="inputRelatName" class="form-label">Nome do relatório:</label>
            <input type="text" class="form-control" name="inputRelatName" autocomplete="off" required>
          </div>

          <div class="col-md-3">
            <label for="inputStatus" class="form-label">Status:</label>
            <select id="inputStatus" name="inputStatus" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Finalizado">Finalizado</option>
              <option value="Cancelado">Cancelado</option>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputSection" class="form-label">Seção:</label>
            <select id="inputSection" name="inputSection" class="form-select" required">
              <option selected value="all">Todas</option>
             <?php foreach($sections as $section): ?>
                <option value="<?= $section->getId()?>"><?= $section->getName()?></option>
              <?php endforeach?>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputUser" class="form-label">Usuário:</label>
            <select id="inputUser" name="inputUser" class="form-select" required">
              <option selected value="all">Todos</option>
             <?php foreach($users as $user): ?>
                <option value="<?= $user->getId()?>"><?= $user->getName()?></option>
              <?php endforeach?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-3">
              <label for="inputDateInicial" class="form-label">Data Inicial:</label>
              <input type="date" class="form-control" name="inputDateInicial" autocomplete="off" required>
            </div>

            <div class="col-md-3">
              <label for="inputDateFinal" class="form-label">Data Final:</label>
              <input type="date" class="form-control" name="inputDateFinal" autocomplete="off" required>
            </div>

            <div class="col-md-3">
              <label for="inputTimeInicial" class="form-label">Horário Inicial:</label>
              <input type="time" class="form-control" name="inputTimeInicial" autocomplete="off" required>
            </div>

            <div class="col-md-3">
              <label for="inputTimeFinal" class="form-label">Horário Final:</label>
              <input type="time" class="form-control" name="inputTimeFinal" autocomplete="off" required>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-2">
              <label for="inputValueInitial" class="form-label">Entre</label>
              <div class="box-in-daily">
                <input type="text" class="form-control"   value="R$ 0,00" id="valor" readonly>
                <input type="range" min="0" max="1999.00" value="0.00" step="1" style="width:100%" oninput="converter(this.value)" ata-bs-toggle="tooltip" data-bs-placement="right" title="Utilize as teclas do teclado para maior precisão." name="inputValueInitial">
              </div>
            </div>

            <div class="col-lg-2">
              <label for="inputValueFinal" class="form-label">Até </label>
              <div class="box-in-daily">
                <input type="text" class="form-control"  value="R$ 50,00" id="valor2" readonly>
                <input type="range" min="0" max="2000.00" value="50.00" step="1" style="width:100%" oninput="converter2(this.value)" ata-bs-toggle="tooltip" data-bs-placement="right" title="Utilize as teclas do teclado para maior precisão." name="inputValueFinal">
              </div>
            </div>

            
            <div class="col-md-2 graphBox mt-4">
              <p class="form-label">Gráfico de status?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="genGraphSection" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="genGraphSection" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>


            <div class="col-md-3 graphBox mt-4">
              <p class="form-label">Gráfico de checkouts por dia?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="genGraphCkoutPerDay" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="genGraphCkoutPerDay" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>

            <div class="col-md-3 graphBox mt-4">
              <p class="form-label">Gráfico de valor total por dia?</p>

              <div class="radius-box">
                <input type="radio" id="yes" name="genGraphTotalValuePerDay" value="Sim" required>
                <label for="yes">Sim</label><br>

                <input type="radio" id="no" name="genGraphTotalValuePerDay" class="radiu-2" value="Não" required>
                <label for="no">Não</label><br>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-2">
              <input type="submit" value="Gerar Relatório" class="submit-button">
            </div>
          </div>
        </form>

        <!--============= Formulário Empresas ==============-->
        <form action="../pages/relatCompanys.php" method="POST" id="form-companys" class="row g-3">
          <div class="col-md-3">
            <label for="inputRelatName" class="form-label">Nome do relatório:</label>
            <input type="text" class="form-control" name="inputRelatName" autocomplete="off" required>
          </div>

          <div class="col-md-3">
            <label for="inputStatus" class="form-label">Status:</label>
            <select id="inputStatus" name="inputStatus" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="active">Ativo</option>
              <option value="disabled">Desativado</option>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputSlotsMin" class="form-label">Vagas de:</label>
            <input type="number" class="form-control" name="inputSlotsMin" id="inputSlotsMin" autocomplete="off" value="0" required>
          </div>

          <div class="col-md-3">
            <label for="inputSlotsMax" class="form-label">até:</label>
            <input type="number" class="form-control" name="inputSlotsMax" id="inputSlotsMax" autocomplete="off" value="20" required>
            <p class="alert-message-slots">O valor máximo deve ser maior que o mínimo!</p>
          </div>


          <div class="row mt-3">
            <div class="col-md-2">
              <input type="submit" value="Gerar Relatório" class="submit-button" id="btnSubmitCmpy">
            </div>
          </div>
        </form>

        <!--============= Formulário Usuários ==============-->
        <form action="../pages/relatUsers.php" method="POST" id="form-users" class="row g-3">
          <div class="col-md-3">
            <label for="inputRelatName" class="form-label">Nome do relatório:</label>
            <input type="text" class="form-control" name="inputRelatName" autocomplete="off" required>
          </div>

          <div class="col-md-3">
            <label for="inputStatus" class="form-label">Status:</label>
            <select id="inputStatus" name="inputStatus" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Ativo">Ativo</option>
              <option value="Desativado">Desativado</option>
            </select>
          </div>

          <div class="col-md-3">
            <label for="inputFunction" class="form-label">Cargo:</label>
            <select id="inputFunction" name="inputFunction" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="Manobrista">Manobrista</option>
              <option value="Operador de Estac.">Operador de Estacionamento</option>
              <option value="Caixa">Caixa</option>
              <option value="Gerente">Gerente</option>
            </select>
          </div>

          
          <div class="col-md-3">
            <label for="inputAccessLevel" class="form-label">Nível de Acesso:</label>
            <select id="inputAccessLevel" name="inputAccessLevel" class="form-select" required">
              <option selected value="all">Todos</option>
              <option value="0">Comum</option>
              <option value="1">Admin</option>
            </select>
          </div>

          <div class="col-md-3 graphBox">
            <p class="form-label">Gerar gráfico de cargos?</p>

            <div class="radius-box">
              <input type="radio" id="yes" name="generateGraph" value="Sim" required>
              <label for="yes">Sim</label><br>

              <input type="radio" id="no" name="generateGraph" class="radiu-2" value="Não" required>
              <label for="no">Não</label><br>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-2">
              <input type="submit" value="Gerar Relatório" class="submit-button">
            </div>
          </div>
        </form>
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
  
 
  <script>
     function showInput() {
      var inputClients =  document.querySelector("#form-clients");
      var inputVehicles = document.querySelector("#form-vehicles");
      var inputCheckins = document.querySelector("#form-checkins");
      var inputCheckouts = document.querySelector("#form-checkouts");
      var inputCompanys = document.querySelector("#form-companys");
      var inputUsers = document.querySelector("#form-users");
      var inputSelectType = document.querySelector("#inputTypeRelat").value;

      inputClients.style.display = 'none';
      inputVehicles.style.display = 'none';
      inputVehicles.style.display = 'none';
      inputCheckins.style.display = 'none';
      inputCheckouts.style.display = 'none';
      inputCompanys.style.display = 'none';
      inputUsers.style.display = 'none';

      switch (inputSelectType) {
        case 'client':
          inputClients.style.display = 'flex';
          break;
        case 'vehicle':
          inputVehicles.style.display = 'flex';
          break;
        case 'checkin':
          inputCheckins.style.display = 'flex';
          break;
        case 'checkout':
          inputCheckouts.style.display = 'flex';
          break;
        case 'company':
          inputCompanys.style.display = 'flex';
          break;
        case 'user':
          inputUsers.style.display = 'flex';
          break;  
      }
    }

    //Verifica se o valor máximo de vagas do form de empresas é menor que o valor mínimo
    document.querySelector("#inputSlotsMax").addEventListener('change', () => {
      let min = document.querySelector("#inputSlotsMin").value;
      let max = document.querySelector("#inputSlotsMax").value;
      let btnSubmit = document.querySelector("#btnSubmitCmpy");
      let alertMessage = document.querySelector(".alert-message-slots");

      max = parseInt(max);
      min = parseInt(min);

      if(max < min) {
        btnSubmit.setAttribute("disabled", "");
        alertMessage.style.display = 'flex';
      } else {
        btnSubmit.removeAttribute("disabled");
        alertMessage.style.display = 'none';
      }
    })

    //Verifica se o valor máximo de vagas do form de empresas é menor que o valor mínimo
    document.querySelector("#inputSlotsMin").addEventListener('change', () => {
      let min = document.querySelector("#inputSlotsMin").value;
      let max = document.querySelector("#inputSlotsMax").value;
      let btnSubmit = document.querySelector("#btnSubmitCmpy");
      let alertMessage = document.querySelector(".alert-message-slots");

      max = parseInt(max);
      min = parseInt(min);

      if(max < min) {
        btnSubmit.setAttribute("disabled", "");
        alertMessage.style.display = 'flex';
      } else {
        btnSubmit.removeAttribute("disabled");
        alertMessage.style.display = 'none';
      }
    })

    function converter(valor) {
      var numero = parseFloat(valor).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      });
      document.getElementById('valor').value = numero;
    }

    function converter2(valor) {
      var numero = parseFloat(valor).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      });
      document.getElementById('valor2').value = numero;
    }
  </script>
</body>



</html>