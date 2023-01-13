<?php 
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
session_start();
require_once('../components/verifyLogin.php');



$companyDao = new CompanyDaoDB($pdo);
$companys = $companyDao->findAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/favicon.php') ?>;
  <?php require_once('../components/headConfig.php') ?>;

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
          <h2>DADOS GERAIS DO CLIENTE</h2>
          <?php require('../components/alertMessage.php')?>
          <div class="line"></div>
          <div class="inputs1 row gx-3 gy-2 align-items-center">
            <div class="col-md-3">
              <label for="inputName" class="form-label">Nome:</label>
              <input type="text" class="form-control" name="inputName" autocomplete="off" required>
            </div>
            <div class="col-3">
              <label for="inputEmail" class="form-label">Email:</label>
              <input type="email" class="form-control" name="inputEmail" autocomplete="off" required>
            </div>
            <div class="col-md-3">
              <label for="inputPhoneNumber" class="form-label">Telefone:</label>
              <input type="text" class="form-control" name="inputPhoneNumber" maxlength="13" OnKeyPress="formatar('##-#####-####', this)" autocomplete="off" required>
            </div>
            <div class="col-3">
              <label for="inpuZip" class="form-label">CEP:</label>
              <input type="text" class="form-control" name="inputZipCode" id="inputZipCode" maxlength="9" OnKeyPress="formatar('#####-###', this)" onblur="pesquisacep(this.value);"  autocomplete="off" required>
              <p class="message-cep-error" id="message-cep-error">CEP inválido!</p>
            </div>
            <div class="col-md-4">
              <label for="inputRoad" class="form-label">Rua:</label>
              <input type="text" class="form-control" name="inputRoad" id="inputRoad" autocomplete="off" required>
            </div>
            <div class="col-md-3">
              <label for="inputDistrict" class="form-label">Bairro:</label>
              <input type="text" class="form-control" name="inputDistrict" id="inputDistrict" autocomplete="off" required>
            </div>
            <div class="col-md-2">
              <label for="inputCity" class="form-label">Cidade:</label>
              <input type="text" class="form-control" name="inputCity" id="inputCity" autocomplete="off"required>
            </div>
            <div class="col-md-2">
              <label for="inputState" class="form-label">Estado:</label>
              <select name="inputState" id="inputState" class="form-select" required>
                <option value="" selected></option>
                <option value="AC">Acre</option>
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
              <input type="text" class="form-control" name="inputNumber" autocomplete="off" required>
            </div>

            <div class="col-md-2">
              <label for="inputType" class="form-label">Tipo de Uso:</label>
              <select id="inputType" name="inputType" class="form-select" required onclick="showInput1()">
                <option selected value="Horista">Horista</option>
                <option value="Mensalista">Mensalista</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="inputBussinesPlan" id="labelInputBussinesPlan" class="form-label">Convênio de Empresa?:</label>
              <select id="inputBussinesPlan" name="inputBussinesPlan" class="form-select" required onclick="showInput()">
                <option selected value="Não">Não</option>
                <option value="Sim">Sim</option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="inputCompanyUse" id="labelCompanyInput" class="form-label">Empresa:</label>
              <select name="inputCompanyUse" id="inputCompanyUse" class="form-select">
                <option selected value="0">Selecionar empresa...</option>
                <?php foreach($companys as $company) { ?>
                  <option value="<?= $company->getId(); ?>"><?= $company->getName(); ?></option>
                <?php }?>
              </select>
            </div>


          </div>
        </div>
          </div>
        </div>

        <div class="col-12 buttons-group">
          <button type="reset" class="btn btn-primary clear-button">Limpar</button>
          <button type="submit" class="btn btn-primary submit-button" id="continue-button">Continuar</button>
        </div>
      </form>
    </section>
  </main>
  <script>
    function showInput() {
      var inputCompany =  document.querySelector("#inputCompanyUse");
      var labelCompany = document.querySelector("#labelCompanyInput");
      var valueSelect = document.querySelector("#inputBussinesPlan").value;

      if(valueSelect == 'Não') {
        inputCompany.style.display = 'none';
        labelCompany.style.display = 'none';
      } else if(valueSelect == 'Sim') {
        inputCompany.style.display = 'flex';
        labelCompany.style.display = 'flex';
      }
    }

    function showInput1() {
      var inputBussines =  document.querySelector("#inputBussinesPlan");
      var labelInputBussines = document.querySelector("#labelInputBussinesPlan");
      var valueSelect = document.querySelector("#inputType").value;

      if(valueSelect == 'Horista') {
        inputBussines.style.display = 'none';
        labelInputBussines.style.display = 'none';
      } else if(valueSelect == 'Mensalista') {
        inputBussines.style.display = 'flex';
        labelInputBussines.style.display = 'flex';
      }
    }

    function formatar(mascara, documento) {
      var i = documento.value.length;
      var saida = mascara.substring(0, 1);
      var texto = mascara.substring(i)

      if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
      }

    }
  </script>
  <script src="../js/searchCep.js"></script>
</body>

</html>