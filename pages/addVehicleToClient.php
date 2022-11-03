<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/headConfig.php') ;
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
      <form action="../actions/clientAddAction.php" method="POST" class="row">

        <div class="form-box1">
          <h2 class="title-client">CLIENTE CADASTRADO COM SUCESSO!</h2>
          <span>Deseja cadastrar um veículo para esse cliente?</span>
          <div class="buttons-choice-box">
            <button class="button-choice yes" onclick="show()">Sim</button>
            <a class="button-choice no">Não</a>
          </div>
          <?php require('../components/alertMessage.php')?>          
        </div>

        <div class="form-box2">
          <div class="inputs1 row gx-3 gy-2 align-items-center">
            <div class="col-md-3">
              <label for="inputName" class="form-label">Nome:</label>
              <input type="text" class="form-control" name="inputName" required>
            </div>
            <div class="col-3">
              <label for="inputEmail" class="form-label">Email:</label>
              <input type="email" class="form-control" name="inputEmail" required>
            </div>
            <div class="col-md-3">
              <label for="inputPhoneNumber" class="form-label">Telefone:</label>
              <input type="text" class="form-control" name="inputPhoneNumber" maxlength="13" OnKeyPress="formatar('##-#####-####', this)" required>
            </div>
            <div class="col-3">
              <label for="inpuZip" class="form-label">CEP:</label>
              <input type="text" class="form-control" name="inputZipCode" maxlength="9" OnKeyPress="formatar('#####-###', this)"  required>
            </div>
          </div>

          <div class="col-12 buttons-group">
            <button type="" class="btn btn-primary clear-button">Limpar</button>
            <button type="submit" class="btn btn-primary submit-button">Cadastrar Cliente</button>
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
