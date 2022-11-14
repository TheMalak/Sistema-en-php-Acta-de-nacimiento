<div class="container mt-5">
  <div class="row">
    <div class="col-md-12">
      <h1>Acta de nacimiento Registro.</h1>
    </div>

    <?php include('./form.php'); ?>


    <div class="modal fade" id="completedModal" tabindex="-1" aria-labelledby="completedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="completedModalLabel">Registro de ciudadano con éxito</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body  m-auto d-flex">
            <a class="btn btn-primary text-center" id="viewDataInserted">Ver datos registrados.</a>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="loadingModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loadingModalLabel">Registrando por favor espere</h5>
          </div>
          <div class="modal-body  m-auto d-flex">
            <img width="100" src="./assets/loading.gif">
          </div>
        </div>
      </div>
    </div>

  </div>
</div>