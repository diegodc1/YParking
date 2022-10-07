<head>
  <title>Adicionar Usuário</title>
  <link rel="stylesheet" href="../styles/addUser.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <?php require_once('../components/sidebar.php') ?>

  <header class="addUser-header">
    <h1>CADASTRO DE USUÁRIO</h1>
  </header>

  <main>
    <div class="main-content">
      <form action="addClient.php" method="POST" class="row">
        <h2>DADOS GERAIS</h2>
        <div class="line"></div>
        <div class="inputs1 row gx-3 gy-2 align-items-center">
          <div class="col-md-3">
            <label for="inputName" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="inputName" class="inputName">
          </div>
          <div class="col-3">
            <label for="inputEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="">
          </div>
          <div class="col-md-3">
            <label for="inputPhoneNumber" class="form-label">Telefone:</label>
            <input type="text" class="form-control" id="inputPhoneNumber" name="inputPhoneNumber">
          </div>
          <div class="col-3">
            <label for="inputOffice" class="form-label">Cargo:</label>
            <input type="text" class="form-control" id="inputOffice" name="inputOffice" placeholder="">
          </div>
          <div class="col-3">
            <label for="inputPassword" class="form-label">Senha:</label>
            <input type="text" class="form-control" id="inputPassword" name="inputPassword" placeholder="">
          </div>
          <div class="col-3">
            <label for="inputConfirmPassword" class="form-label">Confirme a senha:</label>
            <input type="text" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="">
          </div>

          <div class="type-user-use col-md-3">
            <label for="inputTypeUser" class="form-label">Tipo de usuário:</label>
            <select id="inputTypeUser" class="form-select">
              <option selected>Normal</option>
              <option>Administrador</option>
            </select>
          </div>

          <div class="row mt-3 submit-box">
            <input class="submit-user-button col-md-2" type="submit" value="Cadastrar">
          </div>

        </div>
      </form>
    </div>
  </main>
</body>

</html>