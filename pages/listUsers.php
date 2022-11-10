<?php 
require_once('../db/config.php');
require_once('../dao/UsuarioDao.php');
session_start();


$usuarioDao = new UsuarioDaoDB($pdo);
$users = $usuarioDao->findAll();

?>

<head>
  <title>Clientes Cadastrados</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/listUsers.css">
</head>

<body>
  <?php require_once("../components/sidebar.php") ?>

  <header class="list-users-header">
    <h1>USUÁRIOS CADASTRADOS</h1>
  </header>

  <main>

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
    
    <div class="main-content">
      <div class="button-box">
        <p></p>
        <?php 
        if(isset($_SESSION['insert_user_message'])) {
          ?>
            <div class="alert alert-<?php echo $_SESSION['message-type'] ?> col-md-4 alert-dismissible fade show message-box" role="alert">
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
        } else { ?>
            <p></p>
        <?php } ?>
        <a href="/pages/addUser.php" class="add-user-button">Cadastrar Usuário</a>
      </div>

      <div class="table-list">
        <table id="listClientsVehicles" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Cargo</th>
              <th>Nível de acesso</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($users as $user) { ?>
                <tr>
                  <td><?= $user->getName(); ?></td>
                  <td><?= $user->getEmail(); ?></td>
                  <td><?= $user->getFunction(); ?></td>
                  <td><?php if($user->getAccess() == 1) {
                      echo "Admim";
                  } else {
                    echo "Comum";
                  } ?></td>
                  <td>
                    <div class="action-buttons">
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar"><a href="../pages/editUser.php?id=<?= $user->getId(); ?>"><i class="fa-solid fa-eye eye"></i></a></button>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="../pages/editUser.php?id=<?= $user->getId(); ?>"><i class="fa-solid fa-pencil pencil"></i></a></button>
                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDelModal"><i class="fa-solid fa-trash-can trash"></i></a></button>
                    </div>
                  </td>
                </tr>
              <?php } ?>
          </tbody>

        </table>
      </div>
    </div>
  </main>

  <!-- Confirm delete modal-->
  <div class="modal fade" id="confirmDelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="modal-body-1">
            <i class="fa-solid fa-circle-exclamation"></i>
            <h5 class="modal-title" id="exampleModalLabel">Excluir este usuário?</h5>
          </div>
          <div class="modal-body-2">
            <p class="p-modal-warning"><span>Atenção!</span> Não será possível reverter essa ação!</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
          <a href="../actions/deleteUserAction.php?id=<?= $user->getId(); ?>" class="btn btn-primary button-confirm-modal" >Excluir</a>
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/dataTable.js"></script>

</body>



</html>