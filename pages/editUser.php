<?php  
session_start();
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
require_once('../components/verifyLogin.php');
require_once('../components/verifyAdmAccess.php');



$usuarioDao= new UsuarioDaoDB($pdo);

$user = false;

$id = filter_input(INPUT_GET, 'id');

if($id) {
  $user = $usuarioDao->findById($id);
}

if($user === false) {
  header("Location: listUsers.php");
  exit;
}

?>
<head>
  <title>Editar Usuário</title>
  <link rel="stylesheet" href="../styles/addUser.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <?php require_once('../components/favicon.php') ?>;
</head>

<body>
  <?php 
  require_once('../components/verifyAdmAccess.php'); 
  require_once('../components/sidebar.php');
 ?>

  <header class="addUser-header">
    <h1>EDITAR USUÁRIO</h1>
  </header>

  <main>
    <div class="main-content">
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
      <?php 
        if(isset($_SESSION['insert_user_message'])) {
          ?>
            <div class="alert alert-<?php echo $_SESSION['message-type'] ?> col-md-4 alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="<?php echo $_SESSION['icon-message'] ?>"/></svg>
              <?php echo $_SESSION['insert_user_message']?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php
          unset($_SESSION['insert_user_message']);
          echo "<script> let div = document.querySelector('.alert');
            function removeAlert() {
              let div = document.querySelector('.alert').style.display=\"none\";
            }
          
            setTimeout(removeAlert, 4000);
          </script>";
        }
      ?>
      <form action="../actions/updateUserAction.php" method="POST" class="row">
        <h2>DADOS GERAIS</h2>
        <div class="line"></div>
        <div class="inputs1 row gx-3 gy-2 align-items-center">
          <input type="hidden" name="inputUserId" value="<?= $user->getId(); ?>">

          <div class="col-md-3">
            <label for="inputName" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="inputName" class="inputName" name="inputName" value="<?= $user->getName(); ?>" required>
          </div>
          <div class="col-3">
            <label for="inputEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?= $user->getEmail(); ?>" required>
          </div>

          <div class="col-3">
            <label for="inputFunction" class="form-label">Cargo:</label>
            <select id="inputFunction" class="form-select" name="inputFunction">
              <option selected value="<?= $user->getFunction(); ?>"><?= $user->getFunction(); ?></option>
              <option value="Manobrista">Manobrista</option>
              <option value="Operador de Estac.">Operador de Estacionamento</option>
              <option value="Caixa">Caixa</option>
              <option value="Gerente">Gerente</option>
            </select> 
          </div>
          <div class="type-user-use col-md-3">
            <label for="inputAccess" class="form-label">Tipo de usuário:</label>
            <select id="inputAccess" class="form-select" name="inputAccess">
              <?php 
                if($user->getAccess() === 1) { ?>
                  <option selected  value="1">Administrador</option>
                  <option value="0">Comum</option>
                <?php } else { ?>
                  <option selected value="0">Comum</option>
                  <option value="1">Administrador</option>
                <?php } ?>
            </select>
          </div>

          <div class="mt-5 submit-box">
            <a href="../pages/listUsers.php" class="cancel-button col-md-2">Cancelar</a>
            <input class="submit-user-button col-md-2" type="submit" value="Atualizar Cadastro">
          </div>
        </div>
      </form>
    </div>
  </main>
</body>

</html>