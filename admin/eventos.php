<?php
/**
 * Vinea Comunidad — Gestión Administrativa de Calendario y Fechas Fijas (RF-17)
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../api/config.php';

$pdo = get_db_connection();
$mensaje_estado = '';

// Procesar nuevo evento o actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = clean_string($_POST['titulo'] ?? '');
    $capilla_id = (int)($_POST['capilla_id'] ?? 1);
    $tipo_evento = clean_string($_POST['tipo_evento'] ?? 'festividad_peregrinacion');
    $fecha_inicio = clean_string($_POST['fecha_inicio'] ?? date('Y-m-d'));
    $hora_inicio = clean_string($_POST['hora_inicio'] ?? '12:00:00');
    $descripcion = clean_string($_POST['descripcion'] ?? '');
    $es_fecha_fija = !empty($_POST['es_fecha_fija']) ? 1 : 0;

    if (!empty($titulo) && !empty($fecha_inicio)) {
        if ($pdo !== null) {
            try {
                $stmt = $pdo->prepare("INSERT INTO eventos (capilla_id, titulo, tipo_evento, fecha_inicio, hora_inicio, descripcion, es_fecha_fija, creado_por) 
                                       VALUES (:capilla, :titulo, :tipo, :fecha, :hora, :desc, :fija, :user)");
                $stmt->execute([
                    ':capilla' => $capilla_id,
                    ':titulo'  => $titulo,
                    ':tipo'    => $tipo_evento,
                    ':fecha'   => $fecha_inicio,
                    ':hora'    => $hora_inicio,
                    ':desc'    => $descripcion,
                    ':fija'    => $es_fecha_fija,
                    ':user'    => $_SESSION['usuario_id'] ?? 1
                ]);
                $mensaje_estado = "Evento litúrgico publicado exitosamente en el calendario.";
            } catch (PDOException $e) {
                $mensaje_estado = "Error al guardar en la base de datos.";
            }
        } else {
            $mensaje_estado = "Evento registrado exitosamente (modo local).";
        }
    }
}

// Consultar eventos existentes
$eventos = [];
if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT e.*, c.nombre AS capilla_nombre 
                             FROM eventos e JOIN capillas c ON e.capilla_id = c.id 
                             ORDER BY e.fecha_inicio DESC LIMIT 50");
        $eventos = $stmt->fetchAll();
    } catch (PDOException $e) {
        $eventos = [];
    }
}

if (empty($eventos)) {
    $eventos = [
        [
            'id' => 1,
            'capilla_nombre' => 'Templo Parroquial María Madre de Dios',
            'titulo' => 'Celebración Comunitaria de Confirmación',
            'tipo_evento' => 'fecha_fija_sacramento',
            'fecha_inicio' => '2026-11-15',
            'hora_inicio' => '11:00:00',
            'es_fecha_fija' => 1,
            'descripcion' => 'Fecha fija comunitaria oficial presidida por el Vicario. [SUPUESTO]'
        ],
        [
            'id' => 2,
            'capilla_nombre' => 'Templo Parroquial María Madre de Dios',
            'titulo' => 'Celebración Comunitaria de Primera Comunión',
            'tipo_evento' => 'fecha_fija_sacramento',
            'fecha_inicio' => '2026-11-22',
            'hora_inicio' => '10:00:00',
            'es_fecha_fija' => 1,
            'descripcion' => 'Fecha fija comunitaria oficial de Primeras Comuniones. [SUPUESTO]'
        ],
        [
            'id' => 3,
            'capilla_nombre' => 'Capilla del Observatorio (Sectores 14 y 15)',
            'titulo' => 'Celebración de Bautismo',
            'tipo_evento' => 'sacramento_comunitario',
            'fecha_inicio' => '2026-10-31',
            'hora_inicio' => '12:00:00',
            'es_fecha_fija' => 0,
            'descripcion' => 'Misa comunitaria de bautismos.'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Calendario — Panel Pastoral</title>
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
                <li class="nav-item"><a class="nav-link active" href="eventos.php"><i class="bi bi-calendar-event me-1"></i> Calendario</a></li>
                <li class="nav-item"><a class="nav-link" href="citas.php"><i class="bi bi-clock-history me-1"></i> Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="muro_admin.php"><i class="bi bi-fire me-1"></i> Muro</a></li>
            </ul>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Salir</a>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">
                Gestor del Calendario Litúrgico y Eventos
            </h1>
            <p class="text-muted mb-0">Publicación de fechas fijas de sacramentos, peregrinaciones y misas por capilla</p>
        </div>
    </div>

    <?php if (!empty($mensaje_estado)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> <?= htmlspecialchars($mensaje_estado) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Formulario para Agregar Evento -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 p-4 bg-white">
                <h2 class="h5 fw-bold mb-3 text-primary" style="font-family: var(--font-heading);">
                    <i class="bi bi-calendar-plus me-1 text-warning"></i> Nuevo Evento Parroquial
                </h2>
                <form method="POST" action="eventos.php">
                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-semibold">Título del Evento o Celebración</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" 
                               placeholder="Ej.: Celebración Comunitaria de Confirmación" required>
                    </div>

                    <div class="mb-3">
                        <label for="capilla_id" class="form-label fw-semibold">Sede o Capilla</label>
                        <select class="form-select" id="capilla_id" name="capilla_id" required>
                            <option value="1">Templo Parroquial María Madre de Dios</option>
                            <option value="2">Capilla del Observatorio (Sectores 14 y 15)</option>
                            <option value="3">Capilla de San Juan Diego [SUPUESTO]</option>
                            <option value="4">Capilla de Nuestra Señora de Guadalupe [SUPUESTO]</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_evento" class="form-label fw-semibold">Tipo de Evento</label>
                        <select class="form-select" id="tipo_evento" name="tipo_evento" required>
                            <option value="fecha_fija_sacramento">Fecha Fija de Sacramento (Primera Comunión / Confirmación)</option>
                            <option value="festividad_peregrinacion">Festividad o Peregrinación</option>
                            <option value="sacramento_comunitario">Celebración de Sacramento Comunitario</option>
                            <option value="aviso_general">Aviso General o Curso</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="fecha_inicio" class="form-label fw-semibold">Fecha</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-6">
                            <label for="hora_inicio" class="form-label fw-semibold">Hora</label>
                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required value="12:00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-semibold">Descripción o Indicaciones</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                  placeholder="Notas litúrgicas o recomendaciones para los feligreses..."></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="es_fecha_fija" name="es_fecha_fija" value="1">
                        <label class="form-check-label small" for="es_fecha_fija">
                            <strong>Fijar en vista pública</strong> (Solo lectura para la comunidad - RF-16)
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold" style="background-color: var(--color-primary);">
                        <i class="bi bi-check2-circle me-1"></i> Publicar en Calendario
                    </button>
                </form>
            </div>
        </div>

        <!-- Lista de Eventos Actuales -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 p-4 bg-white">
                <h2 class="h5 fw-bold mb-3 text-primary" style="font-family: var(--font-heading);">
                    <i class="bi bi-calendar-check me-1 text-warning"></i> Eventos Litúrgicos Registrados
                </h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha / Hora</th>
                                <th>Evento</th>
                                <th>Sede</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventos as $ev): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($ev['fecha_inicio']) ?></strong><br>
                                        <span class="text-muted"><?= substr($ev['hora_inicio'], 0, 5) ?> hrs</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($ev['titulo']) ?></div>
                                        <?php if (!empty($ev['es_fecha_fija'])): ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-pin-angle-fill me-1"></i> Fecha Fija</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($ev['capilla_nombre']) ?></td>
                                    <td>
                                        <?php if ($ev['tipo_evento'] === 'fecha_fija_sacramento'): ?>
                                            <span class="badge bg-primary">Sacramento Fijo</span>
                                        <?php elseif ($ev['tipo_evento'] === 'festividad_peregrinacion'): ?>
                                            <span class="badge bg-success">Festividad</span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark">Comunitario</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
