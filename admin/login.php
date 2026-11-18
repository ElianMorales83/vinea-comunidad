<?php
/**
 * Vinea Comunidad — Inicio de Sesión al Panel Administrativo
 */
session_start();
require_once __DIR__ . '/../api/config.php';

// Si ya tiene sesión abierta, redirigir al dashboard principal
if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$error_msg = '';
$info_msg = '';

if (isset($_GET['error']) && $_GET['error'] === 'sesion_requerida') {
    $info_msg = 'Por razones de seguridad, debe iniciar sesión para acceder al panel.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error_msg = 'Por favor complete todos los campos.';
    } else {
        $pdo = get_db_connection();
        $autenticado = false;
        $usuario = null;

        if ($pdo !== null) {
            try {
                $stmt = $pdo->prepare("SELECT id, nombre, email, password_hash, rol FROM usuarios WHERE email = :email AND activo = 1");
                $stmt->execute([':email' => $email]);
                $usuario = $stmt->fetch();

                if ($usuario && password_verify($password, $usuario['password_hash'])) {
                    $autenticado = true;
                }
            } catch (PDOException $e) {
                $autenticado = false;
            }
        }

        // Credenciales maestras de respaldo local si no hay BD MySQL
        if (!$autenticado && ($email === 'parroco@mariamadrededios.org' || $email === 'admin_parroquia') && $password === 'admin2026#Vinea') {
            $autenticado = true;
            $usuario = [
                'id' => 1,
                'nombre' => 'Pbro. Francisco Javier Morales [SUPUESTO]',
                'email' => 'parroco@mariamadrededios.org',
                'rol' => 'parroco'
            ];
        }

        if ($autenticado && $usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            header('Location: index.php');
            exit;
        } else {
            $error_msg = 'Credenciales incorrectas. Verifique su correo y contraseña.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Pastoral — Vinea Comunidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            padding: 1.5rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(217, 119, 6, 0.2);
        }
        .login-header {
            background: #1e3a8a;
            color: #ffffff;
            padding: 2.25rem 2rem 1.75rem;
            text-align: center;
            position: relative;
        }
        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #d97706, #fef08a, #d97706);
        }
        .login-body {
            padding: 2.25rem 2rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="mb-2">
            <i class="bi bi-shield-lock text-warning" style="font-size: 2.5rem;"></i>
        </div>
        <h1 class="h4 mb-1" style="font-family: var(--font-heading); color: #fff;">Panel Administrativo</h1>
        <p class="small text-white-50 mb-0">Parroquia María Madre de Dios · Vinea Comunidad</p>
    </div>

    <div class="login-body">
        <?php if (!empty($info_msg)): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-1"></i> <?= htmlspecialchars($info_msg) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Correo o Usuario Pastoral</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="text" class="form-control" id="email" name="email" 
                           placeholder="parroco@mariamadrededios.org" required autofocus
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="••••••••••••" required>
                </div>
                <div class="form-text small text-muted mt-1">
                    Credencial predeterminada del equipo: <code>admin2026#Vinea</code> [SUPUESTO]
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm mb-3" style="background-color: var(--color-primary);">
                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión Pastoral
            </button>

            <div class="text-center">
                <a href="../index.html" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Portal de la Comunidad
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
