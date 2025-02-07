<?php

DEFINE('DB_USER', 'USUARIO_BJ-adim');
DEFINE('DB_PASSWORD', 'SENHA-BJ-admin');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'bojoga_timeline');
/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
// Check connection
if ($con === false) {
    die("ERRO: Não é possível conectar. " . mysqli_connect_error());
}
?>