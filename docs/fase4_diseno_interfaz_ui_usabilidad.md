# Vinea Comunidad — Diseño de Interfaz (UI) y Usabilidad (Fase 4)

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

## 1. Fundamentos Visuales e Identidad Institucional

La interfaz visual de **Vinea Comunidad** está diseñada para proyectar solemnidad litúrgica, paz espiritual y cercanía comunitaria. Se basa en una composición moderna, limpia y armónica, combinando el marco responsivo de **Bootstrap 5.3** con un sistema de diseño propio documentado en variables CSS (`:root`) en `css/styles.css`, evitando por completo estilos en línea o sobrecargas visuales.

---

## 2. Sistema de Diseño y Tokens Visuales (CSS Custom Properties)

```css
:root {
  /* Paleta Principal Institucional */
  --color-primary: #1e3a8a;          /* Azul mariano profundo (Identidad de María Madre de Dios) */
  --color-primary-hover: #172554;    /* Azul medianoche para interacción */
  --color-primary-light: #eff6ff;    /* Fondo azul sutil */
  
  --color-accent: #d97706;           /* Oro eclesiástico cálido / Ámbar litúrgico */
  --color-accent-hover: #b45309;     /* Oro bruñido para hover */
  --color-accent-light: #fef3c7;     /* Fondo cálido para alertas y destacados */
  
  /* Fondos y Superficies */
  --bg-page: #f8fafc;                /* Gris marfil muy tenue para reducir fatiga visual */
  --bg-surface: #ffffff;             /* Blanco puro en tarjetas y contenedores */
  --bg-surface-alt: #f1f5f9;         /* Gris perla para secciones alternadas */
  
  /* Tipografía y Textos de Alto Contraste (Cumplimiento WCAG AA > 7:1) */
  --text-main: #0f172a;              /* Azul pizarra casi negro para legibilidad óptima */
  --text-muted: #475569;             /* Gris neutro para metadatos y descripciones */
  --text-light: #ffffff;             /* Blanco para texto sobre fondos oscuros */
  
  /* Colores Oficiales del Calendario Litúrgico */
  --liturgico-verde: #166534;        /* Tiempo Ordinario: Esperanza y crecimiento */
  --liturgico-morado: #6b21a8;       /* Cuaresma y Adviento: Penitencia y preparación */
  --liturgico-blanco: #ca8a04;       /* Fiestas, Solemnidades y Pascua: Gloria y pureza */
  --liturgico-rojo: #991b1b;         /* Mártires, Pentecostés y Pasión del Señor */
  
  /* Sistema de Sombras Suaves */
  --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08);
  --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.1), 0 2px 4px -2px rgba(15, 23, 42, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(15, 23, 42, 0.1), 0 4px 6px -4px rgba(15, 23, 42, 0.05);
  --shadow-glow: 0 0 20px rgba(217, 119, 6, 0.45); /* Fulgor de la velita virtual */
  
  /* Bordes y Radios */
  --radius-sm: 6px;
  --radius-md: 12px;
  --radius-lg: 20px;
  --radius-pill: 50px;
  
  /* Tipografías */
  --font-heading: 'Cinzel', 'Playfair Display', Georgia, serif;
  --font-body: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
}
```

---

## 3. Tipografía y Jerarquía Textual

La selección tipográfica reconcilia la tradición sacra con la legibilidad moderna en pantallas:
1. **Tipografía de Títulos (`--font-heading`):** *Cinzel* / *Playfair Display* (Google Fonts). Confiere porte clásico y solemne a los encabezados litúrgicos, lemas y nombres de capillas.
2. **Tipografía de Lectura (`--font-body`):** *Plus Jakarta Sans* / *Inter* (Google Fonts). Diseñada específicamente para pantallas digitales; ofrece excelente definición en trazos de letras minúsculas y gran comodidad de lectura para personas mayores.

| Nivel | Elemento | Tamaño / Interlineado | Peso | Uso Específico |
|---|---|---|---|---|
| **H1** | Título Principal | 2.5rem (40 px) / 1.2 | 700 (Bold) | Un solo H1 en portada: *"Parroquia María Madre de Dios — Tehuacán"* |
| **H2** | Títulos de Sección | 2.0rem (32 px) / 1.3 | 600 (SemiBold) | Títulos de secciones: Horarios, Sacramentos, Calendario, Muro |
| **H3** | Subtítulos y Módulos | 1.5rem (24 px) / 1.4 | 600 (SemiBold) | Nombres de capillas, tarjetas de sacramentos, avisos |
| **H4** | Títulos de Tarjetas | 1.25rem (20 px) / 1.4 | 600 (SemiBold) | Grupos parroquiales, tipos de intención |
| **Body** | Texto Párrafo | 1.05rem (16.8 px) / 1.6 | 400 (Regular) | Explicaciones de requisitos, descripciones, reflexiones |
| **Small** | Metadatos y Notas | 0.875rem (14 px) / 1.5 | 400 (Regular) | Leyendas orientativas `[SUPUESTO]`, fechas, pie de foto |

---

## 4. Componentes Clave de la Interfaz

### 4.1 Barra de Navegación Accesible (`Navbar`)
- **Enlace de salto (`.skip-link`):** Ubicado antes de cualquier elemento navegable; salta directamente a `#contenido-principal` con la tecla Tab.
- **Marca:** Escudo mariano estilizado en oro con el texto *"Parroquia María Madre de Dios"*.
- **Puntos de menú:** Inicio, La Parroquia, Sacramentos, Calendario, Muro de Oraciones, Grupos, Galería, Contacto.
- **Acceso Directo:** Botón de acción con borde dorado *"Ver Horarios de Hoy"*.

### 4.2 Hero Banner Inspirador
- Imagen de fondo en tonos azul zafiro con velo degradado que asegura contraste de texto superior a 10:1.
- Título solemne con cita devocional, horarios del día en vivo y dos botones de llamado a la acción destacados:
  - Primario: *"Encender una Velita Virtual"* (hacia el Muro).
  - Secundario: *"Requisitos de Sacramentos"* (hacia la guía).

### 4.3 Guía Interactiva de Sacramentos
- Componente de pestañas (`nav-pills` de Bootstrap) para Bautismo, Primera Comunión, Confirmación y Matrimonio.
- Acordeones colapsables para desglose claro:
  - Documentos del solicitante.
  - Requisitos de padrinos o testigos.
  - Pláticas pre-sacramentales.
  - Estipendio o donativo orientativo sugerido (con leyenda de apoyo voluntario `[SUPUESTO]`).
- Botón destacado accesible con icono: *"Descargar Requisitos en PDF"*.

### 4.4 Calendario Litúrgico y de Eventos Dinámico
```
┌────────────────────────────────────────────────────────────────────────┐
│  CALENDARIO PARROQUIAL Y LITÚRGICO                      [ Noviembre 2026 ▼ ] │
│  Filtrar por sede: [ Todas las Capillas / Templo Parroquial / Capilla Observatorio ▼ ] │
│  Leyenda: ● T. Ordinario (Verde)  ● Cuaresma (Morado)  ● Fiesta (Blanco)  ● Mártir (Rojo) │
├────────────┬────────────┬────────────┬────────────┬────────────┬────────────┬────────────┤
│   DOM      │   LUN      │   MAR      │   MIÉ      │   JUE      │   VIE      │   SÁB      │
├────────────┼────────────┼────────────┼────────────┼────────────┼────────────┼────────────┤
│ 1          │ 2          │ 3          │ 4          │ 5          │ 6          │ 7          │
│ ● Todos    │ ● Fieles   │            │            │            │            │ ● Confir-  │
│   Santos   │   Difuntos │            │            │            │            │   mación   │
│ 12:00 Misa │ 19:00 Misa │            │            │            │            │ 11:00 [Fijo│
└────────────┴────────────┴────────────┴────────────┴────────────┴────────────┴────────────┘
```
- **Interactividad:** Botones para avanzar y retroceder mes; selección de capillla con actualización instantánea sin recarga.
- **Doble codificación:** Los eventos no dependen únicamente del color; exhiben icono y texto explicativo del tipo de evento (Festividad, Sacramento comunitario, Fecha fija de Comunión/Confirmación).
- **Modo Móvil:** Se transforma fluidamente en una lista vertical ordenada cronológicamente con tarjetas accesibles y legibles.

### 4.5 Componente del Muro de Oraciones y Velitas Virtuales
Cada intención activa se despliega como una tarjeta devocional que incluye:
- **Cilindro de la vela:** Modelado en CSS con cera marfil (`#fef9c3`) y borde suave.
- **Mecha y Flama Animada:**
  - Animación `@keyframes flame-flicker` que simula el movimiento natural del fuego sagrado.
  - **Crecimiento dinámico de la flama:** Según el número de oraciones recibidas, la clase CSS de la flama escala en tamaño (`transform: scale(...)`), fulgor (`box-shadow`) e intensidad cromática:
    - 0 a 2 oraciones: Flama inicial suave (`flame-sm`).
    - 3 a 5 oraciones: Flama viva (`flame-md`).
    - 6 a 10 oraciones: Flama luminosa (`flame-lg`).
    - Más de 10 oraciones: Flama resplandeciente (`flame-max`), manteniendo siempre un límite para no distorsionar el contenedor.
- **Contador y botón de intercesión:** Botón táctil grande *"Yo rezo por ti"* con icono de manos unidas y contador numérico en vivo.
- **Tiempo de vigencia:** Barra sutil indicando días restantes de los 7 días de encendido.

```
       ( )  <- Flama animada con resplandor dorado interactivo
        |   <- Mecha
      ┌───┐
      │   │ <- Cuerpo de cera marfil
      │   │
      └───┘
  "Por la salud de mi abuela Rosa"
  [ 🙏 Yo rezo por ti ] (4 oraciones)
  Expira en: 5 días
```

### 4.6 Botón Flotante de WhatsApp
- Ubicado fijo en la esquina inferior derecha (`bottom: 24px; right: 24px; z-index: 1050`).
- Color verde oficial de WhatsApp (`#25d366`), círculo de 60 px con sombra destacada y pulso suave cada 8 segundos para invitar a la consulta sin resultar invasivo.
- Tooltip visible al situar el cursor: *"¿Dudas sobre trámites? Escríbenos a notaría"*.

---

## 5. Criterios de Usabilidad y Accesibilidad (WCAG 2.1 Nivel AA)

1. **Ratios de Contraste Cromático:**
   - Texto principal (`#0f172a`) sobre fondo de página (`#f8fafc`): **Ratio 14.8:1** (Supera ampliamente el 4.5:1 exigido por WCAG AA y el 7:1 de AAA).
   - Oro eclesiástico en botones (`#d97706`) con texto blanco (`#ffffff`): Ajustado a tono oscuro `#b45309` para alcanzar **Ratio 4.6:1** en botones de acción.
2. **Estados de Foco Accesible:**
   - Todo elemento interactivo (enlaces, botones, campos de texto) exhibe un anillo de foco destacado al ser navegado por teclado:  
     `outline: 3px solid #d97706; outline-offset: 3px;`
3. **Formularios Intuitivos y Claros:**
   - Todas las etiquetas `<label>` están asociadas mediante el atributo `for` con el `id` correspondiente del campo.
   - Mensajes de error y de éxito con doble refuerzo: icono y texto descriptivo, acompañados de `role="alert"` para lectores de pantalla.
4. **Respeto a Preferencias del Usuario:**
   - Soporte para `@media (prefers-reduced-motion: reduce)`: Si el usuario tiene habilitada la reducción de movimiento en su sistema operativo, la animación de parpadeo de las flamas de las velitas se atenúa a un brillo estático suave.

---

## 6. Registro de Trabajo del Agente (Fase 4)

| Campo | Detalle |
|---|---|
| **Fecha de ejecución** | 5 de octubre de 2026 |
| **Instrucción recibida** | Desarrollar la Fase 4: Interfaz (UI) y usabilidad, definiendo la paleta de colores litúrgica, tipografía, componentes visuales, diseño del calendario dinámico, comportamiento animado de las velitas virtuales y cumplimiento de accesibilidad WCAG AA. |
| **Resultado obtenido** | Documento `docs/fase4_diseno_interfaz_ui_usabilidad.md` con especificación de tokens en variables CSS, jerarquía tipográfica, esquemas de componentes y parámetros de animación de la flama de velitas. |
| **Decisión tomada 1** | Se adoptó una paleta basada en azul mariano y oro eclesiástico, reservando los 4 colores litúrgicos tradicionales (verde, morado, blanco y rojo) de manera exclusiva para el calendario y los eventos de la iglesia. |
| **Motivo** | Evitar saturación cromática en la interfaz y garantizar coherencia con la identidad de la Diócesis de Tehuacán. |
| **Alternativa descartada** | Usar colores comerciales genéricos como azul claro o verde plano; descartado por desvirtuar la identidad sacra del templo. |
| **Decisión tomada 2** | La animación de crecimiento de la flama de las velitas se modeló con clases CSS escalables y tope máximo (`flame-max`), incorporando además la consulta a `prefers-reduced-motion`. |
| **Motivo** | Asegurar impacto visual y emocional sin romper la diagramación ni afectar a usuarios con afecciones vestibulares o epilepsia fotosensible. |
| **Alternativa descartada** | Animaciones pesadas con Canvas o WebGL; descartadas por comprometer el rendimiento en teléfonos de gama baja de feligreses mayores. |

---
*Fin del documento de Fase 4. Pendiente de revisión y confirmación del equipo para dar paso a la Fase 5.*
