<?php 
require_once('../db/config.php');
require_once('../dao/SectionDao.php');
require_once('../dao/PriceDao.php');
session_start();
require_once('../components/verifyLogin.php');


$sectionDao = new SectionDaoDB($pdo);
$priceDao = new PriceDaoDB($pdo);

$sections = $sectionDao->findAll();
$prices = $priceDao->findAll();
// print_r($prices);
// echo $prices->getPrcCar2h();
?>


<head>
  <title>Seções do Estacionamento</title>
  <link rel="stylesheet" href="../styles/prkSection.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <?php 
  require_once('../components/sidebar.php');
   
  ?>

  <header class="addUser-header">
    <h1>INFORMAÇÕES DO ESTACIONAMENTO</h1>
  </header>

  <main class="parking-section-main">
    <div class="box1">
      <div class="main-content">
        <?php require('../components/alertMessage.php')?>
        <form action="../actions/addSectionAction.php" method="GET" class="row">
          <h2>CADASTRAR SEÇÃO </h2>
          <div class="line"></div>
          <div class="inputs1 row gx-3 gy-2 align-items-center">

            <div class="col-md-4">
              <label for="inputName" class="form-label">Nome da seção:</label>
              <input type="text" class="form-control" id="inputNameSection" autocomplete="off" class="inputNameSection" name="inputNameSection" required>
            </div>
            
            <div class="col-4">
              <label for="inputEmail" class="form-label">Quantidade de Vagas:</label>
              <input type="number" class="form-control" id="inputSlotsSection" autocomplete="off" name="inputSlotsSection" placeholder="" required>
            </div>

            <div class="col-4">
              <label for="inputSectionColor" class="form-label">Cor da seção:</label>
              <select name="inputSectionColor" id="inputSectionColor" class="form-select">
                <option value="#2ED47A" class="select-op1">Verde</option>
                <option value="#885AF8" class="select-op2">Roxo</option>
                <option value="#F7685B" class="select-op3">Vermelho</option>
                <option value="#FFB946" class="select-op4">Amarelo</option>
                <option value="#109CF1" class="select-op5">Azul</option>
              </select>
            </div>

            <div class="row mt-3 submit-box">
              <!-- <a href="../pages/listUsers.php" class="cancel-button col-md-2">Cancelar</a> -->
              <input class="submit-user-button col-md-2" type="submit" value="Cadastrar">
            </div>
          </div>
        </form>
      </div>

      <div class="main-content">
         <h2>SEÇÕES CADASTRADAS</h2>
          <div class="line"></div>
        <div class="table-list">
          <?php require('../components/alertMessage.php')?>  
          <table id="listSections" class="table" style="width:100%">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Vagas</th>
                <th>Cor</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach($sections as $section) { ?>
                  <tr>
                    <td><?= $section->getName(); ?></td>
                    <td><?= $section->getSlots(); ?></td>          
                    <td><div class="color-box" style="background-color: <?= $section->getColor(); ?>; color: <?= $section->getColor(); ?>">.</div></td>       
                    <td>
                      <div class="action-buttons">
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar"><a href="" data-bs-toggle="modal" data-bs-target="#updateSection<?= $section->getId()?>"><i class="fa-solid fa-pencil pencil"></i></a></button>
                        <button data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cancelar"><a href="" data-bs-toggle="modal" data-bs-target="#confirmDelModal<?= $section->getId()?>"><i class="fa-solid fa-ban trash"></i></a></button>
                      </div>
                    </td>
                  </tr>
                  

              <!-- Update modal-->
               <div class="modal fade modal-update-section" id="updateSection<?= $section->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content update-section-content">
                        
                        <div class="modal-header">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="modal-body-1">
                            <i class="fa-solid fa-pencil pencil modal-edt"></i>
                            <h5 class="modal-title" id="exampleModalLabel">Editar Seção</h5>
                          </div>     
                          <div class="modal-body-2 edit">
                            <form action="../actions/updateSectionAction.php?id=<?= $section->getId(); ?>" method="POST">
                              <div class="row mt-3 w-100">
                                <div class="col-md-15 box-input-edit">
                                  <label for="inputSectionName" class="form-label">Nome:</label>
                                  <input type="text" class="form-control" name="inputSectionName" autocomplete="off" value="<?= $section->getName()?>"required>
                                </div>
                              </div>
                              

                              <div class="row mt-3 w-100">
                                <div class="col-15 box-input-edit">
                                  <label for="inputEmail" class="form-label">Quantidade de Vagas:</label>
                                  <input type="number" class="form-control" id="inputSlotsSection" autocomplete="off" name="inputSlotsSection" placeholder="" value="<?= $section->getSlots()?>" required>
                                </div>
                              </div>
                              
                              <div class="row mt-3 w-100">
                                <div class="col-md-15 box-input-edit">
                                  <label for="inputSectionColor" class="form-label">Cor da seção:</label>
                                  <select name="inputSectionColor" id="inputSectionColor" class="form-select">
                                    <option value="<?= $section->getColor()?>" class="select-op1">Atual</option>
                                    <option value="#2ED47A" class="select-op1">Verde</option>
                                    <option value="#885AF8" class="select-op2">Roxo</option>
                                    <option value="#F7685B" class="select-op3">Vermelho</option>
                                    <option value="#FFB946" class="select-op4">Amarelo</option>
                                    <option value="#109CF1" class="select-op5">Azul</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                          <input type="submit" class="btn  confirm-checkin-button" value="Confirmar"> 
                        </div>
                        </form>
                      </div>
                  </div>
                </div>

              <!-- Confirm delete modal-->
              <div class="modal fade" id="confirmDelModal<?= $section->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="modal-body-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h5 class="modal-title" id="exampleModalLabel">Desativar Seção</h5>
                      </div>
                      <div class="modal-body-2">
                        <p class="p-modal-warning">Você realmente deseja desativar esta seção?</p>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a href="../actions/deleteSectionAction.php?id=<?= $section->getId(); ?>" class="btn btn-primary button-confirm-modal">Excluir</a>
                    </div>
                  </div>
              </div>

              <?php } ?>
            </tbody>
          </table>
        </div>  
      </div>
    </div>

    <div class="box2">
        <h2><P>PREÇOS</P></h2>
        <div class="line"></div>

        <form method="POST" action="../actions/pricesParkingAction.php">
          <div class="prices-box">
            <div class="car-prices">
              <h3>Carro</h3>
              <div class="price-car">
                <p>Até 15min: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="car15Price" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCar15())?>" required> 
                </div>
             
              </div>

              <div class="price-car">
                <p>De 15min a 30min: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="car30Price" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCar30())?>" required>
                </div>
              </div>

              <div class="price-car">
                <p>De 30min a 1h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="car1hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCar1h())?>" required>
                </div>
              </div>

              <div class="price-car">
                <p>De 1h a 2h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="car2hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCar2h())?>" required>
                </div>
              </div>

              <div class="price-car">
                <p>De 2h a 3h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="car3hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCar3h())?>" required>
                </div>
              </div>

              <div class="price-car">
                <p>De 3h a 6h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="car6hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCar6h())?>" required>
                </div>
              </div>

              <div class="price-car">
                <p>Diária: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="carDayPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCarDay())?>" required>
                </div>
              </div>

              <div class="price-car">
                <p>Hora adicional: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="carAdditionalPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcCarAdditional())?>" required>
                </div>
              </div>
            </div>

            <div class="motorcycle-prices">
              <h3>Moto</h3>

              <div class="motorcycle-price">
                <p>Até 15min: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbike15Price" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbike15())?>" required>
                </div>
              </div>

              <div class="motorcycle-price">
                <p>De 15min a 30min: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbike30Price" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbike30())?>" required>
                </div>
              </div>

              <div class="motorcycle-price">
                <p>De 30min a 1h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbike1hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbike1h())?>" required>
                </div>
              </div>

              <div class="motorcycle-price">
                <p>De 1h a 2h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbike2hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbike2h())?>" required>
                </div>
              </div>

              <div class="motorcycle-price">
                <p>De 2h a 3h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbike3hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbike3h())?>" required>
                </div>
              </div>

              <div class="motorcycle-price">
                <p>De 3h a 6h: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbike6hPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbike6h())?>" required>
                </div>
              </div>

              <div class="motorcycle-price">
                <p>Diária: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbikeDayPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbikeDay())?>">
                </div>
              </div>

              <div class="motorcycle-price">
                <p>Hora adicional: </p>
                <div class="input-price-box">
                  <span>R$</span>
                  <input type="text" name="mtbikeAdditionalPrice" value="<?= preg_replace('/[R\$\" "]+/', '', $prices->getPrcMtbikeAdditional())?>">
                </div>
              </div>
            </div>
          </div>

          <div class="buttons-price">
            <a type="submit" class="btn-price" data-bs-toggle="modal" data-bs-target="#confirmUpdPrices">Atualizar</a>
          </div>

            <!-- Confirm delete modal-->
          <div class="modal fade" id="confirmUpdPrices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="modal-body-1">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h5 class="modal-title" id="exampleModalLabel">Atualizar Preços</h5>
                  </div>
                  <div class="modal-body-2 priceModal">
                    <p class="p-modal-warning"><span>Você realmente deseja atualizar os preços?</p>
                    <label for="inputPassword">Informe sua senha:</label>
                    <input type="password" name="inputPassword" class="inputPassword">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
                  <input type="submit" class="btn-price" value="Atualizar">
                </div>
              </div>
            </div>
          </div>
        </form>
    </div>
  </main>

  

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/dataTable.js"></script>


</body>

</html>

