<?php 
session_start();
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
require_once('../components/verifyLogin.php');


$companyId = filter_input(INPUT_GET, 'id');

$companyDao = new CompanyDaoDB($pdo);

if($companyId) {
  $company = $companyDao->findById($companyId);
}

if($company === false) {
  header("Location: listCompanys.php");
  exit;
}

?>
<head>
  <title>Editar Empresa</title>
  <link rel="stylesheet" href="../styles/addCompany.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <?php require_once('../components/favicon.php') ?>;
</head>

<body>
  <?php 
  require_once('../components/sidebar.php');
   
  ?>

  <header class="addUser-header">
    <h1>EDITAR EMPRESA</h1>
  </header>

  <main>
    <div class="main-content">
      <?php require('../components/alertMessage.php')?>
      <form action="../actions/updateCompanyAction.php" method="POST" class="row">
        <input type="hidden" name="inputCompanyId" value="<?= $company->getId(); ?>">

        <h2>DADOS GERAIS DA EMPRESA</h2>
        <div class="line"></div>
        <div class="inputs1 row gx-3 gy-2 align-items-center">
          <div class="col-md-3">
            <label for="inputName" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="inputName" class="inputName" name="inputName" autocomplete="off" value="<?= $company->getName()?>" required>
          </div>
          <div class="col-3">
            <label for="inputEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" autocomplete="off" value="<?= $company->getEmail()?>"required>
          </div>

          <div class="col-3">
            <label for="inputPhone" class="form-label">Telefone:</label>
            <input type="text" class="form-control" id="inputPhone" name="inputPhone" maxlength="13" OnKeyPress="formatar('##-#####-####', this)" autocomplete="off" value="<?= $company->getPhone()?>"required>
          </div>

          <div class="col-3">
            <label for="inputSlots" class="form-label">Quantidade de Vagas:</label>
            <input type="number" class="form-control" id="inputSlots" name="inputSlots" placeholder="" autocomplete="off" value="<?= $company->getSlots()?>" required>
          </div>

          <div class="row mt-6 p-0 submit-box">
            <a href="../pages/listCompanys.php" class="cancel-button col-md-2">Cancelar</a>
            <input class="submit-user-button col-md-2" type="submit" value="Cadastrar">
          </div>

        </div>
      </form>
    </div>
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