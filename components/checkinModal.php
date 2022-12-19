<!------------------------- Ckeck-in modal--------------------------->
  <div class="modal fade" id="checkinModal<?= $vehicle->getId()?>" tabindex="-1" aria-labelledby="exampleodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="modal-body-1">
            <i class="fa-solid fa-square-parking"></i>
            <h5 class="modal-title" id="exampleModalLabel">Selecione uma seção para o veículo</h5>
          </div>

          <div class="modal-body-2">
            <section class="occupation">
              <div class="boxes-occupation">
                <?php 
                  foreach($sections as $section) { 
                    $sectionSlots = $section->getSlots();
                    $checkinDaily = $checkinDao->returnSlotsCkeckin($section->getId());
                    $fillPorcent = round(($checkinDaily * 100) / $sectionSlots) . "%";
                    ?>

                    <div class="box-occu 1">

                      <div class="box-occu-header" style="background-color: <?= $section->getColor(); ?>">
                        <span><?= $section->getName(); ?></span>
                      </div>

                      <div class="line-info">
                        <p>Ocupação: <span style="color: <?= $section->getColor(); ?>"><?= $fillPorcent ?></span></p>
                        <div class="line-occupation">
                          <div class="fill-line" style="background-color: <?= $section->getColor()?>; width:<?= $fillPorcent?>" ></div>
                        </div>
                      </div>

                      <?php if($fillPorcent == '100%') { ?>
                          <a href="../actions/checkinAction.php?vehicle=<?=$vehicle->getId()?>&section=<?= $section->getId(); ?>" class="select-section-button" style="pointer-events: none; opacity: 0.5">Selecionar</a> 
                      <?php } else { ?>
                        <a href="../actions/checkinAction.php?vehicle=<?=$vehicle->getId()?>&section=<?= $section->getId(); ?>" class="select-section-button">Selecionar</a>
                      <?php } ?>        
                    </div>                                 
                  <?php } ?>
              </div>
            </section>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Cancelar</button>
        </div>

      </div>
    </div>
  </div>