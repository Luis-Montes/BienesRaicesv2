<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'bienesraices');

    if (!$db) {
        echo 'Error de conexion';
        exit;
    }

    return $db;

}