-- =====================================================================
-- PROYECTO: Vinea Comunidad - Parroquia María Madre de Dios (Tehuacán)
-- ESQUEMA DE BASE DE DATOS RELACIONAL (sql/schema.sql)
-- MOTOR: MySQL / MariaDB (Compatible con PHP PDO)
-- JUEGO DE CARACTERES: utf8mb4 / COTEJAMIENTO: utf8mb4_unicode_ci
-- =====================================================================

CREATE DATABASE IF NOT EXISTS vinea_comunidad CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vinea_comunidad;

-- 1. Tabla de Usuarios y Roles de Administración
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('parroco', 'sacristan', 'administrador') NOT NULL DEFAULT 'sacristan',
    activo BOOLEAN NOT NULL DEFAULT TRUE,
    ultimo_acceso DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Capillas y Sedes Filiales
CREATE TABLE IF NOT EXISTS capillas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    tipo ENUM('sede_parroquial', 'capilla_filial') NOT NULL DEFAULT 'capilla_filial',
    direccion VARCHAR(255) NOT NULL,
    horario_habitual TEXT NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabla de Sectores Territoriales
CREATE TABLE IF NOT EXISTS sectores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    capilla_id INT NOT NULL,
    numero_sector INT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT NULL,
    FOREIGN KEY (capilla_id) REFERENCES capillas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Calendario Litúrgico Oficial (Colores, Santoral y Tiempos)
CREATE TABLE IF NOT EXISTS calendario_liturgico (
    fecha DATE PRIMARY KEY,
    tiempo_liturgico VARCHAR(80) NOT NULL,
    color_liturgico ENUM('verde', 'morado', 'blanco', 'rojo') NOT NULL,
    santoral_celebracion VARCHAR(255) NOT NULL,
    grado_celebracion ENUM('Feria', 'Memoria Libre', 'Memoria Obligatoria', 'Fiesta', 'Solemnidad') NOT NULL DEFAULT 'Feria'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabla de Eventos Parroquiales y Litúrgicos
CREATE TABLE IF NOT EXISTS eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    capilla_id INT NOT NULL,
    titulo VARCHAR(180) NOT NULL,
    tipo_evento ENUM('festividad_peregrinacion', 'sacramento_comunitario', 'fecha_fija_sacramento', 'aviso_general') NOT NULL,
    fecha_inicio DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    fecha_fin DATE NULL,
    hora_fin TIME NULL,
    descripcion TEXT NULL,
    es_fecha_fija BOOLEAN NOT NULL DEFAULT FALSE,
    creado_por INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (capilla_id) REFERENCES capillas(id) ON DELETE CASCADE,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Muro de Oraciones e Intenciones Virtuales (Velitas 7 días)
CREATE TABLE IF NOT EXISTS intenciones_muro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    autor_nombre VARCHAR(100) NOT NULL DEFAULT 'Anónimo',
    es_anonimo BOOLEAN NOT NULL DEFAULT FALSE,
    categoria ENUM('Salud', 'Trabajo', 'Difuntos', 'Familia', 'Agradecimiento', 'Especial') NOT NULL,
    peticion TEXT NOT NULL,
    email_contacto VARCHAR(150) NULL,
    whatsapp_contacto VARCHAR(30) NULL,
    oraciones_recibidas INT NOT NULL DEFAULT 0,
    fecha_publicacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion DATETIME NOT NULL,
    mencionada_en_misa BOOLEAN NOT NULL DEFAULT FALSE,
    mencionada_fecha_hora DATETIME NULL,
    mencionada_nota VARCHAR(200) NULL,
    notificacion_enviada BOOLEAN NOT NULL DEFAULT FALSE,
    estado_moderacion ENUM('aprobada', 'pendiente', 'oculta') NOT NULL DEFAULT 'aprobada',
    ip_creacion VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_expiracion (fecha_expiracion),
    INDEX idx_moderacion (estado_moderacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Registro de Intercesión ("Yo rezo por ti" / Control de abuso)
CREATE TABLE IF NOT EXISTS oraciones_intercesion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intencion_id INT NOT NULL,
    visitor_token VARCHAR(64) NOT NULL,
    ip_visitor VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (intencion_id) REFERENCES intenciones_muro(id) ON DELETE CASCADE,
    INDEX idx_intercesion (intencion_id, visitor_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Solicitudes de Intenciones de Misa en Capillas
CREATE TABLE IF NOT EXISTS intenciones_misa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    capilla_id INT NOT NULL,
    tipo_intencion ENUM('Salud', 'Difuntos', 'Acción de Gracias', 'Especial') NOT NULL,
    nombre_persona_familia VARCHAR(180) NOT NULL,
    fecha_misa DATE NOT NULL,
    hora_misa TIME NOT NULL,
    solicitante_nombre VARCHAR(120) NOT NULL,
    solicitante_contacto VARCHAR(120) NOT NULL,
    estipendio_ofrenda DECIMAL(8,2) NULL,
    estado ENUM('pendiente', 'programada', 'celebrada', 'cancelada') NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (capilla_id) REFERENCES capillas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Agenda de Citas Pastorales y Notariales
CREATE TABLE IF NOT EXISTS citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_solicitante VARCHAR(120) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    email VARCHAR(150) NOT NULL,
    tipo_cita ENUM('pastoral_parroco', 'notarial_tramites', 'preparacion_matrimonial', 'otra') NOT NULL,
    fecha_solicitada DATE NOT NULL,
    hora_solicitada TIME NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('solicitada', 'confirmada', 'atendida', 'cancelada') NOT NULL DEFAULT 'solicitada',
    notas_admin TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Mensajes de Contacto
CREATE TABLE IF NOT EXISTS mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefono VARCHAR(30) NULL,
    asunto VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    leido BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
