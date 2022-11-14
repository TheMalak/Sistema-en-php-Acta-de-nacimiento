<?php include('./header.php'); ?>

<?php
$curp = $_GET['curp'];
//$objPerson = getPerson($curp);
if ($curp == '') {
  header('Location: no_curp.php');
}
?>

<div class="d-none" id="curpVal"><?php echo $curp; ?></div>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-12">
      <h1>Listado de Acta <?php echo $curp; ?></h1>
    </div>

    <div id="form-list">
      <?php include('./form.php'); ?>
    </div>


    <div class="options-in-view-person d-flex justify-content-center">
    <button style="margin-right: 20px;" id="buttonDelete" class="btn btn-danger mr-3">Eliminar</button>
        <a href="./list_registers.php" id="buttonBack" class="d-none btn btn-primary">Regresar a lista</a>
    </div>
    <br><br>
    <br><br>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Esta seguro de eliminar el registro ?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Esta seguro que quiere eliminar el acta con curp <?php echo $curp; ?>, esta acción no se puede revertir.
          </div>
          <div class="modal-footer">
            <button id="closeModalDelete" type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">Cerrar</button>
            <a href="./delete_action.php?curp=<?php echo $curp; ?>" type="button" class="btn btn-danger">Eliminar</a>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="modal fade" id="loadingDeleteModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loadingDeleteModalLabel">Eliminando por favor espere</h5>
          </div>
          <div class="modal-body  m-auto d-flex">
            <img width="100" src="./assets/loading.gif">
          </div>
        </div>
      </div>
    </div> -->

    <!-- eliminationCompleted -->
    <!-- <div class="modal fade" id="eliminationCompleted" data-toggle="modal" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="eliminationCompletedLabel">Acta Eliminada con éxito</h5>
          </div>
          <div class="modal-body  m-auto d-flex">
            <p>El acta con el curp <?php echo $curp; ?> ha sido eliminada de manera satisfactoria</p>
          </div>
        </div>
      </div>
    </div> -->

    <?php include('./footer.php'); ?>