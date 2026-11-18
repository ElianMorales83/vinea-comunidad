# Vinea Comunidad — Análisis de Requerimientos del Sistema (Fase 1)

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

## 1. Introducción y Propósito

El presente documento formaliza la especificación de requerimientos de software para el sistema web **Vinea Comunidad**. Su objetivo es establecer de forma exhaustiva, estructurada y verificable las necesidades de la comunidad feligrés, de los solicitantes de servicios sacramentales y del equipo pastoral de la Parroquia María Madre de Dios, delimitando con precisión los requisitos funcionales (RF) y no funcionales (RNF) que conforman el alcance del entregable evaluado.

---

## 2. Matriz de Necesidades y Objetivos del Sistema

| ID Necesidad | Problema Detectado | Objetivo en Vinea Comunidad | Impacto Esperado |
|---|---|---|---|
| **NEC-01** | La información parroquial se difunde exclusivamente en Facebook de forma cronológica, mezclada y efímera. | Centralizar la información oficial en un portal web categorizado, accesible y consultable sin cuenta de red social. | Consulta directa e inmediata para el 100% de los visitantes. |
| **NEC-02** | Desplazamientos innecesarios a notaría por dudas frecuentes sobre papelería y trámites sacramentales. | Proveer guías interactivas paso a paso por sacramento y formatos de requisitos descargables en PDF. | Desahogo de la notaría parroquial y mayor claridad para familias y padrinos. |
| **NEC-03** | Incompatibilidad de horarios de oficina (cerrado lunes, martes a sábado 15:00-19:00, domingo 10:00-14:00). | Habilitar solicitudes digitales de intenciones de misa y citas pastorales las 24 horas del día. | Mayor accesibilidad para feligreses que trabajan o residen lejos. |
| **NEC-04** | Desconocimiento de eventos y misas en las capillas filiales y sectores (ej. Capilla del Observatorio). | Ofrecer un calendario litúrgico y de eventos dinámico, con filtro selector por capilla y sector. | Integración comunitaria y visibilidad equilibrada para todas las capillas. |
| **NEC-05** | Ausencia de un canal comunitario devocional para personas enfermas, afligidas o alejadas del templo. | Implementar el Muro de Oraciones e Intenciones Virtuales con velitas de 7 días y flamas interactivas. | Fomentar la comunión espiritual y el apoyo solidario entre hermanos. |
| **NEC-06** | Dificultad para el sacerdote en recopilar las intenciones reales de la comunidad para la misa dominical. | Disponer de un panel sacerdotal que consolide las intenciones semanales para la Oración de los Fieles. | Atención pastoral directa y enriquecimiento de la liturgia viva. |

---

## 3. Modelo de Actores y Usuarios

```
                          ┌────────────────────────┐
                          │   ACTORES DEL SISTEMA  │
                          └───────────┬────────────┘
                                      │
         ┌────────────────────────────┼────────────────────────────┐
         │                            │                            │
         ▼                            ▼                            ▼
┌──────────────────┐        ┌──────────────────┐        ┌──────────────────┐
│ Feligrés General │        │   Solicitante    │        │  Administrador   │
│   (Comunidad)    │        │ de Sacramentos   │        │     Pastoral     │
└────────┬─────────┘        └────────┬─────────┘        └────────┬─────────┘
         │                           │                           │
  - Horarios de misa          - Requisitos y PDF          - Párroco: consolida
  - Avisos y eventos          - Fechas comunitarias         intenciones y citas
  - Muro de oraciones         - Solicitud de citas        - Sacristán: eventos,
  - Unirse a grupos           - Donativos orientativos      avisos y horarios
```

1. **Feligrés Comunitario:** Usuario que consulta información general, busca horarios de misas de su sector, lee avisos y enciende velitas o reza por otros en el Muro de Oraciones.
2. **Solicitante de Trámites y Sacramentos:** Usuario con una necesidad específica (bautizar, casarse, confirmar a un hijo, pedir misa de difunto o bendición). Requiere requisitos exactos y agenda de citas.
3. **Párroco (Administrador Pastoral):** Sacerdote responsable de la parroquia. Utiliza el panel para consultar el consolidado de intenciones para la Oración de los Fieles, autorizar citas pastorales y supervisar el contenido comunitario.
4. **Sacristán / Notario (Administrador Operativo):** Personal administrativo que actualiza avisos, gestiona el calendario litúrgico y de eventos comunitarios, marca citas atendidas y modera el Muro de Oraciones.

---

## 4. Requisitos Funcionales (RF)

### 4.1 Módulo 1: Información Institucional y Contacto
- **RF-01: Visualización de información institucional y bienvenida pastoral.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe presentar la historia de la parroquia, su identidad mariana, su misión diocesana y la bienvenida del párroco.  
  *Beneficiario:* Comunidad general.

- **RF-18: Directorio pastoral, capillas, sectores y mapa interactivo.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe desplegar el directorio de capillas filiales con indicación de sectores (ej. Capilla del Observatorio - Sectores 14 y 15), el equipo pastoral y un mapa interactivo incrustado (Google Maps o Leaflet) con la ubicación geográfica del templo principal y de sus capillas.  
  *Beneficiario:* Comunidad general y visitantes foráneos.

- **RF-19: Botón flotante y enlaces directos a WhatsApp.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe incluir un botón flotante accesible en todo momento y enlaces en la sección de contacto que redirijan a chats de WhatsApp (`wa.me`) con mensaje prellenado de saludo y consulta para la notaría parroquial.  
  *Beneficiario:* Todos los usuarios.

### 4.2 Módulo 2: Sacramentos y Trámites
- **RF-03: Consulta estructurada de requisitos por sacramento.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe permitir consultar de forma organizada los requisitos, documentación oficial requerida, pláticas previas y edades/precondiciones para: Bautismo, Primera Comunión, Confirmación y Matrimonio.  
  *Beneficiario:* Solicitantes de sacramentos.

- **RF-20: Guía interactiva de trámites, descarga en PDF y estipendios orientativos.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe presentar fichas interactivas con acordeones o pestañas para cada sacramento, botones para descargar la lista de requisitos en formato imprimible PDF, y la visualización de estipendios o cuotas de recuperación sugeridas con la debida aclaración de su naturaleza orientativa y voluntaria `[SUPUESTO]`.  
  *Beneficiario:* Solicitantes de sacramentos.

### 4.3 Módulo 3: Servicios, Intenciones de Misa y Citas
- **RF-02: Consulta y filtrado de horarios de misa por capilla y sector.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe permitir al usuario consultar los horarios de misas dominicales y de entre semana filtrando dinámicamente por capilla y sector territorial.  
  *Beneficiario:* Comunidad feligrés.

- **RF-09: Registro y almacenamiento de intenciones y citas en base de datos.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe capturar y registrar en la base de datos MySQL todas las intenciones de misa y solicitudes de citas enviadas a través del portal.  
  *Beneficiario:* Administradores y solicitantes.

- **RF-21: Solicitud digital de intenciones de misa.**  
  *Alcance:* Dentro.  
  *Descripción:* El usuario debe poder registrar solicitudes de intenciones de misa especificando: tipo de intención (Salud, Eterno Descanso de Difuntos, Acción de Gracias, Necesidades Especiales), nombre de la persona o familia, capilla seleccionada, fecha y horario de misa deseada.  
  *Beneficiario:* Solicitantes.

- **RF-22: Agenda interactiva de citas pastorales y administrativas.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe proveer un formulario para agendar citas con el párroco o con la notaría, seleccionando motivo (atención espiritual, preparación matrimonial, trámite de actas, bendición), fecha y turno de horario disponible.  
  *Beneficiario:* Solicitantes.

- **RF-23: Notificación por correo electrónico al equipo parroquial.**  
  *Alcance:* Dentro.  
  *Descripción:* Tras el registro de una nueva cita o intención, el sistema debe disparar un correo electrónico automático al buzón de la notaría parroquial con los datos resumidos para su seguimiento oportuno.  
  *Beneficiario:* Administradores parroquiales.

### 4.4 Módulo 4: Calendario Litúrgico y Eventos
- **RF-16: Calendario mensual público y litúrgico con filtro por capilla (Solo lectura).**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe ofrecer una vista de calendario mensual dinámico en JavaScript ligero (sin dependencias pesadas), navegable mes a mes, filtrable por capilla, que distinga tres tipos de eventos mediante color y etiqueta textual:
  1. *Festividades o peregrinaciones:* Fiestas patronales, Semana Santa, aniversarios de capillas.
  2. *Celebraciones comunitarias de sacramentos:* Muestra únicamente "Celebración de [Sacramento]" y la hora (sin datos personales).
  3. *Fechas fijas de Primera Comunión y Confirmación:* Fechas fijas visibles en modo solo lectura para la feligresía.
  Además, cada día debe exhibir el identificador litúrgico (color del tiempo litúrgico, santoral del día y grado: Fiesta/Memoria/Solemnidad). En dispositivos móviles se proveerá una vista en lista de próximos eventos para máxima accesibilidad.  
  *Beneficiario:* Feligreses y comunidad.

- **RF-17: Gestión administrativa del calendario y fechas fijas.**  
  *Alcance:* Dentro.  
  *Descripción:* Los administradores autenticados deben poder crear, editar, reprogramar y eliminar eventos litúrgicos, celebraciones comunitarias y actualizar las fechas oficiales fijas de Primera Comunión y Confirmación desde el panel de control.  
  *Beneficiario:* Párroco y Sacristán.

### 4.5 Módulo 5: Grupos Parroquiales y Voluntariado
- **RF-24: Catálogo de grupos, ministerios y enlace directo de integración (CTA WhatsApp).**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe desplegar tarjetas descriptivas de cada ministerio o grupo parroquial (Pastoral Juvenil, Catequesis Infantil, Coro Parroquial, Ministros Extraordinarios de la Comunión, Cáritas Parroquial), indicando misión, días y horas de reunión, nombre del coordinador (marcado con `[SUPUESTO]` si no está autorizado formalmente) y un botón de llamada a la acción "Unirme al grupo" con redirección al grupo o chat de WhatsApp correspondiente.  
  *Beneficiario:* Jóvenes, adultos y servidores de la comunidad.

### 4.6 Módulo 6: Muro de Oraciones e Intenciones Virtuales
- **RF-25: Publicación comunitaria de peticiones con opción de anonimato.**  
  *Alcance:* Dentro.  
  *Descripción:* Cualquier feligrés debe poder publicar una intención o petición de oración, seleccionando categoría (Salud, Trabajo, Difuntos, Familia, Acción de Gracias), ingresando el texto de la petición y eligiendo entre publicar con su nombre de pila o como "Anónimo".  
  *Beneficiario:* Feligreses de la comunidad.

- **RF-26: Velita virtual devocional con ciclo de vida de 7 días.**  
  *Alcance:* Dentro.  
  *Descripción:* Toda intención aprobada u orientada al muro enciende automáticamente una velita virtual asociada, registrando `fecha_publicacion` y `fecha_expiracion` (a los 7 días calendario). Al vencer el plazo, la velita se apaga simbólicamente y la intención se traslada al histórico pastoral.  
  *Beneficiario:* Feligreses.

- **RF-27: Acción intercesora "Yo rezo por ti" con animación de flama dinámica.**  
  *Alcance:* Dentro.  
  *Descripción:* Cada visitante puede hacer clic en "Yo rezo por ti" para orar por una intención ajena. La acción incrementa el contador de oraciones de la velita y activa una animación CSS que aumenta el tamaño, fulgor y brillo de la flama (con límite superior predefinido para mantener la armonía visual).  
  *Beneficiario:* Toda la comunidad orante.

- **RF-28: Sincronización asíncrona periódica y reconocimiento anónimo de autoría.**  
  *Alcance:* Dentro.  
  *Descripción:* El muro debe actualizar periódicamente los contadores mediante consultas asíncronas (polling cada 30-60 segundos) sin recargar la página. Para los autores de intenciones anónimas, el navegador almacena un identificador aleatorio local seguro (sin recopilar datos personales) para mostrarles mensajes como *"3 personas han rezado por tu intención"*.  
  *Beneficiario:* Autores de intenciones.

- **RF-29: Panel sacerdotal para Oración de los Fieles y marcado "Mencionada en misa".**  
  *Alcance:* Dentro.  
  *Descripción:* El párroco debe contar en el panel administrativo con una vista consolidada de intenciones activas, filtrables por fecha y categoría, diseñada para preparar la Oración de los Fieles de la liturgia dominical, con un botón de acción rápida para marcar la intención como "Mencionada en misa" indicando fecha y hora de la celebración.  
  *Beneficiario:* Párroco.

- **RF-30: Notificación de seguimiento pastoral.**  
  *Alcance:* Dentro.  
  *Descripción:* Cuando una intención es marcada como "Mencionada en misa":
  - Si el usuario suministró correo electrónico opcional, el sistema envía un mensaje automático notificándole la celebración.
  - Si suministró número de WhatsApp opcional, el panel genera un botón con enlace `wa.me` y texto prellenado para que el sacristán pueda enviárselo con un clic desde su dispositivo (cumpliendo la política de no requerir APIs de pago).  
  *Beneficiario:* Solicitantes y equipo pastoral.

- **RF-31: Moderación y prevención de contenidos sensibles.**  
  *Alcance:* Dentro.  
  *Descripción:* El sistema debe advertir al usuario no ingresar apellidos completos, diagnósticos clínicos confidenciales ni datos de terceros. Los administradores disponen en el panel de herramientas para ocultar, editar o eliminar intenciones inapropiadas o que vulneren la privacidad.  
  *Beneficiario:* Administradores y comunidad.

### 4.7 Panel de Administración y Seguridad
- **RF-10 al RF-14: Autenticación, control de acceso y gestión general.**  
  *Alcance:* Dentro.  
  *Descripción:* Panel con inicio de sesión seguro para Párroco y Sacristán; gestión de avisos parroquiales, horarios de misa, edición de requisitos, aprobación de citas (marcar como atendida/confirmada) y lectura de mensajes de contacto.  
  *Beneficiario:* Equipo pastoral.

---

## 5. Requisitos No Funcionales (RNF)

| ID | Nombre | Categoría | Criterio de Aceptación / Métrica |
|---|---|---|---|
| **RNF-01** | Rendimiento y ligereza | Rendimiento | Carga inicial inferior a 2.5 segundos en red 4G estándar; uso exclusivo de Bootstrap 5.3 CDN, CSS nativo y JS modular sin librerías pesadas. |
| **RNF-02** | Diseño responsivo multi-dispositivo | Usabilidad / Portabilidad | Adaptación fluida y probada en resoluciones móvil (360 px), tablet (768 px) y escritorio (1200 px), con menú colapsable accesible. |
| **RNF-03** | Control de acceso y sesiones seguras | Seguridad | Ninguna página dentro del directorio `admin/` puede ser vista mediante acceso directo por URL sin sesión activa en PHP; redirección automática a `login.php`. |
| **RNF-04** | Cifrado robusto de contraseñas | Seguridad | Contraseñas de usuario administradas exclusivamente mediante algoritmos seguros con sal (`password_hash` con BCRYPT) en la base de datos MySQL. |
| **RNF-05** | Usabilidad para adultos mayores | Accesibilidad / Usabilidad | Tipografía con tamaño mínimo base de 16 px, alto contraste de lectura, jerarquía visual limpia, botones de tamaño táctil mínimo de 44x44 px y lenguaje amigable sin tecnicismos. |
| **RNF-06** | Accesibilidad universal (WCAG AA) | Accesibilidad | Cumplimiento de WCAG 2.1 nivel AA: navegación completa mediante tabulador de teclado, foco visual destacado, todos los elementos gráficos con texto alternativo `alt`, etiquetas `<label>` vinculadas a cada control de formulario. |
| **RNF-07** | Semántica web estándar | Calidad de Software | Estructura HTML5 semántica estricta (`header`, `nav`, `main`, `section`, `article`, `footer`), un único encabezado `<h1>` por documento y jerarquía estricta de `<h2>` a `<h6>`. |
| **RNF-08** | Inmunidad a inyecciones SQL | Seguridad | Todas las consultas a MySQL en la capa `api/` y `admin/` se realizan obligatoriamente mediante sentencias preparadas con PDO y vinculación de parámetros tipados (`bindParam`/`execute`). |
| **RNF-09** | Prevención de Cross-Site Scripting (XSS) | Seguridad | Toda salida de texto proveniente de usuarios (especialmente en el Muro de Oraciones, citas y contacto) es sanitizada con `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`. Los scripts inyectados `<script>` se renderizan como texto inofensivo. |
| **RNF-10** | Privacidad y protección de datos | Seguridad / Legal | Los datos personales opcionales (correo, WhatsApp) no son jamás desplegados en vistas públicas; se almacenan en tablas protegidas y se incluye un Aviso de Privacidad visible al pie del portal. |
| **RNF-11** | Control de abuso y mitigación de spam | Confiabilidad | Limitación de publicaciones de peticiones por dirección IP (máximo 3 peticiones por hora por IP) y restricción estricta de una sola oración ("Yo rezo por ti") por visitante por intención cada 24 horas mediante almacenamiento local y validación de cliente/servidor. |
| **RNF-12** | Arquitectura y mantenibilidad | Mantenibilidad | Estructura modular y limpia: separación de estilos en `css/styles.css` con variables CSS para el tema visual, scripts JS desacoplados en `js/`, endpoints RESTful simples en `api/`, código debidamente comentado y sin estilos en línea. |

---

## 6. Matriz de Trazabilidad (Necesidad ➔ Usuario ➔ Requisitos)

| Necesidad | Usuario Beneficiado | Requisitos Funcionales | Requisitos No Funcionales |
|---|---|---|---|
| **NEC-01** (Centralizar información oficial) | Feligrés Comunitario, Visitantes | RF-01, RF-18, RF-19 | RNF-01, RNF-02, RNF-05, RNF-06, RNF-07 |
| **NEC-02** (Claridad en trámites sacramentales) | Solicitantes de Sacramentos | RF-03, RF-20 | RNF-01, RNF-05, RNF-06, RNF-12 |
| **NEC-03** (Disponibilidad 24/7 para citas e intenciones) | Solicitantes, Párroco, Sacristán | RF-02, RF-09, RF-21, RF-22, RF-23 | RNF-03, RNF-08, RNF-09, RNF-10 |
| **NEC-04** (Calendario por capilla y liturgia) | Comunidad, Sacristán, Párroco | RF-16, RF-17 | RNF-01, RNF-02, RNF-05, RNF-08 |
| **NEC-05** (Muro devocional y velitas comunitarias) | Feligrés Comunitario, Enfermos, Familias | RF-25, RF-26, RF-27, RF-28, RF-31 | RNF-01, RNF-09, RNF-10, RNF-11 |
| **NEC-06** (Consolidado sacerdotal para la misa) | Párroco, Sacristán | RF-10 al RF-14, RF-29, RF-30 | RNF-03, RNF-04, RNF-08, RNF-10 |

---

## 7. Alcance Excluido (Trabajos Futuros)

Para garantizar la viabilidad técnica y operativa del proyecto en un entorno de servidor web gratuito con PHP y MySQL, se excluyen explícitamente:
1. **Envío automatizado de mensajes de WhatsApp Business:** Requiere pago recurrente de API oficial de Meta y verificación corporativa. Se reemplaza eficazmente por botones dinámicos con protocolo `wa.me` y texto prellenado.
2. **Dominio personalizado de pago (.com/.org):** Se utilizará el subdominio gratuito provisto por la plataforma de hosting (asegurando conexión cifrada HTTPS).
3. **Pasarela de pagos en línea con tarjeta bancaria:** Incompatible con la política comunitaria sin fines de lucro y con los costos de comisiones bancarias. Los estipendios son orientativos y se canalizan presencialmente o por transferencias directas de la parroquia.

---

## 8. Registro de Trabajo del Agente (Fase 1)

| Campo | Detalle |
|---|---|
| **Fecha de ejecución** | 5 de octubre de 2026 |
| **Instrucción recibida** | Continuar con la Fase 1: Análisis de requerimientos, definiendo necesidades, usuarios, RF-01 al RF-31 y RNF-01 al RNF-12 de acuerdo con las especificaciones de `agente (2).md`. |
| **Resultado obtenido** | Documento `docs/fase1_analisis_requerimientos.md` creado con matriz de necesidades, modelo de actores, especificación detallada de 18 requisitos funcionales (incorporando RF-16, RF-17 y RF-18 a RF-31 para los módulos 7.2 y 7.3), 12 requisitos no funcionales, matriz de trazabilidad y delimitación de alcance futuro. |
| **Decisión tomada 1** | Se incorporó el requisito **RF-16** asignando solo lectura al público en el calendario litúrgico y fijando las fechas de Primera Comunión y Confirmación, mientras que **RF-17** habilita su edición exclusiva por administradores. |
| **Motivo** | Cumplir estrictamente la regla 7.1 y la tabla de la Fase 1 de `agente (2).md`. |
| **Alternativa descartada** | Permitir que los feligreses sugirieran o modificaran fechas en el calendario; descartado para evitar confusiones litúrgicas en la comunidad. |
| **Decisión tomada 2** | En el Muro de Oraciones (RF-28), la sincronización se diseñó mediante consultas asíncronas periódicas (polling HTTP de 30-60s) y el reconocimiento de autor anónimo mediante un identificador aleatorio local. |
| **Motivo** | Los servidores gratuitos de PHP y MySQL no admiten sockets WebSockets bidireccionales permanentes. El polling ligero cumple cabalmente la experiencia interactiva sin sobrecargar el servidor. |
| **Alternativa descartada** | Servidores Node.js con Socket.io; descartado porque el proyecto exige basarse en la arquitectura estándar y sostenible de PHP/MySQL para el equipo. |

---
*Fin del documento de Fase 1. Pendiente de revisión y confirmación del equipo para dar paso a la Fase 2.*
