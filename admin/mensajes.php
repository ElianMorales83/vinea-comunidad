<?php
/**
 * Vinea Comunidad — Buzón de Mensajes de Notaría
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../api/config.php';

$pdo = get_db_connection();

// Consultar mensajes
$mensajes = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY created_at DESC LIMIT 50");
        $mensajes = $stmt->fetchAll();
    } catch (PDOException $e) {
        $mensajes = [];
    }
}

if (empty($mensajes)) {
    $mensajes = [
        [
            'id' => 1,
            'nombre' => 'Ana Laura Sánchez [SUPUESTO]',
            'email' => 'ana.sanchez@gmail.com',
            'telefono' => '2381122334',
            'asunto' => 'Informes de catequesis infantil 2026',
            'mensaje' => 'Buenas tardes, quisiera saber cuándo inician las inscripciones para el segundo año de catequesis de mi hijo.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzón de Mensajes — Panel Pastoral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-nav { background-color: #1e3a8a; border-bottom: 3px solid #d97706; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark admin-nav sticky-top py-2">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
            <i class="bi bi-shield-check text-warning me-2 fs-4"></i> Vinea Comunidad · Panel
        </a>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="intenciones.php"><i class="bi bi-journal-bookmark me-1"></i> Oración de los Fieles</a></li>
                <li class="nav-item"><a class="nav-link" href="eventos.php"><i class="bi bi-calendar-event me-1"></i> Calendario</a></li>
                <li class="nav-item"><a class="nav-link" href="citas.php"><i class="bi bi-clock-history me-1"></i> Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="muro_admin.php"><i class="bi bi-fire me-1"></i> Muro</a></li>
                <li class="nav-item"><a class="nav-link active" href="mensajes.php"><i class="bi bi-envelope me-1"></i> Mensajes</a></li>
            </ul>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Salir</a>
        </div>
    </div>
</nav>

<main class="container py-4">
    <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">
        Buzón de Mensajes de Notaría
    </h1>
    <p class="text-muted mb-4">Consultas directas recibidas desde el portal web</p>

    <div class="card shadow-sm border-0 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>Fecha</th>
                        <th>Remitente</th>
                        <th>Contacto</th>
                        <th>Asunto y Mensaje</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <?php foreach ($mensajes as $m): ?>
                        <tr>
                            <td><?= substr($m['created_at'], 0, 16) ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($m['nombre']) ?></td>
                            <td>
                                <div><i class="bi bi-envelope text-primary me-1"></i> <?= htmlspecialchars($m['email']) ?></div>
                                <?php if (!empty($m['telefono'])): ?>
                                    <div><i class="bi bi-telephone text-success me-1"></i> <?= htmlspecialchars($m['telefono']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong class="text-dark"><?= htmlspecialchars($m['asunto']) ?></strong>
                                <p class="text-muted mb-0 mt-1"><?= nl2br(htmlspecialchars($m['mensaje'])) ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
