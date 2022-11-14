<?php

define('SERVER', 'localhost');
define('USER', 'root');
define('PASSWORD', 'root');
define('DB_NAME', 'acta_nacimiento');

function getConection()
{
    $mysqli = new mysqli(
        SERVER,
        USER,
        PASSWORD,
        DB_NAME
    );

    if ($mysqli->connect_errno) {
        header('Location: error_db.php');
    } else {
        return $mysqli;
    }
}

function generateOptions($query, $valueName, $textShow)
{
    $connection = getConection();

    // get all states
    $states = $connection->query($query);

    while ($values = mysqli_fetch_array($states)) {
        echo '<option value="' . $values[$valueName] . '">' . $values[$textShow] . '</option>';
    }

    return $values;
}


function getStatesForSelect()
{
    return generateOptions("SELECT * FROM Estado", "idestado", "nombre");
}

function getNacionalidadSelect()
{
    return generateOptions("SELECT * FROM Nacionalidad", "idNacionalidad", "nombre");
}

function getMunicipiosByState($stateId)
{

    $municipios = "SELECT Municipio.nombre, Municipio.idMunicipio FROM Estado 
    INNER JOIN EstadosMunicipios ON Estado.idestado = EstadosMunicipios.idEstado
    INNER JOIN Municipio ON Municipio.idMunicipio = EstadosMunicipios.idMunicipio
    WHERE Estado.idestado = $stateId ORDER BY Municipio.nombre ASC";

    return generateOptions($municipios, 'idMunicipio', 'nombre');
}


function insertDatWithReturnID($sql)
{
    $connection = getConection();

    if ($connection->query($sql) === TRUE) {
        return mysqli_insert_id($connection);
    } else {
        return $connection->error;
    }
}

function insertDatWithReturnTrue($sql)
{
    $connection = getConection();

    if ($connection->query($sql) === TRUE) {
        return true;
    } else {
        return $connection->error;
    }
}

function selectQuery($sql)
{
    $connection = getConection();

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return 0;
    }
}


function registerNewRegisterData($ObjData)
{
    //create date
    $registerYear = strval($ObjData->registerDate['year']);
    $registerMonth = strval($ObjData->registerDate['month']);
    $registerDay = strval($ObjData->registerDate['day']);

    $registerDate = "$registerYear-" . "$registerMonth-" . "$registerDay";

    $curp = strval($ObjData->curp);
    $cerificationNumber = strval($ObjData->cerificationNumber);
    $state = intval($ObjData->state);
    $anoRegistro = intval($ObjData->registerDate['year']);
    $book = intval($ObjData->book);
    $actaNumber = intval($ObjData->actaNumber);
    $municipio = intval($ObjData->municipio);
    $oficialia = intval($ObjData->oficialia);
    $electronicIdentiier = strval($ObjData->electronicIdentiier);

    $datosRegistro = "INSERT INTO 
    `DatosRegistro`(`curp`, `numeroCertificado`, `idEntidadRegistro`, `anoRegistro`, `libro`, `numeroActa`, `idMunicipioRegistro`, `oficialia`, `fechaRegistro`, `identificadorElectronico`) VALUES 
    (
    '$curp',
    '$cerificationNumber',
    $state,
    $anoRegistro,
    $book,
    $actaNumber,
    $municipio,
    $oficialia,
    '$registerDate',
    '$electronicIdentiier'
    )";

    $insert = insertDatWithReturnTrue($datosRegistro);

    if ($insert == true) {
        //execute next register
        /* @array $filials */
        $filials = filialRegister($ObjData); //get filials to person register

        //check values in filiales
        foreach ($filials as $filial) {
            if (!is_int($filial)) {
                return "Error al ingresar datos de un filial, consulte con el administrador del sistema.";
                break;
            }
        }

        //revision si todos los elementos del arreglo son enteros
        personRegister($ObjData, $filials);

        //if elements is true insert a new person
    } else {
        return "Error al ingresar los datos de registro, consulte con el administrador del sistema."; //return error in screen
    }
}


function personRegister($objData, $filiales)
{

    $curp = strval($objData->curp);
    $name = strval($objData->name);
    $lastName1 = strval($objData->lastName1);
    $lastName2 = strval($objData->lastName2);
    $sex = intval($objData->sex);


    $birthDayYear = strval($objData->birthday['year']);
    $birthDayMonth = strval($objData->birthday['month']);
    $birthDayDay = strval($objData->birthday['day']);

    $birthDayDate = "$birthDayYear-" . "$birthDayMonth-" . "$birthDayDay";

    $filial1 = intval($filiales[0]);
    $filial2 = (count($filiales) > 1) ? intval($filiales[1]) : "NULL";

    $personaRegisterQuery = "INSERT INTO `Persona`(`curp`, `nombres`, `apellidoPaterno`, `apellidoMaterno`, `sexo`, `fechaNacimiento`, `filial1`, `filial2`) VALUES
     (
        '$curp',
        '$name',
        '$lastName1',
        '$lastName2',
        $sex,
        '$birthDayDate',
        $filial1,
        $filial2
    )";

    $insert = insertDatWithReturnTrue($personaRegisterQuery);

    if ($insert == true) {
        return 1;
    } else {
        return "error al ingresar la información de la persona, consulte con el administrador del sistema."; //return error in screen
    }
}

function filialRegister($objData)
{

    $filiales = $objData->personFiliales;
    $filials_ids = [];

    foreach ($filiales as $filial) {
        if ($filial['name'] != '' && $filial['lastName1'] != '' && $filial['lastName2'] != '') {

            $name = strval($filial['name']);
            $lastName1 = strval($filial['lastName1']);
            $lastName2 = strval($filial['lastName2']);
            $curp = !empty($filial['curp']) ? strval($filial['curp']) : "NULL";
            $sex = intval($filial['sex']);
            $idNacionalidad = intval($filial['country']);

            $filialInsertData = "INSERT INTO `Filial`(`nombres`, `apellidoPaterno`, `apellidoMaterno`, `sexo`, `curp`, `idNacionalidad`) VALUES
            (
                '$name',
                '$lastName1',
                '$lastName2',
                $sex,
                '$curp',
                $idNacionalidad
            )";

            $getIdOrErrorResult = insertDatWithReturnID($filialInsertData);
            array_push($filials_ids, $getIdOrErrorResult); //insert id or error

        }
    }

    return $filials_ids;
}

function getMunicipioName($id)
{
    $get = selectQuery("SELECT `nombre` FROM `Municipio` WHERE `idMunicipio` = $id");
    $name = '';
    while ($row = $get->fetch_assoc()) {
        $name = $row['nombre'];
    }
    return $name;
}

function getEstadoName($id)
{
    $get = selectQuery("SELECT `nombre` FROM `Estado` WHERE `idEstado` = $id");
    $name = '';
    while ($row = $get->fetch_assoc()) {
        $name = $row['nombre'];
    }
    return $name;
}

function listPersons()
{
    $getPersons = selectQuery("SELECT Persona.curp FROM Persona");

    while ($row = $getPersons->fetch_assoc()) {

        $person = getPerson($row['curp']);

        echo '
        <tr>
            <th scope="row">' . $person->curp . '</th>
            <td>' . $person->name . ' ' . $person->lastName1 . ' ' . $person->lastName2 . '</td>
            <td>' . $person->registerDate['day'] . '-' . $person->registerDate['month'] . '-' . $person->registerDate['year'] . '</td>
            <td>' . $person->municipioName . '</td>
            <td>' . $person->estadoName . '</td>
            <td>' . $person->cerificationNumber . '</td>
            <td>' . $person->book . '</td>
            <td>' . $person->actaNumber . '</td>
            <td>' . $person->oficialia . '</td>
            <td><a class="btn btn-primary" href="./view_user.php?curp=' . $person->curp . '">Ver</a></td>
      </tr>';
    }
}

function getPerson($curp)
{
    $checkCurp = "SELECT * FROM `DatosRegistro` WHERE `curp` = '$curp'";
    $datosRegistro = selectQuery($checkCurp);

    if ($datosRegistro != 0) {
        //el usuario existe dentro del sistema
        //obtenemos el registerdata;
        $datosPersona = selectQuery("SELECT * FROM `Persona` WHERE `curp` = '$curp'");

        //SELECT * FROM `Filial` WHERE `idPersona` = 29; filiales
        $filiales = [];
        while ($row = $datosPersona->fetch_assoc()) {
            $nombres = $row['nombres'];
            $apellidoPaterno = $row['apellidoPaterno'];
            $apellidoMaterno = $row['apellidoMaterno'];
            $sexoPersona = $row['sexo'];
            $orderdate = explode('-', $row['fechaNacimiento']);
            $birthdayMonth = $orderdate[0];
            $birthdayDay   = $orderdate[1];
            $birthdayYear  = $orderdate[2];
            $filial1 = $row['filial1'];
            $filial2 = $row['filial2'];
        }

        while ($row = $datosRegistro->fetch_assoc()) {
            $curp = $row['curp'];
            $numeroCertificado = $row['numeroCertificado'];
            $idEntidadRegistro = $row['idEntidadRegistro'];
            $numeroActa = $row['numeroActa'];
            $anoRegistro = $row['anoRegistro'];
            $libro = $row['libro'];
            $idMunicipioRegistro = $row['idMunicipioRegistro'];
            $oficialia = $row['oficialia'];
            $fechaRegistro = explode('-', $row['fechaRegistro']);
            $registerMonth = $fechaRegistro[0];
            $registerDay   = $fechaRegistro[1];
            $registerYear  = $fechaRegistro[2];
            $identificadorElectronico = $row['identificadorElectronico'];
        }

        //datos del filial
        $filial1 = selectQuery("SELECT * FROM `Filial` WHERE `idPersona` = $filial1");
        $filial2 = selectQuery("SELECT * FROM `Filial` WHERE `idPersona` = $filial2");

        while ($row = $filial1->fetch_assoc()) {
            $idPersonaF1 = $row['idPersona'];
            $nombresF1 = $row['nombres'];
            $apellidoPaternoF1 = $row['apellidoPaterno'];
            $apellidoMaternoF1 = $row['apellidoMaterno'];
            $sexoF1 = $row['sexo'];
            $curpF1 = $row['curp'];
            $idNacionalidadF1 = $row['idNacionalidad'];
        }

        $idPersonaF2 = '';
        $nombresF2 = '';
        $apellidoPaternoF2 = '';
        $apellidoMaternoF2 = '';
        $sexoF2 = '';
        $curpF2 = '';
        $idNacionalidadF2 = '';

        if ($filial2 != 0) {
            while ($row = $filial2->fetch_assoc()) {
                $idPersonaF2 = $row['idPersona'];
                $nombresF2 = $row['nombres'];
                $apellidoPaternoF2 = $row['apellidoPaterno'];
                $apellidoMaternoF2 = $row['apellidoMaterno'];
                $sexoF2 = $row['sexo'];
                $curpF2 = $row['curp'];
                $idNacionalidadF2 = $row['idNacionalidad'];
            }
        }



        return (object) array(
            'curp' => $curp,
            'name' => $nombres,
            'lastName1' => $apellidoPaterno,
            'lastName2' => $apellidoMaterno,
            'sex' => $sexoPersona,
            'state' => $idEntidadRegistro,
            'municipio' => $idMunicipioRegistro,
            'birthday' => array(
                'day' => $birthdayDay,
                'month' => $birthdayMonth,
                'year' => $birthdayYear,
            ),
            'personFiliales' => array(
                'person1' => array(
                    'id' => $idPersonaF1,
                    'name' => $nombresF1,
                    'lastName1' => $apellidoPaternoF1,
                    'lastName2' => $apellidoMaternoF1,
                    'curp' => $curpF1,
                    'sex' => $sexoF1,
                    'country' => $idNacionalidadF1,
                ),
                'person2' => array(
                    'id' => $idPersonaF2,
                    'name' => $nombresF2,
                    'lastName1' => $apellidoPaternoF2,
                    'lastName2' => $apellidoMaternoF2,
                    'curp' => $curpF2,
                    'sex' => $sexoF2,
                    'country' => $idNacionalidadF2,
                ),
            ),
            'cerificationNumber' => $numeroCertificado,
            'registerDate' => array(
                'day' => $registerDay,
                'month' => $registerYear,
                'year' => $registerMonth,
            ),
            'anoRegistro' => $anoRegistro,
            'book' => $libro,
            'actaNumber' => $numeroActa,
            'oficialia' => $oficialia,
            'electronicIdentiier' => $identificadorElectronico,
            'municipioName' => getMunicipioName($idMunicipioRegistro),
            'estadoName' => getEstadoName($idEntidadRegistro)
        );
    } else {
        header('Location: no_curp.php');
    }
}

function deletePerson($curp)
{
    $personDelete = getPerson($curp);
    $filial1 = $personDelete->personFiliales['person1']['id'];
    $filial2 = $personDelete->personFiliales['person2']['id'];

    insertDatWithReturnTrue("DELETE FROM `Persona` WHERE `curp` = '$curp'");
    insertDatWithReturnTrue("DELETE FROM `DatosRegistro` WHERE `curp` = '$curp'");
    insertDatWithReturnTrue("DELETE FROM `Filial` WHERE `idPersona` = $filial1");

    if ($filial2 != '') {
        insertDatWithReturnTrue("DELETE FROM `Filial` WHERE `idPersona` = $filial2");
    }
} //end delete function

function searchPerson($curp)
{
    $query = selectQuery("SELECT * FROM `Persona` WHERE `curp` LIKE '%$curp%'");

    if ($query != 0) {

?>
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
    <?php
                while ($row = $query->fetch_assoc()) {
                    $person = getPerson($row['curp']);
                    echo '
        <tr>
            <th scope="row">' . $person->curp . '</th>
            <td>' . $person->name . ' ' . $person->lastName1 . ' ' . $person->lastName2 . '</td>
            <td>' . $person->registerDate['day'] . '-' . $person->registerDate['month'] . '-' . $person->registerDate['year'] . '</td>
            <td>' . $person->municipioName . '</td>
            <td>' . $person->estadoName . '</td>
            <td>' . $person->cerificationNumber . '</td>
            <td>' . $person->book . '</td>
            <td>' . $person->actaNumber . '</td>
            <td>' . $person->oficialia . '</td>
            <td><a class="btn btn-primary" href="./view_user.php?curp=' . $person->curp . '">Ver</a></td>
      </tr>';
                }
                ?>
  </tbody>
</table>
<?php
    } else {
        echo 'no hay registros que cumplan tu busqueda.';
    }
}