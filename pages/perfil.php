<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();
require_once('../components/verifyLogin.php');


$usuarioDao = new UsuarioDaoDB($pdo);

$userPerfil = false;

$id = $_SESSION['user_id'];

if($id) {
  $perfil = $usuarioDao->findById($id);
}

if($perfil === false) {
  header("Location: ../pages/dashboard.php");
  exit;
}
?>

<head>
  <link rel="stylesheet" href="../styles/perfil.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <?php require_once('../components/favicon.php') ?>;
  <title>Perfil</title>
</head>

<body>
  <?php require_once('../components/sidebar.php') ?>

  <header class="perfil-header">
    <h1>CLIENTES CADASTRADOS</h1>
  </header>

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
    </div>

  <main>

    <div class="perfil-box container rounded shadow">
      
      <form action="../actions/updatePerfilAction.php" method="POST">
        <?php 
        if(isset($_SESSION['insert_user_message'])) {
          ?>
            <div class="alert mt-4 mb-0 alert-<?php echo $_SESSION['message-type'] ?> col-md-4 alert-dismissible fade show" role="alert">
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
          
            setTimeout(removeAlert, 5000);
          </script>";
        }
      ?>
        <div class="row d-flex align-items-center">
          <div class="col-md-2 box-user">
            <div class="d-flex flex-column align-items-center text-center p-8 py-5"><img class="rounded-circle" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?= $perfil->getName() ?></span><span class="text-black-50"><?= $perfil->getEmail() ?></span><span> </span></div>
          </div>
          <div class="col-md-9 box-info">
            <div class="p-3 py-5">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-right">Informações de perfil</h4>
              </div>
              <div class="row mt-2">
                <input type="hidden" name="inputPerfilId" value="<?= $perfil->getId(); ?>">
                <div class="col-md-4"><label class="labels">Nome</label><input type="text" class="form-control" name="inputName" placeholder="" value="<?= $perfil->getName() ?>"></div>
                <div class="col-md-6"><label class="labels">Email</label><input type="text" class="form-control" placeholder="" name="inputEmail" value="<?= $perfil->getEmail() ?>"></div>
              </div>

              <div class="row mt-3">
                <div class="col-md-4"><label class="labels">Nova senha</label><input type="password" name="inputPerfilPassword" class="form-control" placeholder="Digite a nova senha" value=""></div> <br>
                <div class="col-md-4"><label class="labels">Confirme a nova senha</label><input type="password" name="inputConfirmPassword" class="form-control" placeholder="Digite novamente a senha" value=""></div>
              </div>
              <div class="row mt-4 submit-box">
                <input class="submit-button col-md-2" type="submit" value="Atualizar Perfil">
              </div>
            </div>
          </div>
        </div>
    </div>
    </form>
    </div>
    </div>
    </div>
  </main>
</body>