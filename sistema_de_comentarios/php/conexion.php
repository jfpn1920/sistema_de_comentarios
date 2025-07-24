<?php
//------------------------------//
//--|conexion_a_base_de_datos|--//
//------------------------------//
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'sistema_de_comentarios';
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conexion->connect_error) {
    die("❌ No se pudo conectar a la base de datos: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
?>