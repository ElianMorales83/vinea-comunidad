<?php
/**
 * Vinea Comunidad — Moderación y Supervisión del Muro de Oraciones (RF-31)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../api/config.php';

$pdo = get_db_connection();
$mensaje_estado = '';

// Procesar moderación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['intencion_id'])) {
    $intencion_id = (int)$_POST['intencion_id'];
    $accion = $_POST['accion'] ?? '';

    if ($pdo !== null) {
        try {
            if ($accion === 'ocultar') {
                $stmt = $pdo->prepare("UPDATE intenciones_muro SET estado_moderacion = 'oculta' WHERE id = :id");
                $stmt->execute([':id' => $intencion_id]);
                $mensaje_estado = "La petición fue ocultada de la vista pública.";
            } elseif ($accion === 'aprobar') {
                $stmt = $pdo->prepare("UPDATE intenciones_muro SET estado_moderacion = 'aprobada' WHERE id = :id");
                $stmt->execute([':id' => $intencion_id]);
                $mensaje_estado = "La petición fue aprobada para el muro.";
            } elseif ($accion === 'eliminar') {
                $stmt = $pdo->prepare("DELETE FROM intenciones_muro WHERE id = :id");
                $stmt->execute([':id' => $intencion_id]);
                $mensaje_estado = "La petición fue eliminada de la base de datos.";
            }
        } catch (PDOException $e) {
            $mensaje_estado = "Error al procesar moderación.";
        }
    } else {
        $mensaje_estado = "Acción procesada (modo local).";
    }
}

// Consultar todas las intenciones
$intenciones = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT * FROM intenciones_muro ORDER BY fecha_publicacion DESC LIMIT 100");
        $intenciones = $stmt->fetchAll();
    } catch (PDOException $e) {
        $intenciones = [];
    }
}

if (empty($intenciones)) {
    $intenciones = [
        [
            'id' => 1,
            'autor_nombre' => 'Familia Gómez Méndez',
            'es_anonimo' => 0,
            'categoria' => 'Salud',
            'peticion' => 'Pedimos la intercesión de la Virgen María por la salud de nuestra abuela Rosa.',
            'oraciones_recibidas' => 12,
            'estado_moderacion' => 'aprobada',
            'fecha_publicacion' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'autor_nombre' => 'Anónimo',
            'es_anonimo' => 1,
            'categoria' => 'Trabajo',
            'peticion' => 'Por la providencia divina para conseguir empleo y llevar sustento a mi familia.',
            'oraciones_recibidas' => 18,
            'estado_moderacion' => 'aprobada',
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
    <title>Moderación del Muro — Panel Pastoral</title>
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
                <li class="nav-item"><a class="nav-link active" href="muro_admin.php"><i class="bi bi-fire me-1"></i> Muro</a></li>
            </ul>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Salir</a>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">
                Moderación del Muro de Oraciones
            </h1>
            <p class="text-muted mb-0">Supervisión pastoral para proteger la dignidad, el respeto y la privacidad</p>
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
                        <th>Fecha</th>
                        <th>Autor</th>
                        <th>Categoría</th>
                        <th>Petición</th>
                        <th>Oraciones</th>
                        <th>Estado</th>
                        <th>Moderación</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <?php foreach ($intenciones as $row): ?>
                        <tr>
                            <td><?= substr($row['fecha_publicacion'], 0, 10) ?></td>
                            <td class="fw-semibold">
                                <?= $row['es_anonimo'] ? '<em>Anónimo</em>' : htmlspecialchars($row['autor_nombre']) ?>
                            </td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($row['categoria']) ?></span></td>
                            <td style="max-width: 320px;">
                                <div class="text-truncate" title="<?= htmlspecialchars($row['peticion']) ?>">
                                    <?= htmlspecialchars($row['peticion']) ?>
                                </div>
                            </td>
                            <td><span class="badge bg-warning text-dark"><i class="bi bi-fire me-1"></i> <?= (int)$row['oraciones_recibidas'] ?></span></td>
                            <td>
                                <?php if ($row['estado_moderacion'] === 'aprobada'): ?>
                                    <span class="badge bg-success">Visible</span>
                                <?php elseif ($row['estado_moderacion'] === 'oculta'): ?>
                                    <span class="badge bg-danger">Oculta</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" action="muro_admin.php" class="d-flex gap-1">
                                    <input type="hidden" name="intencion_id" value="<?= $row['id'] ?>">
                                    <?php if ($row['estado_moderacion'] === 'aprobada'): ?>
                                        <button type="submit" name="accion" value="ocultar" class="btn btn-outline-warning btn-sm" title="Ocultar del muro">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" name="accion" value="aprobar" class="btn btn-outline-success btn-sm" title="Hacer visible">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    <?php endif; ?>
                                    <button type="submit" name="accion" value="eliminar" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('¿Seguro que deseas eliminar esta petición?');" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
