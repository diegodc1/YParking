 <!-- Total Price -->
  <div  class="modal fade" id="totalValue" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content checkout">

        <div class="modal-header checkout">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="modal-body-1">
              <img src="../assets/imgs/icon-checkout.png" alt="" class="checkout-img">
              <h5 class="modal-title" id="exampleModalLabel">Valor total</h5>
            </div>

            <div class="modal-body-2">
              <?php 
                  $lastCkoutId = $_SESSION['lastCkoutId'];
                  unset($_SESSION['lastCkoutId']);
                  $lastCheckOut = $checkoutDao->findById($lastCkoutId);
              ?>

              <div class="div-line"></div>

              <section class="price-value-sec">
                <p>Valor Total: </p>
                <p class="price-value"><?= $lastCheckOut->getTotalValue()?></p>
              </section>
            </div>
          </div>

          <div class="modal-footer ckout">
            <button type="button" class="btn btn-secondary button-cancel-modal" data-bs-dismiss="modal">Confirmar</button>
          </div>
        </div>

      </div>
    </div>
  </div>
