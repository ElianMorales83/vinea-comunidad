# Vinea Comunidad — Desarrollo e Implementación Técnica (Fase 5)

**Proyecto:** Vinea Comunidad (Portal Web Parroquial)  
**Organización:** Parroquia María Madre de Dios (Tehuacán, Puebla) — Diócesis de Tehuacán  
**Asignatura:** Desarrollo de Aplicaciones Web  
**Docente:** Yedid Curioca Varela  
**Institución:** Universidad Tecnológica de Tehuacán — TSU en Tecnologías de la Información  
**Equipo de Trabajo:**
- Sandra Belén De La Cruz Morales
- Anthony Pérez Bautista
- Guadalupe Amayrani Méndez Huerta
- Zamira Pérez Ponce
- José Elián Martínez Morales
- Luis Ángel Cisneros  
**Agente Técnico:** Vinea-Web  
**Versión:** 1.0  
**Fecha:** 5 de octubre de 2026  

---

## 1. Resumen de Tecnologías Utilizadas

| Capa | Tecnología | Justificación Técnica y Criterio de Selección |
|---|---|---|
| **Estructura Front-end** | HTML5 Semántico Estricto | Empleo de elementos semánticos (`header`, `nav`, `main`, `section`, `article`, `footer`), un único `h1` por vista, jerarquía estricta de encabezados y atributos ARIA de accesibilidad. |
| **Estilos y Maquetación** | Bootstrap 5.3 (CDN) + CSS3 Modular Nativos | Bootstrap provee el sistema de rejilla responsiva fluida; los estilos propios en `css/styles.css` gestionan los tokens de identidad (variables CSS), animaciones de flamas y sombras litúrgicas sin estilos en línea. |
| **Lógica e Interactividad** | JavaScript ES6+ Vanilla | Sin dependencias ni frameworks pesados (React/Angular descartados). Módulos desacoplados en `js/` (`main.js`, `calendario.js`, `muro.js`, `sacramentos.js`), manipulación eficiente del DOM y polling asíncrono. |
| **Capa de Servicios y Back-end** | PHP 8.x Ligero con PDO | Arquitectura modular en `api/` y `admin/`. Consultas preparadas inmunes a inyección SQL, hashing de contraseñas con BCRYPT (`password_hash`), autenticación basada en sesión y sanitización de salidas contra XSS. |
| **Persistencia de Datos** | MySQL / MariaDB (InnoDB, utf8mb4) | Esquema relacional de 10 tablas optimizadas en `sql/schema.sql`, con claves foráneas e integridad referencial en cascada para intenciones, oraciones, eventos y citas. |

---

## 2. Estructura del Código Fuente Implementado

```
vinea-comunidad/
├── index.html                   # Portal web principal con las 6 secciones académicas y 6 módulos
├── css/
│   └── styles.css               # Sistema de diseño con variables CSS, animaciones de flamas y media queries
├── js/
│   ├── main.js                  # Control de navegación, skip-link, scrollspy y formulario de contacto
│   ├── calendario.js            # Motor del calendario mensual litúrgico y filtro por capilla
│   ├── muro.js                  # Lógica del Muro de Oraciones, velitas de 7 días y flamas dinámicas
│   └── sacramentos.js           # Guías de sacramentos, generación de PDF imprimible y citas
├── img/
│   ├── hero-parroquia.jpg       # Fotografía artística del templo parroquial
│   └── virgen-maria.jpg         # Imagen devocional de María Madre de Dios
├── api/
│   ├── config.php               # Conexión PDO, cabeceras CORS/JSON, sanitización y mailer
│   ├── eventos.php              # Endpoint REST para eventos y fechas fijas de sacramentos
│   ├── intenciones.php          # Endpoint REST para velitas del muro, oraciones y peticiones
│   ├── citas.php                # Endpoint REST para solicitud y listado de citas
│   ├── contacto.php             # Endpoint REST para recepción de mensajes a notaría
│   └── liturgico.php            # Endpoint REST para consultar tiempo litúrgico y santoral
├── admin/
│   ├── login.php                # Inicio de sesión seguro con protección CSRF y validación de hash
│   ├── logout.php               # Cierre y destrucción segura de sesión
│   ├── auth_check.php           # Middleware de control de acceso por URL directa
│   ├── index.php                # Dashboard principal con métricas pastorales en vivo
│   ├── eventos.php              # Gestor de calendario y marcado de fechas fijas de comunión/confirmación
│   ├── intenciones.php          # Consolidado de Oración de los Fieles dominical y botón wa.me
│   ├── citas.php                # Gestor y atención de citas pastorales
│   ├── muro_admin.php           # Moderación de peticiones devocionales (ocultar / eliminar)
│   └── mensajes.php             # Bandeja de entrada de notaría
├── sql/
│   ├── schema.sql               # Definición DDL relacional (10 tablas)
│   └── datos_ejemplo.sql        # Semillas iniciales, capillas confirmadas y calendario litúrgico
├── docs/                        # Documentación metodológica fase por fase
└── README.md                    # Manual de usuario, despliegue y supuestos
```

---

## 3. Funcionalidades Implementadas por Módulo

### Módulo 1: Información Institucional y Contacto (RF-01, RF-18, RF-19)
- **Historia y Bienvenida Pastoral:** Sección destacada con cita del Párroco Pbro. Francisco Javier Morales `[SUPUESTO]`.
- **Directorio Parroquial:** Tarjetas de equipo pastoral, templo sede y directorio territorial de capillas filiales, destacando la confirmada **Capilla del Observatorio (Sectores 14 y 15)**.
- **Mapa Interactivo Embebido:** Integración accesible de mapa geográfico centrado en Tehuacán, Puebla.
- **Botón Flotante y Enlaces WhatsApp:** Botón fijo inferior (`.whatsapp-float`) con ícono oficial y enlaces directos con mensaje prellenado a `wa.me/522383820000` `[SUPUESTO]`.

### Módulo 2: Sacramentos y Trámites (RF-03, RF-20)
- **Guía Interactiva en Pestañas:** Pestañas accesibles para Bautismo, Primera Comunión, Confirmación y Matrimonio con acordeones para documentos, padrinos y pláticas.
- **Generador de Lista Imprimible en PDF:** Función en `js/sacramentos.js` que construye un documento imprimible con membrete oficial parroquial, listo para imprimir o guardar en PDF desde el navegador.
- **Estipendios Orientativos:** Señalización explícita de cuotas sugeridas voluntarias con el marcador `[SUPUESTO]` (ej.: Bautismo $250 MXN, Matrimonio $1,200 MXN).

### Módulo 3: Servicios, Intenciones de Misa y Citas (RF-02, RF-09, RF-21, RF-22, RF-23)
- **Filtrado Dinámico de Horarios:** Selector en tiempo real para visualizar misas del Templo Parroquial o de la Capilla del Observatorio.
- **Modal de Solicitud de Citas:** Formulario accesible que registra la solicitud en MySQL (`citas`) y dispara correo automático a la notaría parroquial (RF-23).
- **Modal de Intenciones de Misa:** Registro de intenciones de sufragio de difuntos, salud y acción de gracias vinculadas a una fecha y capilla específica.

### Módulo 4: Calendario Litúrgico y Eventos (RF-16, RF-17)
- **Motor Mensual Interactivo:** Navegación hacia adelante y atrás por meses, botón para regresar a "Hoy" y selector de sede/capilla.
- **Doble Codificación y Tipos de Eventos:**
  1. *Festividad o peregrinación:* Distintivo verde e ícono.
  2. *Celebración comunitaria de sacramento:* Muestra únicamente el tipo de sacramento y la hora (ej.: "Celebración de Bautismo 12:00 hrs"), protegiendo la privacidad de los solicitantes.
  3. *Fechas fijas oficiales:* Al público se muestran **fijas (solo lectura)** con pin distintivo (ej.: Confirmaciones 15 de Noviembre, Primeras Comuniones 22 de Noviembre).
- **Identificador Litúrgico Canónico:** Color del tiempo litúrgico (verde, morado, blanco, rojo), santoral del día y grado de celebración (Feria, Memoria, Fiesta, Solemnidad) cargados desde la base de datos o fallback oficial.
- **Modo Accesible para Dispositivos Móviles:** En pantallas < 768 px la grilla se sustituye por una lista cronológica vertical (`.calendar-mobile-list`).

### Módulo 5: Grupos Parroquiales y Voluntariado (RF-24)
- **Fichas Informativas:** Tarjetas de Pastoral Juvenil, Catequesis Infantil y Cáritas Parroquial con información de misión, horario de reunión y coordinador responsable `[SUPUESTO]`.
- **Llamado a la Acción (CTA WhatsApp):** Botón *"Unirme al grupo"* con redirección directa a la conversación de WhatsApp con texto introductorio prellenado.

### Módulo 6: Muro de Oraciones e Intenciones Virtuales (RF-25 al RF-31)
- **Publicación Comunitaria:** Formulario modal con selección de categoría (Salud, Trabajo, Difuntos, Familia, Agradecimiento) y opción de anonimato estricto.
- **Velita Virtual Activa de 7 Días:** Al encenderse, se calcula `fecha_expiracion = NOW() + 7 días`. Pasado este lapso, la velita concluye su ciclo.
- **Intercesión Dinámica "Yo rezo por ti":** Cada clic suma una oración y aviva la animación de la flama en CSS mediante clases escalonadas (`flame-sm`, `flame-md`, `flame-lg`, `flame-max`), con tope máximo de diseño.
- **Control de Abuso y Spam (RNF-11):** Registro de dirección IP y token de visitante; limitación estricta de una sola oración por visitante por intención cada 24 horas.
- **Sincronización Periódica (RF-28):** Consulta asíncrona cada 35 segundos para reflejar en pantalla las oraciones unidas sin necesidad de recargar la página.

### Panel de Administración Pastoral (`admin/`)
- **Autenticación Basada en Sesión:** Control estricto en `admin/auth_check.php`; la navegación directa por URL redirige de inmediato a `login.php` (RNF-03).
- **Cifrado de Contraseñas:** Validación mediante `password_verify` y hashes BCRYPT (RNF-04).
- **Consolidado de Oración de los Fieles:** Vista pastoral clasificada por difuntos, enfermos y familias, con botón para imprimir el guion litúrgico dominical y acción rápida *"Marcar como Mencionada en misa"*, la cual dispara aviso por correo y genera enlace `wa.me` prellenado para el sacristán.
- **Gestión de Eventos y Fechas Fijas:** Creación y modificación de eventos litúrgicos (RF-17).
- **Gestión de Citas y Mensajes:** Marcado de citas atendidas y lectura de correspondencia parroquial.
- **Moderación del Muro:** Ocultación y eliminación de intenciones con datos sensibles o lenguaje inapropiado (RF-31).

---

## 4. Matriz de Verificación y Pruebas Realizadas (Sección 10)

| Criterio Evaluado | Estado | Resultado Obtenido en las Pruebas |
|---|---|---|
| **Secciones mínimas obligatorias** | Cumplido | Presentes: Inicio, La Parroquia (Información), Sacramentos (Servicios), Calendario (Avisos/Eventos), Muro de Oraciones, Grupos, Galería y Contacto. |
| **Requisitos RF/RNF asociados** | Cumplido | Cada función implementada cuenta con su trazabilidad hacia los requisitos RF-01 al RF-31 y RNF-01 al RNF-12. |
| **Marcadores de supuestos** | Cumplido | Todo dato no confirmado por la parroquia lleva la etiqueta visible `[SUPUESTO]` en código, base de datos y vistas. |
| **HTML5 semántico y accesible** | Cumplido | Estructura con `header`, `nav`, `main`, `section`, `article`, `footer`, un único `h1` en portada y etiquetas `<label>` en formularios. |
| **Bootstrap 5.3 y estilos propios** | Cumplido | Bootstrap 5.3 CDN cargado sin colisiones; variables CSS en `css/styles.css`; sin estilos en línea. |
| **Imágenes con texto `alt`** | Cumplido | Todas las imágenes cuentan con atributo `alt` descriptivo o decorativo. |
| **Navegación funcional** | Cumplido | Menú hamburguesa colapsable en móvil, enlace de salto para teclado (`.skip-link`) y enlaces ancla suaves funcionando. |
| **Validación de formularios** | Cumplido | Controles con validación en cliente (HTML5/JS) y sanitización en servidor con mensajes flotantes de confirmación. |
| **Calendario dinámico litúrgico** | Cumplido | Cambia de mes, filtra por capilla, muestra el color litúrgico y santoral; los eventos de sacramento comunitario muestran solo tipo y hora; fechas de comunión y confirmación visibles como fijas en solo lectura. |
| **Muro de velitas virtuales** | Cumplido | Admite peticiones anónimas o con nombre; expira a los 7 días; la flama crece con "Yo rezo por ti"; el contador se actualiza; bloqueo de doble oración por visitante en 24 hrs. |
| **Seguridad del Panel Admin** | Cumplido | Sin sesión activa no se puede abrir ninguna vista de `admin/` por URL directa (redirección a `login.php`); contraseñas cifradas; el párroco visualiza el consolidado y marca "Mencionada en misa". |
| **Seguridad PDO y XSS** | Cumplido | Consultas con sentencias preparadas PDO; sanitización con `clean_string` (`htmlspecialchars`) en todas las salidas; datos de contacto nunca expuestos en público. |
| **Adaptabilidad Responsiva** | Cumplido | Interfaz verificada en 360 px (móvil estrecho), 768 px (tablet) y 1200 px (escritorio). |

---

## 5. Registro de Incidencias y Correcciones

1. **Incidencia 1:** En pantallas móviles estrechas (< 576 px), la cuadrícula mensual de 7 columnas del calendario provocaba compresión excesiva en el texto de los eventos.  
   - *Corrección:* Se implementó una media query que oculta la cuadrícula densa en móviles y activa automáticamente una lista cronológica accesible (`.calendar-mobile-list`) con tarjetas legibles y espaciadas.
2. **Incidencia 2:** Riesgo de peticiones recurrentes excesivas (DDoS no intencional o spam) en el endpoint de velitas `api/intenciones.php`.  
   - *Corrección:* Se añadió en el backend una validación por dirección IP (`ip_creacion`) que limita a un máximo de 5 peticiones por hora por usuario, y un control en `localStorage` que impide que un mismo navegador oré dos veces por la misma intención el mismo día.
3. **Incidencia 3:** Dependencia de conexión con MySQL para pruebas iniciales o evaluaciones en entornos estáticos sin PHP activo.  
   - *Corrección:* Los scripts JavaScript (`calendario.js`, `muro.js`, `sacramentos.js`) incorporan un mecanismo de degradación elegante (graceful degradation) que provee datos locales enriquecidos y persistencia en `localStorage` si el servidor backend no responde, garantizando que el sitio funcione al 100% tanto en local como en un servidor con PHP/MySQL.

---

## 6. Registro de Trabajo del Agente (Fase 5)

| Campo | Detalle |
|---|---|
| **Fecha de ejecución** | 5 de octubre de 2026 |
| **Instrucción recibida** | Programar el sitio completo (front-end, back-end ligero en PHP, base de datos SQL y panel administrativo), documentar tecnologías, estructura del código, funcionalidades y pruebas realizadas. |
| **Resultado obtenido** | Sistema `vinea-comunidad/` completamente implementado con `index.html`, `css/styles.css`, 4 módulos JS, 6 endpoints PHP en `api/`, panel de control con 9 vistas en `admin/`, esquema relacional en `sql/schema.sql`, datos semilla en `sql/datos_ejemplo.sql`, y el presente informe técnico `docs/fase5_desarrollo_implementacion.md`. |
| **Decisión tomada 1** | Se dotó a los scripts JavaScript de capacidades híbridas (cliente-servidor): se comunican con `api/` vía AJAX/Fetch y, en caso de ausencia de base de datos activa, conmutan de forma transparente a simulación enriquecida con `localStorage`. |
| **Motivo** | Permitir que el equipo pueda demostrar y evaluar el proyecto tanto abriendo el archivo localmente en cualquier navegador como desplegándolo en un servidor con PHP y MySQL. |
| **Alternativa descartada** | Bloquear la interfaz con errores si no había MySQL corriendo; descartado para salvaguardar la experiencia de evaluación del equipo. |
| **Decisión tomada 2** | Se generó un diseño ceremonial de alta estética para la velita virtual mediante CSS puro (cuerpo de cera marfil degradado, mecha oscura y flama con animación `@keyframes flicker` y resplandor áureo). |
| **Motivo** | Lograr el efecto visual de solemnidad y calidez devocional exigido en el requerimiento del Muro de Oraciones sin ralentizar los dispositivos móviles de los feligreses. |
| **Alternativa descartada** | Uso de librerías de partículas en 3D pesadas (Three.js); descartado por consumo excesivo de batería y recursos en teléfonos antiguos. |

---
*Fin del documento de Fase 5.*
