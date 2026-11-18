-- =====================================================================
-- PROYECTO: Vinea Comunidad - Parroquia María Madre de Dios (Tehuacán)
-- DATOS INICIALES Y SEMILLAS DE PRUEBA (sql/datos_ejemplo.sql)
-- =====================================================================

USE vinea_comunidad;

-- 1. Usuarios del Sistema (Contraseña por defecto: admin2026#Vinea)
-- Hash BCRYPT generado con cost=10 para la clave segura de inicio
INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES
('Pbro. Francisco Javier Morales [SUPUESTO]', 'parroco@mariamadrededios.org [SUPUESTO]', '$2y$10$8g4uVzR2.K4sK9m1V3N2Oe5G3b/xL8j1V0fL7z/W6z4G1X0Y1Z2O2', 'parroco'),
('Mateo Bautista [SUPUESTO]', 'sacristia@mariamadrededios.org [SUPUESTO]', '$2y$10$8g4uVzR2.K4sK9m1V3N2Oe5G3b/xL8j1V0fL7z/W6z4G1X0Y1Z2O2', 'sacristan')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 2. Capillas y Sedes Filiales
INSERT INTO capillas (id, nombre, tipo, direccion, horario_habitual) VALUES
(1, 'Templo Parroquial María Madre de Dios', 'sede_parroquial', 'Calle 5 Poniente #120, Col. Centro, Tehuacán, Pue. [SUPUESTO]', 'Martes a Sábado: 19:00 hrs. | Domingo: 08:00, 10:00, 12:00 y 19:00 hrs. [SUPUESTO]'),
(2, 'Capilla del Observatorio', 'capilla_filial', 'Av. del Observatorio esq. Calle Sol, Tehuacán, Pue. [SUPUESTO]', 'Sábados: 18:00 hrs. | Domingos: 11:00 hrs. (Confirmado) [SUPUESTO]'),
(3, 'Capilla de San Juan Diego [SUPUESTO]', 'capilla_filial', 'Sector 16, Col. San Diego, Tehuacán, Pue. [SUPUESTO]', 'Domingos: 09:30 hrs. [SUPUESTO]'),
(4, 'Capilla de Nuestra Señora de Guadalupe [SUPUESTO]', 'capilla_filial', 'Sector 18, Col. Tepeyac, Tehuacán, Pue. [SUPUESTO]', 'Domingos: 17:00 hrs. [SUPUESTO]')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 3. Sectores Territoriales (Capilla del Observatorio comprende sectores 14 y 15 confirmado)
INSERT INTO sectores (capilla_id, numero_sector, nombre, descripcion) VALUES
(1, 1, 'Sector 1 - San José', 'Zona centro y comercio [SUPUESTO]'),
(1, 2, 'Sector 2 - Sagrado Corazón', 'Cuadrante poniente [SUPUESTO]'),
(2, 14, 'Sector 14 - San Francisco', 'Sector territorial del Observatorio poniente (Dato confirmado)'),
(2, 15, 'Sector 15 - La Milagrosa', 'Sector territorial del Observatorio oriente (Dato confirmado)'),
(3, 16, 'Sector 16 - Santa María', 'Área norte de la colonia [SUPUESTO]'),
(3, 17, 'Sector 17 - San Miguel', 'Área poniente de la colonia [SUPUESTO]'),
(4, 18, 'Sector 18 - Tepeyac Norte', 'Área pastoral Tepeyac [SUPUESTO]'),
(4, 19, 'Sector 19 - Tepeyac Sur', 'Área pastoral Tepeyac [SUPUESTO]')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- 4. Calendario Litúrgico (Muestra para Octubre / Noviembre 2026)
INSERT INTO calendario_liturgico (fecha, tiempo_liturgico, color_liturgico, santoral_celebracion, grado_celebracion) VALUES
('2026-10-04', 'Tiempo Ordinario', 'verde', 'San Francisco de Asís', 'Memoria Libre'),
('2026-10-05', 'Tiempo Ordinario', 'verde', 'Santa Faustina Kowalska', 'Memoria Libre'),
('2026-10-07', 'Tiempo Ordinario', 'blanco', 'Nuestra Señora del Rosario', 'Memoria Obligatoria'),
('2026-10-11', 'Tiempo Ordinario', 'verde', 'XXVIII Domingo del Tiempo Ordinario', 'Solemnidad'),
('2026-10-12', 'Tiempo Ordinario', 'blanco', 'Nuestra Señora del Pilar / Santa María', 'Fiesta'),
('2026-10-18', 'Tiempo Ordinario', 'verde', 'XXIX Domingo del Tiempo Ordinario - San Lucas', 'Solemnidad'),
('2026-10-28', 'Tiempo Ordinario', 'rojo', 'Santos Simón y Judas, Apóstoles', 'Fiesta'),
('2026-11-01', 'Solemnidad', 'blanco', 'Solemnidad de Todos los Santos', 'Solemnidad'),
('2026-11-02', 'Conmemoración', 'morado', 'Conmemoración de Todos los Fieles Difuntos', 'Solemnidad'),
('2026-11-08', 'Tiempo Ordinario', 'verde', 'XXXII Domingo del Tiempo Ordinario', 'Solemnidad'),
('2026-11-15', 'Tiempo Ordinario', 'verde', 'XXXIII Domingo del Tiempo Ordinario', 'Solemnidad'),
('2026-11-22', 'Solemnidad', 'blanco', 'Jesucristo, Rey del Universo (Cristo Rey)', 'Solemnidad'),
('2026-11-29', 'Tiempo de Adviento', 'morado', 'I Domingo de Adviento', 'Solemnidad'),
('2026-12-12', 'Tiempo de Adviento', 'blanco', 'Nuestra Señora de Guadalupe, Patrona de México', 'Solemnidad')
ON DUPLICATE KEY UPDATE santoral_celebracion=VALUES(santoral_celebracion);

-- 5. Eventos Parroquiales y Fechas Fijas
INSERT INTO eventos (capilla_id, titulo, tipo_evento, fecha_inicio, hora_inicio, descripcion, es_fecha_fija) VALUES
(1, 'Celebración Comunitaria de Confirmación', 'fecha_fija_sacramento', '2026-11-15', '11:00:00', 'Ceremonia solemne comunitaria presidida por el Vicario Episcopal. [SUPUESTO]', TRUE),
(1, 'Celebración Comunitaria de Primera Comunión', 'fecha_fija_sacramento', '2026-11-22', '10:00:00', 'Misa comunitaria de recepción del sacramento de la Eucaristía. [SUPUESTO]', TRUE),
(1, 'Celebración de Bautismo', 'sacramento_comunitario', '2026-10-17', '12:00:00', 'Misa comunitaria de bautismos.', FALSE),
(2, 'Fiesta Patronal y Peregrinación del Sector 14 y 15', 'festividad_peregrinacion', '2026-10-24', '17:00:00', 'Peregrinación comunitaria saliendo del Templo Parroquial hacia la Capilla del Observatorio. [SUPUESTO]', FALSE),
(2, 'Celebración de Bautismo', 'sacramento_comunitario', '2026-10-31', '12:00:00', 'Celebración de sacramento comunitario.', FALSE),
(1, 'Misa Solemne de Todos los Santos', 'festividad_peregrinacion', '2026-11-01', '12:00:00', 'Eucaristía solemne comunitaria con bendición de niños.', FALSE),
(1, 'Misa de Fieles Difuntos en el Campo Santo', 'festividad_peregrinacion', '2026-11-02', '10:00:00', 'Eucaristía solemne y bendición de criptas. [SUPUESTO]', FALSE);

-- 6. Intenciones Iniciales en el Muro de Oraciones (Velitas Virtuales activas por 7 días)
INSERT INTO intenciones_muro (autor_nombre, es_anonimo, categoria, peticion, email_contacto, oraciones_recibidas, fecha_publicacion, fecha_expiracion, mencionada_en_misa, estado_moderacion) VALUES
('Familia Gómez Méndez', FALSE, 'Salud', 'Pedimos la intercesión de la Virgen María por la pronta recuperación y salud de nuestra abuela Rosa que se encuentra hospitalizada.', 'familia.gomez@gmail.com [SUPUESTO]', 8, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), FALSE, 'aprobada'),
('Anónimo', TRUE, 'Trabajo', 'Pido una oración para que mi padre consiga un empleo digno y podamos sostener a mis hermanos pequeños.', NULL, 14, NOW(), DATE_ADD(NOW(), INTERVAL 6 DAY), TRUE, 'aprobada'),
('Marta Elena [SUPUESTO]', FALSE, 'Difuntos', 'En memoria de mi querido esposo Don Roberto en su tercer mes de partida a la casa del Padre.', 'marta.elena@hotmail.com [SUPUESTO]', 5, NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), FALSE, 'aprobada'),
('Anónimo', TRUE, 'Familia', 'Por la paz y reconciliación de nuestra familia en este momento de prueba difícil.', NULL, 19, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), FALSE, 'aprobada'),
('Carlos P. [SUPUESTO]', FALSE, 'Agradecimiento', 'Doy gracias a Dios y a María Madre de Dios por haber nacido con bien nuestra pequeña hija.', NULL, 11, NOW(), DATE_ADD(NOW(), INTERVAL 4 DAY), TRUE, 'aprobada');
