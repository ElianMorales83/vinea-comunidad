<?php
/**
 * Vinea Comunidad — Gestión Administrativa de Citas Pastorales (RF-14, RF-22)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../api/config.php';

$pdo = get_db_connection();
$mensaje_estado = '';

// Procesar cambio de estado de cita (atendida, confirmada, cancelada)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cita_id'])) {
    $cita_id = (int)$_POST['cita_id'];
    $nuevo_estado = clean_string($_POST['nuevo_estado'] ?? 'atendida');
    
    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare("UPDATE citas SET estado = :estado WHERE id = :id");
            $stmt->execute([':estado' => $nuevo_estado, ':id' => $cita_id]);
            $mensaje_estado = "Estado de la cita actualizado a '{$nuevo_estado}'.";
        } catch (PDOException $e) {
            $mensaje_estado = "Error al actualizar la cita.";
        }
    } else {
        $mensaje_estado = "Cita actualizada (modo local).";
    }
}

// Consultar citas
$citas = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM citas ORDER BY fecha_solicitada ASC LIMIT 100");
        $citas = $stmt->fetchAll();
    } catch (PDOException $e) {
        $citas = [];
    }
}

if (empty($citas)) {
    $citas = [
        [
            'id' => 1,
            'nombre_solicitante' => 'Carlos Alberto Mendoza [SUPUESTO]',
            'telefono' => '2381234567',
            'email' => 'carlos.mendoza@gmail.com',
            'tipo_cita' => 'preparacion_matrimonial',
            'fecha_solicitada' => '2026-10-15',
            'hora_solicitada' => '16:00:00',
            'motivo' => 'Apertura de expediente y pláticas prematrimoniales.',
            'estado' => 'solicitada'
        ],
        [
            'id' => 2,
            'nombre_solicitante' => 'María Guadalupe Ramos [SUPUESTO]',
            'telefono' => '2389876543',
            'email' => 'guadalupe.ramos@hotmail.com',
            'tipo_cita' => 'pastoral_parroco',
            'fecha_solicitada' => '2026-10-16',
            'hora_solicitada' => '17:30:00',
            'motivo' => 'Dirección y acompañamiento espiritual con el párroco.',
            'estado' => 'confirmada'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Citas — Panel Pastoral</title>
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
                <li class="nav-item"><a class="nav-link active" href="citas.php"><i class="bi bi-clock-history me-1"></i> Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="muro_admin.php"><i class="bi bi-fire me-1"></i> Muro</a></li>
            </ul>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Salir</a>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">
                Agenda de Citas Pastorales y Notariales
            </h1>
            <p class="text-muted mb-0">Atención personal y trámites de sacramentos</p>
        </div>
    </div>

    <?php if (!empty($mensaje_estado)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> <?= htmlspecialchars($mensaje_estado) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Solicitante</th>
                        <th>Contacto</th>
                        <th>Tipo / Motivo</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <?php foreach ($citas as $c): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($c['fecha_solicitada']) ?></strong><br>
                                <span class="text-muted"><?= substr($c['hora_solicitada'], 0, 5) ?> hrs</span>
                            </td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($c['nombre_solicitante']) ?></div>
                            </td>
                            <td>
                                <div><i class="bi bi-telephone text-success me-1"></i> <?= htmlspecialchars($c['telefono']) ?></div>
                                <div class="text-muted"><i class="bi bi-envelope text-primary me-1"></i> <?= htmlspecialchars($c['email']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-secondary mb-1"><?= htmlspecialchars($c['tipo_cita']) ?></span>
                                <div class="text-muted"><?= htmlspecialchars($c['motivo']) ?></div>
                            </td>
                            <td>
                                <?php if ($c['estado'] === 'solicitada'): ?>
                                    <span class="badge bg-warning text-dark">Solicitada</span>
                                <?php elseif ($c['estado'] === 'confirmada'): ?>
                                    <span class="badge bg-primary">Confirmada</span>
                                <?php elseif ($c['estado'] === 'atendida'): ?>
                                    <span class="badge bg-success">Atendida</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Cancelada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" action="citas.php" class="d-flex gap-1">
                                    <input type="hidden" name="cita_id" value="<?= $c['id'] ?>">
                                    <?php if ($c['estado'] === 'solicitada'): ?>
                                        <button type="submit" name="nuevo_estado" value="confirmada" class="btn btn-outline-primary btn-sm" title="Confirmar">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($c['estado'] !== 'atendida'): ?>
                                        <button type="submit" name="nuevo_estado" value="atendida" class="btn btn-success btn-sm" title="Marcar Atendida">
                                            <i class="bi bi-check-all"></i> Atendida
                                        </button>
                                    <?php endif; ?>
                                </form>
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
