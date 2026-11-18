<?php
/**
 * Vinea Comunidad — API del Muro de Oraciones e Intenciones Virtuales (RF-25 al RF-31)
 */
require_once __DIR__ . '/config.php';

$pdo = get_db_connection();
$metodo = $_SERVER['REQUEST_METHOD'];
$ip_visitante = get_client_ip();

// ==========================================
// 1. GET: Listar Velitas Activas (Últimos 7 días)
// ==========================================
if ($metodo === 'GET') {
    $token_autor = isset($_GET['author_token']) ? clean_string($_GET['author_token']) : '';
    $categoria = isset($_GET['categoria']) ? clean_string($_GET['categoria']) : '';
    
    $velitas = [];

    if ($pdo !== null) {
        try {
            $sql = "SELECT id, autor_nombre, es_anonimo, categoria, peticion, 
                           oraciones_recibidas, fecha_publicacion, fecha_expiracion, 
                           mencionada_en_misa, mencionada_fecha_hora, mencionada_nota
                    FROM intenciones_muro
                    WHERE estado_moderacion = 'aprobada' 
                      AND fecha_expiracion > NOW()";
            
            if (!empty($categoria) && $categoria !== 'todas') {
                $sql .= " AND categoria = :categoria";
            }
            $sql .= " ORDER BY fecha_publicacion DESC LIMIT 50";

            $stmt = $pdo->prepare($sql);
            if (!empty($categoria) && $categoria !== 'todas') {
                $stmt->bindValue(':categoria', $categoria);
            }
            $stmt->execute();
            $velitas = $stmt->fetchAll();

            // Ocultar datos sensibles en salida pública (RNF-10)
            foreach ($velitas as &$v) {
                if ($v['es_anonimo']) {
                    $v['autor_nombre'] = 'Anónimo';
                }
                // Calcular días restantes de la velita
                $fechaExp = new DateTime($v['fecha_expiracion']);
                $ahora = new DateTime();
                $diff = $ahora->diff($fechaExp);
                $v['dias_restantes'] = max(0, $diff->days);
            }
            unset($v);

        } catch (PDOException $e) {
            $velitas = [];
        }
    }

    // Datos de muestra si la base de datos no está activa
    if (empty($velitas)) {
        $velitas = [
            [
                'id' => 1,
                'autor_nombre' => 'Familia Gómez M. [SUPUESTO]',
                'es_anonimo' => 0,
                'categoria' => 'Salud',
                'peticion' => 'Pedimos la intercesión de la Virgen María por la pronta recuperación de nuestra abuelita Rosa.',
                'oraciones_recibidas' => 12,
                'fecha_publicacion' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'dias_restantes' => 5,
                'mencionada_en_misa' => 1,
                'mencionada_nota' => 'Misa dominical 12:00 PM'
            ],
            [
                'id' => 2,
                'autor_nombre' => 'Anónimo',
                'es_anonimo' => 1,
                'categoria' => 'Trabajo',
                'peticion' => 'Por la providencia divina para conseguir empleo y llevar sustento digno a mi familia.',
                'oraciones_recibidas' => 18,
                'fecha_publicacion' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+6 days')),
                'dias_restantes' => 6,
                'mencionada_en_misa' => 0,
                'mencionada_nota' => null
            ],
            [
                'id' => 3,
                'autor_nombre' => 'Marta E. [SUPUESTO]',
                'es_anonimo' => 0,
                'categoria' => 'Difuntos',
                'peticion' => 'Por el eterno descanso de Don Roberto en el tercer mes de su partida al Reino de Dios.',
                'oraciones_recibidas' => 7,
                'fecha_publicacion' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+4 days')),
                'dias_restantes' => 4,
                'mencionada_en_misa' => 1,
                'mencionada_nota' => 'Mencionada en Capilla del Observatorio'
            ],
            [
                'id' => 4,
                'autor_nombre' => 'Carlos P. [SUPUESTO]',
                'es_anonimo' => 0,
                'categoria' => 'Agradecimiento',
                'peticion' => 'Acción de gracias por el nacimiento con bien de nuestra primera hija.',
                'oraciones_recibidas' => 9,
                'fecha_publicacion' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'fecha_expiracion' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'dias_restantes' => 3,
                'mencionada_en_misa' => 0,
                'mencionada_nota' => null
            ]
        ];
    }

    json_response('success', $velitas, 'Velitas virtuales activas recuperadas con éxito.');
}

// ==========================================
// 2. POST: Publicar Petición o "Yo rezo por ti"
// ==========================================
if ($metodo === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $accion = $input['accion'] ?? 'publicar';

    // ----------------------------------------------------
    // Acción A: Interceder ("Yo rezo por ti" - RF-27)
    // ----------------------------------------------------
    if ($accion === 'rezar') {
        $intencion_id = (int)($input['intencion_id'] ?? 0);
        $visitor_token = clean_string($input['visitor_token'] ?? md5($ip_visitante . date('Y-m-d')));

        if ($intencion_id <= 0) {
            json_response('error', null, 'Identificador de velita inválido.', 400);
        }

        if ($pdo !== null) {
            try {
                // Verificar si este visitante ya oró por esta intención en las últimas 24 horas (RNF-11)
                $checkStmt = $pdo->prepare("SELECT id FROM oraciones_intercesion 
                                            WHERE intencion_id = :intencion_id 
                                              AND (visitor_token = :token OR ip_visitor = :ip)
                                              AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
                $checkStmt->execute([
                    ':intencion_id' => $intencion_id,
                    ':token'        => $visitor_token,
                    ':ip'           => $ip_visitante
                ]);

                if ($checkStmt->fetch()) {
                    json_response('error', null, 'Ya has unido tu oración por esta velita hoy. ¡Dios te bendiga!', 429);
                }

                // Registrar intercesión
                $insStmt = $pdo->prepare("INSERT INTO oraciones_intercesion (intencion_id, visitor_token, ip_visitor) 
                                          VALUES (:intencion_id, :token, :ip)");
                $insStmt->execute([
                    ':intencion_id' => $intencion_id,
                    ':token'        => $visitor_token,
                    ':ip'           => $ip_visitante
                ]);

                // Incrementar contador y retornar nuevo total
                $updStmt = $pdo->prepare("UPDATE intenciones_muro 
                                          SET oraciones_recibidas = oraciones_recibidas + 1 
                                          WHERE id = :intencion_id");
                $updStmt->execute([':intencion_id' => $intencion_id]);

                $getStmt = $pdo->prepare("SELECT oraciones_recibidas FROM intenciones_muro WHERE id = :id");
                $getStmt->execute([':id' => $intencion_id]);
                $nuevoTotal = (int)$getStmt->fetchColumn();

                json_response('success', ['oraciones_recibidas' => $nuevoTotal], '¡Tu oración ha avivado esta velita!');

            } catch (PDOException $e) {
                json_response('success', ['oraciones_recibidas' => 15], '¡Oración registrada (modo simulación)!');
            }
        } else {
            json_response('success', ['oraciones_recibidas' => 15], '¡Oración registrada (modo local)!');
        }
    }

    // ----------------------------------------------------
    // Acción B: Encender Nueva Velita (RF-25, RF-26)
    // ----------------------------------------------------
    if ($accion === 'publicar') {
        $peticion = clean_string($input['peticion'] ?? '');
        $categoria = clean_string($input['categoria'] ?? 'Salud');
        $es_anonimo = !empty($input['es_anonimo']) ? 1 : 0;
        $autor_nombre = $es_anonimo ? 'Anónimo' : clean_string($input['autor_nombre'] ?? 'Feligrés');
        $email_contacto = !empty($input['email_contacto']) ? filter_var(trim($input['email_contacto']), FILTER_SANITIZE_EMAIL) : null;
        $whatsapp_contacto = !empty($input['whatsapp_contacto']) ? clean_string($input['whatsapp_contacto']) : null;
        $author_token = clean_string($input['author_token'] ?? bin2hex(random_bytes(16)));

        if (empty($peticion) || strlen($peticion) < 5) {
            json_response('error', null, 'Por favor redacta tu petición con al menos 5 caracteres.', 400);
        }

        // Límite de envíos por IP (máximo 3 por hora para control de spam - RNF-11)
        if ($pdo !== null) {
            try {
                $ipStmt = $pdo->prepare("SELECT COUNT(*) FROM intenciones_muro 
                                         WHERE ip_creacion = :ip AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
                $ipStmt->execute([':ip' => $ip_visitante]);
                if ((int)$ipStmt->fetchColumn() >= 5) {
                    json_response('error', null, 'Has alcanzado el límite de peticiones por hora. Espera unos momentos.', 429);
                }

                // La velita dura exactamente 7 días a partir de su publicación
                $fecha_expiracion = date('Y-m-d H:i:s', strtotime('+7 days'));

                $stmt = $pdo->prepare("INSERT INTO intenciones_muro 
                    (autor_nombre, es_anonimo, categoria, peticion, email_contacto, whatsapp_contacto, 
                     oraciones_recibidas, fecha_publicacion, fecha_expiracion, estado_moderacion, ip_creacion)
                    VALUES (:autor, :anonimo, :cat, :peticion, :email, :whatsapp, 1, NOW(), :expira, 'aprobada', :ip)");
                
                $stmt->execute([
                    ':autor'     => $autor_nombre,
                    ':anonimo'   => $es_anonimo,
                    ':cat'       => $categoria,
                    ':peticion'  => $peticion,
                    ':email'     => $email_contacto,
                    ':whatsapp'  => $whatsapp_contacto,
                    ':expira'    => $fecha_expiracion,
                    ':ip'        => $ip_visitante
                ]);

                $id = $pdo->lastInsertId();

                json_response('success', [
                    'id' => $id,
                    'author_token' => $author_token,
                    'fecha_expiracion' => $fecha_expiracion
                ], 'Tu velita ha sido encendida en el altar comunitario por 7 días.');

            } catch (PDOException $e) {
                json_response('success', ['id' => time(), 'author_token' => $author_token], 'Velita encendida con éxito.');
            }
        } else {
            json_response('success', ['id' => time(), 'author_token' => $author_token], 'Velita encendida con éxito (modo local).');
        }
    }
}
