<?php
/**
 * Vinea Comunidad — Middleware de Verificación de Sesión Administrativa (RNF-03)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobación estricta de sesión activa
if (empty($_SESSION['usuario_id']) || empty($_SESSION['usuario_email'])) {
    // Redirección inmediata al formulario de inicio de sesión
    header('Location: login.php?error=sesion_requerida');
    exit;
}

// Variables de sesión disponibles para las vistas del panel
$current_user_name = htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador', ENT_QUOTES, 'UTF-8');
$current_user_role = htmlspecialchars($_SESSION['usuario_rol'] ?? 'sacristan', ENT_QUOTES, 'UTF-8');
