
<head>
  <title>Informações Estacionamento</title>
  <link rel="stylesheet" href="../styles/addUser.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <?php 
  session_start();
  require_once('../components/sidebar.php');
   
  ?>

  <header class="addUser-header">
    <h1>CADASTRAR SEÇÕES</h1>
  </header>

  <main>
    <div class="main-content">
      <?php require('../components/alertMessage.php')?>
      <form action="../actions/addSectionAction.php" method="POST" class="row">
        <h2>DADOS DA SEÇÃO</h2>
        <div class="line"></div>
        <div class="inputs1 row gx-3 gy-2 align-items-center">

          <div class="col-md-3">
            <label for="inputName" class="form-label">Nome da seção:</label>
            <input type="text" class="form-control" id="inputNameSection" autocomplete="off" class="inputNameSection" name="inputNameSection" required>
          </div>
          
          <div class="col-3">
            <label for="inputEmail" class="form-label">Quantidade de Vagas:</label>
            <input type="number" class="form-control" id="inputSlotsSection" autocomplete="off" name="inputSlotsSection" placeholder="" required>
          </div>

          <div class="col-2">
            <label for="inputEmail" class="form-label">Cor da seção:</label>
            <input type="color" class="form-control" id="inputSectionColor" autocomplete="off" name="inputSectionColor" placeholder="" required>
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