<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/headConfig.php') ?>
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
      <form action="addClient.php" method="POST" class="row">

        <div class="form-box1">
          <h2>DADOS GERAIS</h2>
          <div class="line"></div>
          <div class="inputs1 row gx-3 gy-2 align-items-center">
            <div class="col-md-3">
              <label for="inputName" class="form-label">Nome:</label>
              <input type="text" class="form-control" id="inputName">
            </div>
            <div class="col-3">
              <label for="inputEmail" class="form-label">Email:</label>
              <input type="email" class="form-control" id="inputEmail" placeholder="">
            </div>
            <div class="col-md-3">
              <label for="inputPhoneNumber" class="form-label">Telefone:</label>
              <input type="text" class="form-control" id="inputPhoneNumber">
            </div>
            <div class="col-3">
              <label for="inpuZip" class="form-label">CEP:</label>
              <input type="text" class="form-control" id="inpuZip" placeholder="">
            </div>
            <div class="col-md-4">
              <label for="inputRoad" class="form-label">Rua:</label>
              <input type="text" class="form-control" id="inputRoad">
            </div>
            <div class="col-md-3">
              <label for="inputDistrict" class="form-label">Bairro:</label>
              <input type="text" class="form-control" id="inputDistrict">
            </div>
            <div class="col-md-2">
              <label for="inputCity" class="form-label">Cidade:</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="col-md-2">
              <label for="inputState" class="form-label">Estado:</label>
              <select id="inputState" class="form-select">
                <option selected>Selecionar estado...</option>
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
              <input type="text" class="form-control" id="inputCity">
            </div>

            <div class="type-user-use col-md-3">
              <p>Tipo de uso: </p>
              <div class="inputs-radio">
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="radio1" name="radio-type-use" value="option1" checked>Horista
                  <label class="form-check-label" for="radio1"></label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="radio2" name="radio-type-use" value="option2">Mensalista
                  <label class="form-check-label" for="radio2"></label>
                </div>
              </div>
            </div>

            <div class="company-use type-user-use col-md-2">
              <p>Convênio de Empresa? </p>
              <div class="inputs-radio">
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="radio1" name="company-use" value="option1" checked>Sim
                  <label class="form-check-label" for="radio1"></label>
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" id="radio2" name="company-use" value="option2">Não
                  <label class="form-check-label" for="radio2"></label>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <label for="inputCompanyUse" class="form-label">Empresa:</label>
              <select id="inpuCompanyUse" class="form-select">
                <option selected>Selecionar empresa...</option>
                <option value="RP Info">RP Info</option>
                <option value="JS Hotel">JS Hotel</option>
                <option value="Habbib's">Habbib's</option>
                <option value="Hipe">Hipe</option>
              </select>
            </div>


          </div>
        </div>

        <div class="form-box2">
          <h2>DADOS DO VEÍCULO</h2>
          <div class="line"></div>
          <div class="inputs2 row gx-3 gy-2 align-items-center">
            <div class="col-md-1">
              <label for="inputVehicleBoard" class="form-label">Placa:</label>
              <input type="text" class="form-control" id="inputVehicleBoard">
            </div>
            <div class="col-md-2">
              <label for="inputVehicleBrand" class="form-label">Marca:</label>
              <input type="text" class="form-control" id="inputVehicleBrand">
            </div>
            <div class="col-md-2">
              <label for="inputVehicleModel" class="form-label">Modelo:</label>
              <input type="text" class="form-control" id="inputVehicleModel">
            </div>
            <div class="col-md-2">
              <label for="inputVehicleColor" class="form-label">Cor:</label>
              <input type="text" class="form-control" id="inputVehicleColor">
            </div>

            <div class="col-md-2">
              <label for="inputVehicleCategory" class="form-label">Categoria:</label>
              <select id="inputVehicleCategory" class="form-select">
                <option selected>Sedan</option>
                <option value="RP Info">SUV</option>
                <option value="RP Info">Hatch</option>
                <option value="RP Info">Caminhonete</option>
                <option value="RP Info">Moto</option>
                <option value="RP Info">Caminhão</option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="inputHourOut" class="form-label">Horário Previsto de Saída:</label>
              <input type="text" class="form-control" id="inputHourOut">
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
</body>

</html>