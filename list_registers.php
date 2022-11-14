<?php include('./header.php'); ?>
<div class="container">
  <br>
  <h1>Listado de actas de nacimiento</h1>
  <br>
  <form class="form-inline d-flex">
    <input id="inputSearch" class="form-control" type="search" placeholder="Search"
      aria-label="Busca una curp en especifico">
  </form>
</div>
<br><br>
<div class="container table-responsive" id="searchResults">
<table class="table">
    <thead>
      <tr>
        <th scope="col-2">Curp</th>
        <th scope="col">Nombre</th>
        <th scope="col">FechaRegistro</th>
        <th scope="col">Municipio</th>
        <th scope="col">Estado</th>
        <th scope="col">Certificado</th>
        <th scope="col">Libro</th>
        <th scope="col">No Acta</th>
        <th scope="col">Oficialía</th>
        <th scope="col">Ver</th>
      </tr>
    </thead>
    <tbody>
      <?php listPersons(); ?>
    </tbody>
  </table>
</div>

<?php include('./footer.php'); ?>