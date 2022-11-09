<?php 
require_once('../db/config.php');
require_once('../dao/ClientDao.php');
session_start();


$clientDao = new ClientDaoDB($pdo);
$clients = $clientDao->findAll();

$clientId = filter_input(INPUT_GET, 'id');

if($clientId){
  $client = $clientDao->findById($clientId);
}

if($client === false) {
  header("Location: listClients.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once('../components/headConfig.php') ?>
  <link rel="stylesheet" href="/styles/addClient.css">
  <link rel="stylesheet" href="/styles/editClient.css">
  <title>Editar Cliente</title>
</head>


<body class="addClient-body">
  <?php 
  require_once('../components/sidebar.php');
  ?>

  <header>
    <h1>EDITAR CADASTRO DE CLIENTE</h1>
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
              <input type="text" class="form-control" id="inputName" value="<?= $client->getName() ?>">
            </div>
            <div class="col-3">
              <label for="inputEmail" class="form-label">Email:</label>
              <input type="email" class="form-control" id="inputEmail" placeholder="" value="<?= $client->getEmail() ?>">
            </div>
            <div class="col-md-3">
              <label for="inputPhoneNumber" class="form-label">Telefone:</label>
              <input type="text" class="form-control" id="inputPhoneNumber" value="<?= $client->getPhone() ?>">
            </div>
            <div class="col-3">
              <label for="inpuZip" class="form-label">CEP:</label>
              <input type="text" class="form-control" id="inpuZip" placeholder="" value="<?= $client->getCep() ?>">
            </div>
            <div class="col-md-4">
              <label for="inputRoad" class="form-label">Endereço::</label>
              <input type="text" class="form-control" id="inputRoad" value="<?= $client->getAddress() ?>">
            </div>

            <div class="type-user-use col-md-3">
              <label for="inputType" class="form-label">Tipo de Uso:</label>
              <select id="inputType" name="inputType" class="form-select" require>
                <option selected value="<?= $client->getType() ?>"><?= $client->getType() ?></option>
                <option value="Horista">Horista</option>
                <option value="Mensalista">Mensalista</option>
              </select>
      
            </div>

            <div class="company-use type-user-use col-md-2">
              <label for="inputBussinesPlan" class="form-label">Convênio de Empresa?:</label>
              <select id="inputBussinesPlan" name="inputBussinesPlan" class="form-select" require>
                <option selected value="<?= $client->getBussinesPlan() ?>"><?= $client->getBussinesPlan() ?></option>
                <option value="Não">Não</option>
                <option value="Sim">Sim</option>
              </select>
            </div>



          </div>
        </div>

        <div class="col-12 buttons-group">
          <a href="../pages/listClients.php" class="btn btn-primary cancel-button">Cancelar</a>
          <button type="submit" class="btn btn-primary submit-button">Atualizar Dados</button>
        </div>
      </form>
    </section>
  </main>
</body>

</html>