<?php

//error_log("no se ha podido completar la solicitud como se esperaba, contacte al administrador para mas informacion");
//echo print_r((object) $_POST['json'][0]);
//echo filialRegister((object) $_POST['json'][0]);

include('functions.php');

//print_r((object) $_POST['json'][0]);

sleep(1);

echo registerNewRegisterData((object) $_POST['json'][0]);