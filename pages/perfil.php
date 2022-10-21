<?php
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();

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
</head>

<body>
  <?php require_once('../components/sidebar.php') ?>

  <header class="perfil-header">
    <h1>CLIENTES CADASTRADOS</h1>
  </header>

  <main>
    <div class="perfil-box container rounded shadow">
      <form action="perfil.php" method="POST">
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
                <div class="col-md-4"><label class="labels">Nome</label><input type="text" class="form-control" name="inputName" placeholder="" value="<?= $perfil->getName() ?>"></div>
                <div class="col-md-6"><label class="labels">Email</label><input type="text" class="form-control" placeholder="" name="inputEmail" value="<?= $perfil->getEmail() ?>"></div>
              </div>

              <div class="row mt-3">
                <div class="col-md-4"><label class="labels">Nova senha</label><input type="password" class="form-control" placeholder="Digite a nova senha" value=""></div> <br>
                <div class="col-md-4"><label class="labels">Confirme a nova senha</label><input type="password" class="form-control" placeholder="Digite novamente a senha" value=""></div>
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