<?php
header('Content-Type: application/json');
require_once 'conexion.php';
try {
    if (!isset($conexion)) {
        $conexion = new mysqli($host, $usuario, $clave, $bd);
        if ($conexion->connect_error) {
            http_response_code(500);
            echo json_encode(['error' => 'Error de conexión a la base de datos']);
            exit;
        }
    }
    //-------------------------------------------//
    //--|obtener_los_comentarios_mas_recientes|--//
    //-------------------------------------------//
    $sql = "SELECT nombre, mensaje, fecha FROM comentarios ORDER BY fecha DESC";
    $resultado = $conexion->query($sql);
    //-------------------------------//
    //--|almacenar_los_comentarios|--//
    //-------------------------------//
    $comentarios = [];
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $comentarios[] = [
                'nombre' => htmlspecialchars($fila['nombre']),
                'mensaje' => htmlspecialchars($fila['mensaje']),
                'fecha' => $fila['fecha']
            ];
        }
    }
    //----------------------//
    //--|enviar_respuesta|--//
    //----------------------//
    echo json_encode($comentarios, JSON_UNESCAPED_UNICODE);
    $conexion->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>