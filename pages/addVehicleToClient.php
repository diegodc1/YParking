<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/headConfig.php') ;
  $idClient = filter_input(INPUT_GET, 'lastId');
  session_start();?>
  <link rel="stylesheet" href="/styles/addVehicleToClient.css">
  <title>Cliente Cadastrado!</title>
</head>


<body class="addClient-body">
  <?php require_once('../components/sidebar.php') ?>

  <header>
    <h1>Cliente Cadastrado!</h1>
  </header>

  <main>
  

    <section class="client-info">
        <div class="form-box1">
          <h2 class="title-client">CLIENTE CADASTRADO COM SUCESSO!</h2>
          <span>Deseja cadastrar um veículo para esse cliente?</span>
          <div class="buttons-choice-box">
            <button class="button-choice yes" onclick="show()">Sim</button>
            <a class="button-choice no" href="addClient.php">Não</a>
          </div>
          <?php require('../components/alertMessage.php')?>          
        </div>
      <form action="../actions/addVehicleToClientAction.php?lastId=<?=$idClient?>" method="POST" class="row">
        <div class="form-box2">
          <h2>DADOS DO VEÍCULO</h2>
          <div class="line"></div>
          <div class="inputs1 row gx-3 gy-2 align-items-center">
            <div class="col-md-2">
              <label for="inputVehicleBrand" class="form-label">Marca:</label>
              <input type="text" class="form-control" name="inputVehicleBrand">
            </div>
            <div class="col-md-3">
              <label for="inputVehicleModel" class="form-label">Modelo:</label>
              <input type="text" class="form-control" name="inputVehicleModel">
            </div>
            <div class="col-md-2">
              <label for="inputVehiclePlate" class="form-label">Placa:</label>
              <input type="text" class="form-control" name="inputVehiclePlate">
            </div>
            <div class="col-md-2">
              <label for="inputVehicleColor" class="form-label">Cor:</label>
              <input type="text" class="form-control" name="inputVehicleColor">
            </div>

            <div class="col-md-2">
              <label for="inputVehicleCategory" class="form-label">Categoria:</label>
              <select name="inputVehicleCategory" class="form-select">
                <option selected>Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Hatch">Hatch</option>
                <option value="Caminhonete">Caminhonete</option>
                <option value="Moto">Moto</option>
                <option value="Caminhao">Caminhão</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="inputHourOut" class="form-label">Horário Previsto de Saída:</label>
              <input type="text" class="form-control" name="inputHourOut">
            </div>

          <div class="col-12 buttons-group">
            <button type="reset" class="btn btn-primary clear-button">Limpar</button>
            <button type="submit" class="btn btn-primary submit-button">Cadastrar </button>
          </div>
        </div>
      </form>
    </section>
  </main>
  <script>
    function formatar(mascara, documento) {
      var i = documento.value.length;
      var saida = mascara.substring(0, 1);
      var texto = mascara.substring(i)

      if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
      }

    }

    function show() {
      document.querySelector('.form-box2').style.display = "flex";
    }

  </script>


</body>

</html>
