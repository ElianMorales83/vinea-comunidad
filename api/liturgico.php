<?php
/**
 * Vinea Comunidad — API de Calendario Litúrgico Oficial (RF-16)
 */
require_once __DIR__ . '/config.php';

$pdo = get_db_connection();
$fecha = isset($_GET['fecha']) ? clean_string($_GET['fecha']) : date('Y-m-d');

$info_liturgica = null;

if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT fecha, tiempo_liturgico, color_liturgico, santoral_celebracion, grado_celebracion 
                               FROM calendario_liturgico WHERE fecha = :fecha");
        $stmt->execute([':fecha' => $fecha]);
        $info_liturgica = $stmt->fetch();
    } catch (PDOException $e) {
        $info_liturgica = null;
    }
}

// Fallback canónico si no está en la base de datos
if (!$info_liturgica) {
    $info_liturgica = [
        'fecha' => $fecha,
        'tiempo_liturgico' => 'Tiempo Ordinario',
        'color_liturgico' => 'verde',
        'santoral_celebracion' => 'Santos del Día / Memoria Litúrgica [SUPUESTO]',
        'grado_celebracion' => 'Feria'
    ];
}

json_response('success', $info_liturgica, 'Información litúrgica del día recuperada.');
