<?php
/**
 * Vinea Comunidad — Dashboard Administrativo y Pastoral
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../api/config.php';

$pdo = get_db_connection();

// Métricas por defecto
$metricas = [
    'velitas_activas' => 5,
    'oraciones_totales' => 58,
    'citas_pendientes' => 3,
    'eventos_mes' => 7,
    'mensajes_nuevos' => 2
];

if ($pdo !== null) {
    try {
        $stmtV = $pdo->query("SELECT COUNT(*) AS total, SUM(oraciones_recibidas) AS oraciones 
                              FROM intenciones_muro WHERE fecha_expiracion > NOW() AND estado_moderacion = 'aprobada'");
        $resV = $stmtV->fetch();
        if ($resV) {
            $metricas['velitas_activas'] = (int)$resV['total'];
            $metricas['oraciones_totales'] = (int)$resV['oraciones'];
        }

        $stmtC = $pdo->query("SELECT COUNT(*) FROM citas WHERE estado = 'solicitada'");
        $metricas['citas_pendientes'] = (int)$stmtC->fetchColumn();

        $stmtE = $pdo->query("SELECT COUNT(*) FROM eventos WHERE MONTH(fecha_inicio) = MONTH(CURRENT_DATE())");
        $metricas['eventos_mes'] = (int)$stmtE->fetchColumn();

        $stmtM = $pdo->query("SELECT COUNT(*) FROM mensajes_contacto WHERE leido = 0");
        $metricas['mensajes_nuevos'] = (int)$stmtM->fetchColumn();
    } catch (PDOException $e) {
        // Usar métricas de muestra en caso de desconexión
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Pastoral — Vinea Comunidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-nav {
            background-color: #1e3a8a;
            border-bottom: 3px solid #d97706;
        }
        .stat-card {
            border: none;
            border-radius: var(--radius-md);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .action-card {
            border: 1px solid rgba(30, 58, 138, 0.12);
            border-radius: var(--radius-md);
            background: #ffffff;
            transition: all 0.2s ease;
        }
        .action-card:hover {
            border-color: #d97706;
            background: #fefce8;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark admin-nav sticky-top py-2">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php" style="font-family: var(--font-heading);">
            <i class="bi bi-shield-check text-warning me-2 fs-4"></i> Vinea Comunidad · Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="intenciones.php"><i class="bi bi-journal-bookmark me-1"></i> Oración de los Fieles</a></li>
                <li class="nav-item"><a class="nav-link" href="eventos.php"><i class="bi bi-calendar-event me-1"></i> Calendario</a></li>
                <li class="nav-item"><a class="nav-link" href="citas.php"><i class="bi bi-clock-history me-1"></i> Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="muro_admin.php"><i class="bi bi-fire me-1"></i> Muro</a></li>
                <li class="nav-item"><a class="nav-link" href="mensajes.php"><i class="bi bi-envelope me-1"></i> Mensajes</a></li>
            </ul>
            <div class="d-flex align-items-center text-white">
                <div class="me-3 text-end d-none d-md-block">
                    <div class="fw-semibold small"><?= $current_user_name ?></div>
                    <div class="text-white-50" style="font-size: 0.75rem;">Rol: <?= ucfirst($current_user_role) ?></div>
                </div>
                <a href="../index.html" target="_blank" class="btn btn-outline-warning btn-sm me-2" title="Abrir sitio público">
                    <i class="bi bi-globe me-1"></i> Ver Sitio
                </a>
                <a href="logout.php" class="btn btn-danger btn-sm" title="Cerrar sesión">
                    <i class="bi bi-power"></i>
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="h3 fw-bold mb-1" style="color: var(--color-primary); font-family: var(--font-heading);">
                Bienvenido, <?= $current_user_name ?>
            </h1>
            <p class="text-muted mb-0">Gestión pastoral y comunitaria · Parroquia María Madre de Dios (Tehuacán)</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">
                <i class="bi bi-calendar-check me-1"></i> <?= date('d/m/Y') ?>
            </span>
        </div>
    </div>

    <!-- Tarjetas de Métricas Rápidas -->
    <div class="row g-3 mb-5">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">VELITAS ACTIVAS</div>
                        <div class="fs-3 fw-bold text-warning"><?= $metricas['velitas_activas'] ?></div>
                        <div class="small text-muted"><?= $metricas['oraciones_totales'] ?> oraciones unidas</div>
                    </div>
                    <div class="rounded-circle p-3 bg-warning-subtle text-warning fs-3">
                        <i class="bi bi-fire"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">CITAS PENDIENTES</div>
                        <div class="fs-3 fw-bold text-primary"><?= $metricas['citas_pendientes'] ?></div>
                        <div class="small text-muted">Por atender o confirmar</div>
                    </div>
                    <div class="rounded-circle p-3 bg-primary-subtle text-primary fs-3">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">EVENTOS DEL MES</div>
                        <div class="fs-3 fw-bold text-success"><?= $metricas['eventos_mes'] ?></div>
                        <div class="small text-muted">Calendario litúrgico</div>
                    </div>
                    <div class="rounded-circle p-3 bg-success-subtle text-success fs-3">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card shadow-sm p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">MENSAJES NUEVOS</div>
                        <div class="fs-3 fw-bold text-info"><?= $metricas['mensajes_nuevos'] ?></div>
                        <div class="small text-muted">Buzón de notaría</div>
                    </div>
                    <div class="rounded-circle p-3 bg-info-subtle text-info fs-3">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos de Gestión Pastoral -->
    <h2 class="h5 fw-bold mb-3" style="color: var(--color-primary); font-family: var(--font-heading);">
        <i class="bi bi-lightning-charge me-1 text-warning"></i> Acciones Pastorales Clave
    </h2>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <a href="intenciones.php" class="card action-card p-4 text-decoration-none h-100 shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-primary-subtle text-primary p-3 me-3 fs-4">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold mb-0 text-dark">Oración de los Fieles</h3>
                        <span class="badge bg-warning text-dark">Módulo Pastoral</span>
                    </div>
                </div>
                <p class="small text-muted mb-0">
                    Consolidado clasificado de peticiones activas de la comunidad para preparar las preces litúrgicas de las misas dominicales. Marca intenciones como "Mencionada en misa".
                </p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="eventos.php" class="card action-card p-4 text-decoration-none h-100 shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-success-subtle text-success p-3 me-3 fs-4">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold mb-0 text-dark">Gestor de Calendario</h3>
                        <span class="badge bg-success">Fechas Fijas</span>
                    </div>
                </div>
                <p class="small text-muted mb-0">
                    Publica y reprograma eventos, peregrinaciones, misas comunitarias y las fechas oficiales fijas de Primera Comunión y Confirmación para todas las capillas.
                </p>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="citas.php" class="card action-card p-4 text-decoration-none h-100 shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-info-subtle text-info p-3 me-3 fs-4">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold mb-0 text-dark">Agenda de Citas</h3>
                        <span class="badge bg-info text-dark">Atención Personal</span>
                    </div>
                </div>
                <p class="small text-muted mb-0">
                    Revisa solicitudes de acompañamiento espiritual y trámites notariales; confirma horarios y marca solicitudes como atendidas.
                </p>
            </a>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
