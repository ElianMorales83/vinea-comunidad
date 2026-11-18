<?php
/**
 * Vinea Comunidad — Consolidado para la Oración de los Fieles y Gestión Pastoral (Módulo 6)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../api/config.php';

$pdo = get_db_connection();
$mensaje_accion = '';

// Procesar marcado de "Mencionada en Misa" (RF-29, RF-30)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_mencionada'])) {
    $intencion_id = (int)$_POST['intencion_id'];
    $misa_info = clean_string($_POST['misa_info'] ?? 'Misa dominical 12:00 PM');
    
    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare("UPDATE intenciones_muro 
                                   SET mencionada_en_misa = 1, mencionada_fecha_hora = NOW(), mencionada_nota = :nota 
                                   WHERE id = :id");
            $stmt->execute([':nota' => $misa_info, ':id' => $intencion_id]);

            // Obtener datos de contacto para seguimiento pastoral (RF-30)
            $stmtInt = $pdo->prepare("SELECT autor_nombre, email_contacto, peticion FROM intenciones_muro WHERE id = :id");
            $stmtInt->execute([':id' => $intencion_id]);
            $intencionData = $stmtInt->fetch();

            if ($intencionData && !empty($intencionData['email_contacto'])) {
                $asunto = "Tu intención fue presentada en la Santa Misa - Parroquia María Madre de Dios";
                $cuerpo = "<p>Estimado(a) {$intencionData['autor_nombre']}:</p>"
                    . "<p>Te compartimos con alegría y esperanza cristiana que hoy el sacerdote elevó tu intención comunitaria: <em>\"{$intencionData['peticion']}\"</em> ante el altar durante la <strong>{$misa_info}</strong>.</p>"
                    . "<p>Seguimos unidos en oración fraterna.<br><strong>Parroquia María Madre de Dios (Tehuacán)</strong></p>";
                enviar_correo_notificacion($intencionData['email_contacto'], $asunto, $cuerpo);
            }

            $mensaje_accion = "Intención marcada como 'Mencionada en misa' correctamente.";
        } catch (PDOException $e) {
            $mensaje_accion = "Error al actualizar la intención.";
        }
    } else {
        $mensaje_accion = "Intención marcada como 'Mencionada en misa' (modo local).";
    }
}

// Cargar intenciones activas clasificadas
$intenciones = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM intenciones_muro 
                             WHERE estado_moderacion = 'aprobada' 
                             ORDER BY mencionada_en_misa ASC, fecha_publicacion DESC");
        $intenciones = $stmt->fetchAll();
    } catch (PDOException $e) {
        $intenciones = [];
    }
}

if (empty($intenciones)) {
    // Datos de muestra para visualización
    $intenciones = [
        [
            'id' => 1,
            'autor_nombre' => 'Familia Gómez Méndez',
            'es_anonimo' => 0,
            'categoria' => 'Salud',
            'peticion' => 'Pedimos la intercesión de la Virgen María por la pronta recuperación y salud de nuestra abuela Rosa hospitalizada.',
            'email_contacto' => 'familia.gomez@gmail.com [SUPUESTO]',
            'whatsapp_contacto' => '522381234567',
            'oraciones_recibidas' => 12,
            'mencionada_en_misa' => 0,
            'mencionada_nota' => null,
            'fecha_publicacion' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'autor_nombre' => 'Anónimo',
            'es_anonimo' => 1,
            'categoria' => 'Trabajo',
            'peticion' => 'Por la providencia divina para conseguir empleo y llevar sustento digno a mi familia.',
            'email_contacto' => null,
            'whatsapp_contacto' => null,
            'oraciones_recibidas' => 18,
            'mencionada_en_misa' => 1,
            'mencionada_nota' => 'Mencionada en Misa Dominical 12:00 PM',
            'fecha_publicacion' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 3,
            'autor_nombre' => 'Marta Elena [SUPUESTO]',
            'es_anonimo' => 0,
            'categoria' => 'Difuntos',
            'peticion' => 'Por el eterno descanso de Don Roberto en el tercer mes de su partida al Reino de Dios.',
            'email_contacto' => 'marta.elena@hotmail.com [SUPUESTO]',
            'whatsapp_contacto' => '522389876543',
            'oraciones_recibidas' => 7,
            'mencionada_en_misa' => 0,
            'mencionada_nota' => null,
            'fecha_publicacion' => date('Y-m-d H:i:s')
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oración de los Fieles — Panel Pastoral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-nav { background-color: #1e3a8a; border-bottom: 3px solid #d97706; }
        .misa-card { border-left: 4px solid #1e3a8a; }
        .misa-card.mencionada { border-left-color: #166534; opacity: 0.85; background: #f0fdf4; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 12pt; }
            .card { border: 1px solid #ccc !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark admin-nav sticky-top py-2 no-print">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
            <i class="bi bi-shield-check text-warning me-2 fs-4"></i> Vinea Comunidad · Panel
        </a>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="intenciones.php"><i class="bi bi-journal-bookmark me-1"></i> Oración de los Fieles</a></li>
                <li class="nav-item"><a class="nav-link" href="eventos.php"><i class="bi bi-calendar-event me-1"></i> Calendario</a></li>
                <li class="nav-item"><a class="nav-link" href="citas.php"><i class="bi bi-clock-history me-1"></i> Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="muro_admin.php"><i class="bi bi-fire me-1"></i> Muro</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <button onclick="window.print()" class="btn btn-outline-light btn-sm me-2">
                    <i class="bi bi-printer me-1"></i> Imprimir para Misa
                </button>
                <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Salir</a>
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">
                Consolidado: Oración de los Fieles
            </h1>
            <p class="text-muted mb-0">Peticiones comunitarias de la feligresía para la liturgia dominical</p>
        </div>
        <div class="no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm shadow-sm" style="background-color: var(--color-primary);">
                <i class="bi bi-printer me-1"></i> Imprimir Guion Litúrgico
            </button>
        </div>
    </div>

    <?php if (!empty($mensaje_accion)): ?>
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            <i class="bi bi-check-circle me-1"></i> <?= htmlspecialchars($mensaje_accion) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="alert alert-info py-2 no-print small">
        <i class="bi bi-info-circle me-1"></i> 
        <strong>Guía pastoral:</strong> Al marcar <em>"Mencionada en misa"</em>, si el feligrés dejó correo se le enviará un aviso de agradecimiento; si dejó WhatsApp, se habilita el botón verde para enviarle el mensaje con un solo clic.
    </div>

    <div class="row g-3">
        <?php foreach ($intenciones as $item): ?>
            <div class="col-12">
                <div class="card misa-card shadow-sm p-3 <?= $item['mencionada_en_misa'] ? 'mencionada' : '' ?>">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <span class="badge bg-secondary me-2"><?= htmlspecialchars($item['categoria']) ?></span>
                            <span class="fw-bold text-dark">
                                <?= $item['es_anonimo'] ? 'Anónimo (Feligrés de la comunidad)' : htmlspecialchars($item['autor_nombre']) ?>
                            </span>
                            <span class="text-muted small ms-2">
                                <i class="bi bi-fire text-warning"></i> <?= (int)$item['oraciones_recibidas'] ?> oraciones unidas
                            </span>
                        </div>
                        <div>
                            <?php if ($item['mencionada_en_misa']): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check2-circle me-1"></i> Mencionada en misa: <?= htmlspecialchars($item['mencionada_nota'] ?? '') ?>
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendiente de celebración</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <blockquote class="blockquote fs-6 text-dark mb-3 ps-3 border-start border-3 border-warning">
                        "<?= nl2br(htmlspecialchars($item['peticion'])) ?>"
                    </blockquote>

                    <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 border-top no-print">
                        <div class="small text-muted">
                            <?php if (!empty($item['whatsapp_contacto'])): ?>
                                <span class="me-3">
                                    <i class="bi bi-whatsapp text-success me-1"></i> WhatsApp: <?= htmlspecialchars($item['whatsapp_contacto']) ?>
                                    <?php 
                                        $msgWA = urlencode("Paz y bien, te saludamos de la Parroquia María Madre de Dios. Te compartimos con alegría que tu intención comunitaria fue presentada hoy ante el altar durante la Santa Misa.");
                                    ?>
                                    <a href="https://wa.me/<?= preg_replace('/\D/', '', $item['whatsapp_contacto']) ?>?text=<?= $msgWA ?>" 
                                       target="_blank" class="btn btn-outline-success btn-sm ms-1 py-0 px-2">
                                        <i class="bi bi-send me-1"></i> Avisar por WhatsApp
                                    </a>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($item['email_contacto'])): ?>
                                <span><i class="bi bi-envelope text-primary me-1"></i> <?= htmlspecialchars($item['email_contacto']) ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if (!$item['mencionada_en_misa']): ?>
                            <form method="POST" action="intenciones.php" class="d-flex gap-2">
                                <input type="hidden" name="intencion_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="marcar_mencionada" value="1">
                                <select name="misa_info" class="form-select form-select-sm" style="width: auto;">
                                    <option value="Misa dominical 08:00 AM">Misa dominical 08:00 AM</option>
                                    <option value="Misa dominical 10:00 AM">Misa dominical 10:00 AM</option>
                                    <option value="Misa dominical 12:00 PM" selected>Misa dominical 12:00 PM</option>
                                    <option value="Misa dominical 19:00 PM">Misa dominical 07:00 PM</option>
                                    <option value="Capilla del Observatorio Sábado 18:00 PM">Capilla del Observatorio Sáb 18:00 PM</option>
                                    <option value="Capilla del Observatorio Domingo 11:00 AM">Capilla del Observatorio Dom 11:00 AM</option>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-lg me-1"></i> Marcar Mencionada
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
