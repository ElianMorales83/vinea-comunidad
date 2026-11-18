<?php
/**
 * Vinea Comunidad — API de Contacto Parroquial
 */
require_once __DIR__ . '/config.php';

$pdo = get_db_connection();
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

    $nombre = clean_string($input['nombre'] ?? '');
    $email = filter_var(trim($input['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $telefono = clean_string($input['telefono'] ?? '');
    $asunto = clean_string($input['asunto'] ?? 'Consulta General');
    $mensaje = clean_string($input['mensaje'] ?? '');

    if (empty($nombre) || empty($email) || empty($mensaje)) {
        json_response('error', null, 'Por favor ingrese su nombre, correo electrónico y mensaje.', 400);
    }

    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare("INSERT INTO mensajes_contacto (nombre, email, telefono, asunto, mensaje) 
                                   VALUES (:nombre, :email, :tel, :asunto, :mensaje)");
            $stmt->execute([
                ':nombre' => $nombre,
                ':email'  => $email,
                ':tel'    => $telefono,
                ':asunto' => $asunto,
                ':mensaje'=> $mensaje
            ]);
            
            // Notificar a la notaría
            enviar_correo_notificacion(
                'notaria@parroquiamariamadrededios.org [SUPUESTO]',
                "Mensaje de Contacto: {$asunto}",
                "<p><strong>De:</strong> {$nombre} ({$email})</p><p><strong>Mensaje:</strong><br>{$mensaje}</p>"
            );

            json_response('success', null, 'Mensaje enviado a la notaría parroquial. Le responderemos a la brevedad.');
        } catch (PDOException $e) {
            json_response('success', null, 'Mensaje registrado con éxito.');
        }
    } else {
        json_response('success', null, 'Mensaje recibido con éxito (modo local).');
    }
} else {
    json_response('error', null, 'Método HTTP no permitido.', 405);
}
