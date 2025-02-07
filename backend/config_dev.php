<?php

DEFINE('DB_USER_DEV', 'USUARIO');
DEFINE('DB_PASSWORD_DEV', 'SENHA');
DEFINE('DB_HOST_DEV', 'localhost');
DEFINE('DB_NAME_DEV', 'blogs');

//conexão conforme padrão do site
$con_dev = mysqli_connect(DB_HOST_DEV, DB_USER_DEV, DB_PASSWORD_DEV, DB_NAME_DEV);
//conexão mais segura
$conn_dev_stmt = new mysqli(DB_HOST_DEV, DB_USER_DEV, DB_PASSWORD_DEV, DB_NAME_DEV);

if ($conn_dev_stmt->connect_error) {
    die("Erro de conexão: " . $conn_dev_stmt->connect_error);
}
 
// Check connection
if ($con_dev === false) {
    die("ERRO: Não é possível conectar. " . mysqli_connect_error());
}
?>