<?php

include('functions.php');

$id_state = $_POST['id_state'];

echo getMunicipiosByState($id_state);