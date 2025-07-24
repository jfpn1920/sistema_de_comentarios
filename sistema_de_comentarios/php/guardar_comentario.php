<?php
require_once 'conexion.php';
//------------------------------------------//
//--|verificar_si_se_recibieron_los_datos|--//
//------------------------------------------//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    if ($nombre === '' || $mensaje === '') {
        echo "⚠️ Faltan campos obligatorios.";
        exit;
    }
    //--------------------------------------------//
    //--|ejecutar_los_datos_en_la_base_de_datos|--//
    //--------------------------------------------//
    $stmt = $conexion->prepare("INSERT INTO comentarios (nombre, mensaje) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $mensaje);
    if ($stmt->execute()) {
        echo "✅ Comentario guardado correctamente.";
    } else {
        echo "❌ Error al guardar el comentario: " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
} else {
    echo "❌ Acceso no válido.";
}
?>