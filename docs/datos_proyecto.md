# Vinea Comunidad — Documento de Datos del Proyecto (Fase 0)

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
**Versión del Documento:** 1.0  
**Fecha:** 5 de octubre de 2026  

---

## 1. Identidad Institucional y Naturaleza del Proyecto

### 1.1 Naturaleza de la Organización
La **Parroquia María Madre de Dios** es una comunidad religiosa católica perteneciente a la **Diócesis de Tehuacán**, ubicada en la ciudad de Tehuacán, Puebla. Se trata de una institución de culto religioso y de servicio pastoral, estrictamente **sin fines de lucro**.
- **Carácter del sitio web:** Es un proyecto independiente, con enfoque exclusivamente **informativo, pastoral y comunitario**.
- **Delimitación fundamental:** No es una tienda virtual ni persigue objetivos comerciales. Las secciones requeridas por la asignatura se adaptan a su realidad pastoral:
  - *"Productos o servicios"*: Se traduce como **Servicios Pastorales y Trámites Sacramentales** (Bautismo, Primera Comunión, Confirmación, Matrimonio, Unción de los Enfermos, bendiciones y grupos parroquiales).
  - *"Promociones o información relevante"*: Se traduce como **Avisos Parroquiales, Cursos de Catequesis, Pláticas Prematrimoniales/Prebautismales, Peregrinaciones y Eventos Litúrgicos**. No existen ofertas, rebajas ni precios de venta.
  - *"Estipendios o cuotas sugeridas"*: Se presentan única y exclusivamente como **referencias orientativas** para el sostenimiento del templo y de los materiales de formación, marcados con `[SUPUESTO]` mientras la parroquia no los oficialice por escrito.

### 1.2 El Ecosistema "Vinea"
- **Vinea (Escritorio):** Software administrativo interno para el registro parroquial, expedición de actas y gestión de archivos en la notaría parroquial.
- **Vinea Comunidad (Web):** Extensión pública orientada a los feligreses y a la comunidad de Tehuacán. Su propósito es acercar la vida parroquial, facilitar la consulta de requisitos y horarios, canalizar peticiones comunitarias y habilitar la participación devocional activa sin barreras de horario o de plataformas cerradas.

---

## 2. Diagnóstico del Problema y Justificación

### 2.1 Situación Actual y Puntos Críticos
1. **Dispersión y desactualización en redes sociales:** La parroquia depende de una página de Facebook donde los avisos importantes se mezclan con publicaciones piadosas, transmisiones pasadas o avisos caducados, sin una estructura de búsqueda, categorías o filtros por capilla.
2. **Brecha digital y exclusión:** feligreses de la tercera edad o personas que no cuentan con cuenta activa en redes sociales quedan excluidos de la información oportuna.
3. **Horario restrictivo de oficina:** La notaría parroquial atiende únicamente de **martes a sábado de 15:00 a 19:00 horas** y **domingos de 10:00 a 14:00 horas** (lunes cerrado). Quienes laboran en dicho turno o viven en sectores apartados deben desplazarse solo para preguntar requisitos básicos.
4. **Saturación en notaría por dudas repetitivas:** El personal atiende continuamente las mismas preguntas sobre papelería para sacramentos, fechas de catequesis o disponibilidad de citas con el párroco.
5. **Aislamiento de los sectores y capillas:** La comunidad está distribuida en diversas capillas y sectores territoriales (por ejemplo, la Capilla del Observatorio atiende los sectores 14 y 15). Los feligreses a menudo desconocen los horarios de misas o festividades específicas de su propia capilla.

### 2.2 Metas Medibles del Proyecto
1. **Disponibilidad 24/7:** Permitir que el 100% de la información de horarios, requisitos sacramentales, contactos y avisos esté accesible en cualquier momento y desde cualquier dispositivo (móvil, tablet, escritorio).
2. **Reducción de desplazamientos innecesarios:** Proveer requisitos descargables en PDF y guías paso a paso para trámites sacramentales.
3. **Canal devocional propio:** Disponer del **Muro de Oraciones e Intenciones Virtuales**, permitiendo a la feligresía encender velitas virtuales y registrar intenciones que el sacerdote pueda integrar en la Oración de los Fieles.
4. **Entregable académico validado:** Sitio desarrollado con estándares de accesibilidad, código semántico, back-end ligero en PHP/MySQL, documentación exhaustiva en `docs/` y publicación en servidor web accesible públicamente.

---

## 3. Cobertura Parroquial y Estructura Territorial

La Parroquia María Madre de Dios atiende a una amplia demarcación conformada por el templo sede y sus capillas filiales:

| Templo / Sede | Tipo | Sectores que comprende | Horario de Misa Habitual |
|---|---|---|---|
| **Templo Parroquial María Madre de Dios** | Sede Parroquial | Sectores 1 al 13 `[SUPUESTO]` | Martes a Sábado: 19:00 hrs. `[SUPUESTO]`<br>Domingo: 08:00, 10:00, 12:00 y 19:00 hrs. `[SUPUESTO]` |
| **Capilla del Observatorio** | Capilla Filial | **Sectores 14 y 15** (Dato confirmado) | Sábados: 18:00 hrs. `[SUPUESTO]`<br>Domingos: 11:00 hrs. `[SUPUESTO]` |
| **Capilla de San Juan Diego** `[SUPUESTO]` | Capilla Filial | Sectores 16 y 17 `[SUPUESTO]` | Domingos: 09:30 hrs. `[SUPUESTO]` |
| **Capilla de Nuestra Señora de Guadalupe** `[SUPUESTO]` | Capilla Filial | Sectores 18 y 19 `[SUPUESTO]` | Domingos: 17:00 hrs. `[SUPUESTO]` |

*Nota:* Los datos de capillas no confirmados se marcan como `[SUPUESTO]` y podrán ser actualizados directamente en la base de datos a través del panel de administración.

---

## 4. Perfiles de Usuario del Sistema

| Perfil | Descripción | Necesidades Principales en Vinea Comunidad |
|---|---|---|
| **Feligrés de la Comunidad** | Familias, jóvenes y adultos mayores que acuden a misa y a las festividades de su sector. | Consultar horarios de misas filtrados por su capilla, enterarse de avisos y eventos comunitarios, participar en el Muro de Oraciones encendiendo velitas e intercediendo por sus hermanos. |
| **Solicitante de Sacramentos** | Padres de familia, padrinos, novios o familiares que preparan un bautismo, primera comunión, confirmación o matrimonio. | Consultar requisitos claros, descargar listas de documentos oficiales en PDF, conocer fechas fijas de ceremonias comunitarias y agendar citas pastorales con el párroco. |
| **Voluntario / Miembro Pastoral** | Fieles interesados en sumarse a coros, catequesis, liturgia, jóvenes o Cáritas parroquial. | Conocer horarios de reunión de ministerios y acceder directamente al grupo de WhatsApp mediante el botón *"Unirme al grupo"*. |
| **Administradores (Párroco y Sacristán)** | Responsables de la conducción pastoral y del mantenimiento de la información. | Publicar y editar avisos, actualizar horarios, gestionar el calendario litúrgico y de eventos, revisar solicitudes de citas, y consultar el consolidado semanal de intenciones del Muro para las misas. |

---

## 5. Módulos y Servicios del Sistema

1. **Módulo 1: Información Institucional y Contacto:**
   - Historia y bienvenida pastoral.
   - Directorio del equipo sacerdotal y colaboradores.
   - Directorio territorial de capillas y sectores.
   - Mapa interactivo con ubicación de la sede y capillas.
   - Botón flotante y enlaces directos a WhatsApp para atención rápida.
2. **Módulo 2: Sacramentos y Trámites:**
   - Guías interactivas para Bautismo, Primera Comunión, Confirmación y Matrimonio.
   - Descarga de formatos y listas de requisitos en PDF.
   - Estipendios de referencia orientativos debidamente etiquetados.
3. **Módulo 3: Servicios, Intenciones y Citas:**
   - Solicitud digital de intenciones de misa (salud, difuntos, acción de gracias) seleccionando capilla y horario.
   - Solicitud de citas pastorales con notificación y confirmación administrativa.
4. **Módulo 4: Calendario Litúrgico y Eventos:**
   - Calendario dinámico con vista mensual y navegación entre meses.
   - Filtro por capilla y sector.
   - Identificación visual litúrgica del día (Tiempo Ordinario, Cuaresma, Pascua, Adviento; santoral y solemnidad).
   - Fechas fijas comunitarias de Primera Comunión y Confirmación (solo lectura para el público).
   - Lista accesible complementaria de próximos eventos para dispositivos móviles.
5. **Módulo 5: Grupos Parroquiales y Voluntariado:**
   - Fichas de grupos (Catequesis infantil, Pastoral Juvenil, Coro Parroquial, Ministros Extraordinarios de la Comunión, Cáritas).
   - Datos del coordinador (con consentimiento previo) y llamado a la acción (`wa.me`) para integrarse.
6. **Módulo 6: Muro de Oraciones e Intenciones Virtuales:**
   - Publicación comunitaria (con opción anónima o con nombre de pila).
   - Velitas virtuales con encendido activo durante 7 días y flama interactiva sensible al número de oraciones ("Yo rezo por ti").
   - Consulta periódica asíncrona para actualizar oraciones en tiempo real sin recargar página.
   - Dashboard sacerdotal para la Oración de los Fieles dominical y marcado de "Mencionada en misa".

---

## 6. Inventario Consolidado de Supuestos `[SUPUESTO]`

Para cumplir con la regla de transparencia del agente, todos los datos que no fueron provistos en el documento inicial del equipo se identifican a continuación con el marcador `[SUPUESTO]` para que el equipo los confirme o reemplace oportunamente:

1. `[SUPUESTO-01]` **Dirección exacta de la sede parroquial:** Calle 5 Poniente #120, Col. Centro, Tehuacán, Puebla, C.P. 75700.
2. `[SUPUESTO-02]` **Teléfono de notaría:** +52 238 382 0000.
3. `[SUPUESTO-03]` **Correo de notaría:** `notaria@parroquiamariamadrededios.org` / `parroquia.mariamadrededios.teh@gmail.com`.
4. `[SUPUESTO-04]` **Nombre del Párroco:** Pbro. Lic. Francisco Javier Morales `[SUPUESTO]`.
5. `[SUPUESTO-05]` **Nombre del Sacristán:** C. Mateo Bautista `[SUPUESTO]`.
6. `[SUPUESTO-06]` **Capillas filiales adicionales:** Se asumieron dos capillas filiales además de la confirmada Capilla del Observatorio: Capilla de San Juan Diego (Sectores 16 y 17) y Capilla de Ntra. Sra. de Guadalupe (Sectores 18 y 19).
7. `[SUPUESTO-07]` **Horarios detallados de misa:** Se definieron horarios tentativos de misas dominicales (08:00, 10:00, 12:00, 19:00 hrs en sede; sábados 18:00 y domingos 11:00 en Capilla del Observatorio).
8. `[SUPUESTO-08]` **Estipendios orientativos sugeridos:** Bautismo comunitario: $250 MXN; Bautismo individual: $500 MXN; Matrimonio: $1,200 MXN; Intención de misa ordinaria: $50 MXN (etiquetados con leyenda de donativo voluntario).
9. `[SUPUESTO-09]` **Fechas de Primera Comunión y Confirmación fijas:** Ceremonia Comunitaria de Confirmación: 15 de Noviembre de 2026, 11:00 hrs, Templo Parroquial; Primeras Comuniones: 22 de Noviembre de 2026, 10:00 hrs, Templo Parroquial.
10. `[SUPUESTO-10]` **Grupos y coordinadores:** Se listan coordinadores tentativos con enlaces simulados a `wa.me/522380000000`.
11. `[SUPUESTO-11]` **Credenciales iniciales del panel:** Usuario `admin_parroquia` con clave temporal segura hash `admin2026#Vinea` sujeta a cambio inmediato en la primera sesión.

---

## 7. Registro de Trabajo del Agente (Fase 0)

| Campo | Detalle |
|---|---|
| **Fecha de ejecución** | 5 de octubre de 2026 |
| **Instrucción recibida** | *"Ejecuta y cumple con lo establecio en el archivo de agente/2).md"* — Iniciar y consolidar Fase 0 (Datos del Proyecto). |
| **Resultado obtenido** | Documento `docs/datos_proyecto.md` generado en la raíz del proyecto con la caracterización institucional, problemas, objetivos, usuarios, alcance de los 6 módulos y catálogo de 11 supuestos debidamente identificados. |
| **Decisión tomada 1** | Se adopta una interpretación pastoral para las secciones de la asignatura ("servicios pastorales" y "avisos/cursos") para respetar la naturaleza no comercial de la parroquia. |
| **Motivo** | Cumplir el criterio de prioridad #1 del agente: la necesidad real y fidedigna de la parroquia y de su comunidad feligrés. |
| **Alternativa descartada** | Presentar un catálogo tipo tienda virtual con precios y carrito de compra; se descartó por ser completamente ajeno a una comunidad católica parroquial. |
| **Decisión tomada 2** | Se estructura el proyecto en el directorio de trabajo local con carpetas separadas (`css/`, `js/`, `img/`, `api/`, `admin/`, `sql/`, `docs/`) de acuerdo a la arquitectura obligatoria. |
| **Motivo** | Garantizar orden técnico, escalabilidad y estricta conformidad con el marco de evaluación de la asignatura. |
| **Alternativa descartada** | Código monolítico en un único archivo HTML o frameworks pesados como React/Angular (descartados explícitamente en el reglamento del agente por exceder la capacidad de sustento del equipo). |

---
*Fin del documento de Fase 0. Pendiente de revisión y confirmación del equipo para dar paso a la Fase 1.*
