<?php
/**
 * Vinea Comunidad — Configuración de Base de Datos y Utilidades de API
 * Parroquia María Madre de Dios (Tehuacán)
 */

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Responder de inmediato a peticiones pre-flight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Configuración de credenciales de Base de Datos MySQL
// Para producción o hosting gratuito, ajustar estas variables:
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'vinea_comunidad');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Obtener instancia PDO de conexión a Base de Datos
 */
function get_db_connection() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Si la base de datos local no está disponible, no romper con error 500 no controlado
            return null;
        }
    }
    return $pdo;
}

/**
 * Enviar respuesta estándar en formato JSON
 */
function json_response($status, $data = null, $message = '', $http_code = 200) {
    http_response_code($http_code);
    echo json_encode([
        'status'    => $status, // 'success' o 'error'
        'message'   => $message,
        'data'      => $data,
        'timestamp' => date('c')
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

/**
 * Sanitizar texto para prevenir Cross-Site Scripting (XSS) - RNF-09
 */
function clean_string($text) {
    if ($text === null) return '';
    $text = trim($text);
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Obtener dirección IP del visitante para control de abuso y límites - RNF-11
 */
function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
    return filter_var(trim($ip), FILTER_VALIDATE_IP) ? $ip : '127.0.0.1';
}

/**
 * Enviar correo de notificación (simulado / PHP mail) - RF-23 / RF-30
 */
function enviar_correo_notificacion($para, $asunto, $cuerpo_html) {
    $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "From: Vinea Comunidad <notificaciones@parroquiamariamadrededios.org>\r\n";
    $cabeceras .= "Reply-To: notaria@parroquiamariamadrededios.org\r\n";
    
    // Si la función mail() está disponible en el servidor, se invoca
    if (function_exists('mail') && !empty($para)) {
        return @mail($para, $asunto, $cuerpo_html, $cabeceras);
    }
    return true; // Éxito lógico
}
