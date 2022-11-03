<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/headConfig.php') ;
  session_start();?>
  <link rel="stylesheet" href="/styles/addClient.css">
  <title>Cadastrar Cliente </title>
</head>


<body class="addClient-body">
  <?php require_once('../components/sidebar.php') ?>

  <header>
    <h1>CADASTRO DE CLIENTE</h1>
  </header>

  <main>
    <section class="client-info">
      <form action="../actions/clientAddAction.php" method="POST" class="row">

        <div class="form-box1">
          <h2>DADOS GERAIS</h2>
          <?php require('../components/alertMessage.php')?>
          <div class="line"></div>
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
            <div class="col-md-4">
              <label for="inputRoad" class="form-label">Rua:</label>
              <input type="text" class="form-control" name="inputRoad" required>
            </div>
            <div class="col-md-3">
              <label for="inputDistrict" class="form-label">Bairro:</label>
              <input type="text" class="form-control" name="inputDistrict" required>
            </div>
            <div class="col-md-2">
              <label for="inputCity" class="form-label">Cidade:</label>
              <input type="text" class="form-control" name="inputCity" require>
            </div>
            <div class="col-md-2">
              <label for="inputState" class="form-label">Estado:</label>
              <select name="inputState" class="form-select" require>
                <option value="AC" selected>Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espirito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MT">Mato Grosso</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
              </select>
            </div>
            <div class="col-md-1">
              <label for="inputCity" class="form-label">Numero:</label>
              <input type="text" class="form-control" name="inputNumber" require>
            </div>

            <div class="col-md-2">
              <label for="inputType" class="form-label">Tipo de Uso:</label>
              <select id="inputType" name="inputType" class="form-select" require>
                <option selected value="Horista">Horista</option>
                <option value="Mensalista">Mensalista</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="inputBussinesPlan" class="form-label">Convênio de Empresa?:</label>
              <select id="inputBussinesPlan" name="inputBussinesPlan" class="form-select" require>
                <option selected value="Não">Não</option>
                <option value="Sim">Sim</option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="inputCompanyUse" class="form-label">Empresa:</label>
              <select name="inputCompanyUse" class="form-select" require>
                <option selected value="">Selecionar empresa...</option>
                <option value="1">RP Info</option>
                <option value="2">JS Hotel</option>
                <option value="3">Habbib's</option>
                <option value="4">Hipe</option>
              </select>
            </div>


          </div>
        </div>
          </div>
        </div>

        <div class="col-12 buttons-group">
          <button type="" class="btn btn-primary clear-button">Limpar</button>
          <button type="submit" class="btn btn-primary submit-button">Cadastrar Cliente</button>
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
  </script>
</body>

</html>