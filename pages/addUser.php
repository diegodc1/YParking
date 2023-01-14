
<head>
  <title>Adicionar Usuário</title>
  <link rel="stylesheet" href="../styles/addUser.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <?php require_once('../components/favicon.php') ?>;

</head>

<body>
  <?php 
  session_start();
  require_once('../components/verifyLogin.php');
  require_once('../components/verifyAdmAccess.php');
  require_once('../components/sidebar.php');
  ?>

  <header class="addUser-header">
    <h1>CADASTRO DE USUÁRIO</h1>
  </header>

  <main>
    <div class="main-content">
      <?php require('../components/alertMessage.php')?>
      <form action="../actions/addUserAction.php" method="POST" class="row">
        <h2>DADOS GERAIS</h2>
        <div class="line"></div>
        <div class="inputs1 row gx-3 gy-2 align-items-center">
          <div class="col-md-3">
            <label for="inputName" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="inputName" autocomplete="off" class="inputName" name="inputName" required>
          </div>
          <div class="col-3">
            <label for="inputEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="inputEmail" autocomplete="off" name="inputEmail" placeholder="" required>
          </div>

          <div class="col-3">
            <label for="inputFunction" class="form-label">Cargo:</label>
            <select id="inputFunction" class="form-select" name="inputFunction">
              <option selected value="Manobrista">Manobrista</option>
              <option value="Operador de Estac.">Operador de Estacionamento</option>
              <option value="Caixa">Caixa</option>
              <option value="Gerente">Gerente</option>
            </select>
          </div>
          <div class="col-3">
            <label for="inputPassword" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="" required>
          </div>
          <div class="col-3">
            <label for="inputConfirmPassword" class="form-label">Confirme a senha:</label>
            <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="" required>
          </div>
<div class="type-user-use col-md-3">
            <label for="inputAccess" class="form-label">Nível de Acesso:</label>
            <select id="inputAccess" class="form-select" name="inputAccess">
              <option selected value="0">Normal</option>
              <option value="1">Administrador</option>
            </select>
          </div>
          

          <div class="row mt-3 submit-box">
            <a href="../pages/listUsers.php" class="cancel-button col-md-2">Cancelar</a>
            <input class="submit-user-button col-md-2" type="submit" value="Cadastrar">
          </div>

        </div>
      </form>
    </div>
  </main>
</body>

</html>