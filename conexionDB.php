<?php

$host = 'localhost';
$usuarioHost = 'root';
$pass = '';
$nombreBaseDatos = 'yates';

// Conexión al servicio de la base de datos
$conn = mysqli_connect($host, $usuarioHost, $pass) or die("no es posible la conexión"); // conn es un objeto de conexion que lleva metodos y propiedades para utilizar la base de datos


// seleccionar la base de datos de todas las que pueda haber
$conexion_BBDD = mysqli_select_db($conn, $nombreBaseDatos) or die("no es posible la selección de la base");
