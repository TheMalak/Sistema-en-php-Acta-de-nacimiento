<?php
    include('./header.php');
    $curp = $_GET['curp'];
    deletePerson($curp); //delete person to the database
?>

<div class="container">
    <br><br>
        <div class="row m-auto">
            <h1>Eliminación completada</h1>
            <p>El usuario con el CURP <?php echo $curp; ?> ha sido eliminado de manera exitosa.</p>
            <a class="btn btn-primary" href="./index.php">Regresar al registro</a>
        </div>
    <br><br>
</div>


<?php include('./footer.php'); ?>