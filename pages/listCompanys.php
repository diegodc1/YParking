<?php
require_once('../db/config.php');
require_once('../dao/CompanyDao.php');
require_once('../dao/ClientDao.php');
session_start();
require_once('../components/verifyLogin.php');


$companyDao = new CompanyDaoDB($pdo);
$clientDao = new ClientDaoDB($pdo);
$companys = $companyDao->findAll(); 



$clientDao = new ClientDaoDB($pdo);

?>

<head>
  <title>Empresas Cadastradas</title>

  <!-- Bootstrap -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

  <!-- Data Table style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/listCompanys.css">

     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>

<body>
  <?php 
  require_once("../components/sidebar.php") ;
    ?>

  <header class="list-clients-header">
    <h1>EMPRESAS CADASTRADAS</h1>
  </header>

  <main>
    <div class="main-content">
      <div class="button-box">
        <a href="dashboard.php" class="btn back-button"><i class="fa-solid fa-arrow-left"></i>Voltar</a>
        <a href="/pages/addCompany.php" class="add-user-button">Cadastrar Empresa</a>
      </div>

      <div class="table-list">
        <?php require('../components/alertMessage.php')?>
        <table id="listCompanys" class="table" style="width:100%">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Telefone</th>
              <th>Funcionários</th>
              <th>Vagas Reservadas</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            
            <?php 
              foreach($companys as $company) { 
                $qtdClients= $clientDao->findByClientIdQtd($company->getId());
                $clientCompanyQtd = $clientDao->findByClientIdQtd($company->getId()); ?>
                <tr>
                  <td><?= $company->getName();?></td>
                  <td><?= $company->getEmail();?></td>
                  <td><?= $company->getPhone();?></td>
                  <td><?= $qtdClients ?></td>
                  <td><?= $company->getSlots();?></td>
                  <td><?= $company->getStatus() ?></td>
                  <td class="td-buttons">
                    <div class="action-buttons">

                      <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="../pages/editCompany.php?id=<?= $company->getId(); ?>"><i class="fa-solid fa-pencil pencil"></i></a></button>

                      <?php if($company->getStatus() == 'Ativo') {?>
                        <!-- Botão de desativar Empresa  -->
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDisModal<?= $company->getId()?>"><i class="fa-solid fa-ban trash"></i></a></button>

                        <!-- Confirm delete modal-->
                        <div class="modal fade" id="confirmDisModal<?= $company->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="modal-body-1">
                                  <i class="fa-solid fa-circle-exclamation"></i>
                                  <h5 class="modal-title" id="exampleModalLabel">Desativar esta empresa?</h5>
                                </div>
                                <div class="modal-body-2">
                                  <p class="p-modal-warning">Você realmente deseja desativar essa empresa?</p>
                                  <p class="p-modal-warning">Nome: <span><?= $company->getName()?></span></p>
                                  <p class="p-modal-warning">Clientes Vinculados: <span><?= $clientCompanyQtd ?></span></p>
                                  <p class="p-modal-warning">Vagas Reservadas: <span><?= $company->getSlots() ?></span></p>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                                <a href="../actions/disableCompanyAction.php?id=<?= $company->getId(); ?>" class="btn btn-primary button-confirm-modal">Desativar</a>
                              </div>
                            </div>
                        </div> 
                      <?php } else {?>
                        <!-- Botão de reativar Empresa  -->
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Excluir"><a href="" data-bs-toggle="modal" data-bs-target="#confirmActModal<?= $company->getId()?>"><i class="fa-solid fa-power-off reactivate"></i></a></button>

                        <!-- Reativar Empresa Modal -->
                        <div class="modal fade" id="confirmActModal<?= $company->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="modal-body-1">
                                  <i class="fa-solid fa-circle-exclamation"></i>
                                  <h5 class="modal-title" id="exampleModalLabel">Reativar esta empresa?</h5>
                                </div>
                                <div class="modal-body-2">
                                  <p class="p-modal-warning">Você realmente deseja reativar esta empresa?</p>
                                  <p class="p-modal-warning">Nome: <span><?= $company->getName()?></span></p>
                                  <p class="p-modal-warning">Vagas Reservadas: <span><?= $company->getSlots() ?></span></p>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                                <a href="../actions/reacivateCompanyAction.php?id=<?= $company->getId(); ?>" class="btn btn-primary button-confirm-modal act">Reativar</a>
                              </div>
                            </div>
                        </div>
                      <?php } ?>
                    </div>
                  </td>
                </tr>
             <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
 
  <script src="../js/dataTable.js"></script>

</body>



</html>