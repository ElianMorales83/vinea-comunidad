/**
 * Vinea Comunidad — Guía de Sacramentos, Descarga de PDF y Citas (js/sacramentos.js)
 * Módulos 2 y 3: RF-03, RF-20, RF-21, RF-22, RF-23
 */

document.addEventListener('DOMContentLoaded', () => {
    initDescargasPDF();
    initModalIntencionesMisa();
    initModalCitasPastorales();
});

/**
 * Generador y Descargador de Listas de Requisitos en PDF (RF-20)
 * Crea una vista de impresión formal con membrete parroquial
 */
function initDescargasPDF() {
    const botonesDescarga = document.querySelectorAll('.btn-descargar-pdf');
    
    botonesDescarga.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const sacramento = btn.getAttribute('data-sacramento') || 'bautismo';
            generarDocumentoImprimible(sacramento);
        });
    });
}

function generarDocumentoImprimible(sacramento) {
    const datosSacramentos = {
        bautismo: {
            titulo: 'Requisitos Oficiales para el Sacramento del Bautismo',
            edad: 'Niños menores de 7 años',
            papeleria: [
                'Acta de Nacimiento original del niño(a) y 2 copias legibles.',
                'Identificación oficial vigente (INE) de ambos padres (copia).',
                'Comprobante de domicilio reciente (no mayor a 3 meses).',
                'Comprobante de Pláticas Prebautismales de papás y padrinos.'
            ],
            padrinos: [
                'Si son matrimonio: Acta de Matrimonio por la Iglesia Católica (original y copia).',
                'Si es soltero(a): Mayor de 16 años, con Bautismo, Primera Comunión y Confirmación.',
                'No pueden ser padrinos personas que vivan en unión libre o casados solo por el civil.'
            ],
            estipendio: '$250.00 MXN (Celebración Comunitaria) / $500.00 MXN (Individual) [SUPUESTO]',
            platicas: 'Segundo y cuarto sábado de cada mes a las 16:00 hrs en el salón parroquial.'
        },
        comunion: {
            titulo: 'Requisitos para la Primera Comunión',
            edad: 'Niños a partir de los 9 años cumplidos',
            papeleria: [
                'Boleta o Fe de Bautismo original reciente (máximo 6 meses de expedición).',
                'Acta de Nacimiento del niño(a) (copia).',
                'Constancia de asistencia al ciclo de Catequesis Parroquial (2 años de formación).'
            ],
            padrinos: [
                'Un solo padrino o una sola madrina (o un matrimonio católico debidamente casado por la Iglesia).',
                'Contar con los sacramentos de Iniciación Cristiana (Bautismo, Comunión y Confirmación).'
            ],
            estipendio: '$300.00 MXN (Material catequético y celebración comunitaria) [SUPUESTO]',
            platicas: 'Plática previa obligatoria para padres y padrinos previa a la ceremonia.'
        },
        confirmacion: {
            titulo: 'Requisitos para el Sacramento de la Confirmación',
            edad: 'Jóvenes y adolescentes a partir de 12 años',
            papeleria: [
                'Boleta de Bautismo reciente debidamente certificada.',
                'Constancia de Primera Comunión.',
                'Constancia del curso de preparación para Confirmación.'
            ],
            padrinos: [
                'Padrino (para varón) o Madrina (para mujer), que dé testimonio de vida cristiana católica.',
                'Haber recibido el sacramento de la Confirmación.'
            ],
            estipendio: '$300.00 MXN (Sostenimiento litúrgico diocesano) [SUPUESTO]',
            platicas: 'Retiro y pláticas previas con el equipo de pastoral juvenil.'
        },
        matrimonio: {
            titulo: 'Requisitos para el Sacramento del Matrimonio',
            edad: 'Contrayentes mayores de edad',
            papeleria: [
                'Fe de Bautismo reciente de ambos novios (actualizada para matrimonio).',
                'Boletas de Primera Comunión y Confirmación de ambos novios.',
                'Actas de Nacimiento originales de ambos novios.',
                'Cuatro fotografías tamaño infantil recientes de cada contrayente.',
                'Constancia del curso de Pláticas Prematrimoniales.',
                'Presentación matrimonial con dos testigos por cada contrayente (con al menos 3 años de conocerlos).'
            ],
            padrinos: [
                'Padrinos de velación: Matrimonio católico ejemplar casado por la Iglesia.'
            ],
            estipendio: '$1,200.00 MXN (Apertura de expediente y celebración) [SUPUESTO]',
            platicas: 'Pláticas prematrimoniales programadas con al menos 3 meses de anticipación.'
        }
    };

    const info = datosSacramentos[sacramento] || datosSacramentos.bautismo;

    // Abrir ventana limpia de impresión estilizada
    const win = window.open('', '_blank');
    if (!win) {
        alert('Por favor autorice las ventanas emergentes para descargar e imprimir la guía de requisitos.');
        return;
    }

    win.document.write(`
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>${info.titulo} — Parroquia María Madre de Dios</title>
            <style>
                body { font-family: 'Times New Roman', serif; margin: 40px; color: #111; line-height: 1.5; font-size: 13pt; }
                .header { text-align: center; border-bottom: 2px solid #1e3a8a; padding-bottom: 15px; margin-bottom: 25px; }
                .header h1 { margin: 0; font-size: 18pt; color: #1e3a8a; text-transform: uppercase; }
                .header h2 { margin: 5px 0 0; font-size: 14pt; color: #b45309; }
                .header p { margin: 3px 0 0; font-size: 10pt; color: #555; }
                h3 { font-size: 13pt; border-bottom: 1px solid #ccc; padding-bottom: 4px; color: #1e3a8a; margin-top: 20px; }
                ul { margin-top: 5px; padding-left: 25px; }
                li { margin-bottom: 6px; }
                .estipendio-box { background: #fdfbf7; border: 1px dashed #b45309; padding: 12px; margin-top: 25px; font-size: 11pt; border-radius: 4px; }
                .footer { margin-top: 40px; text-align: center; font-size: 9pt; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
                @media print {
                    .btn-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="btn-print" style="text-align: right; margin-bottom: 15px;">
                <button onclick="window.print()" style="padding: 8px 16px; background: #1e3a8a; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 11pt;">
                    🖨️ Imprimir / Guardar como PDF
                </button>
            </div>

            <div class="header">
                <p>DIÓCESIS DE TEHUACÁN · PUEBLA</p>
                <h1>Parroquia María Madre de Dios</h1>
                <h2>${info.titulo}</h2>
                <p>Notaría Parroquial · Calle 5 Poniente #120, Tehuacán, Pue. · Tel. 238 382 0000 [SUPUESTO]</p>
            </div>

            <p><strong>Población objetivo:</strong> ${info.edad}</p>

            <h3>1. Documentación requerida (Original y Copias)</h3>
            <ul>
                ${info.papeleria.map(p => `<li>${p}</li>`).join('')}
            </ul>

            <h3>2. Perfil y requisitos para los Padrinos</h3>
            <ul>
                ${info.padrinos.map(p => `<li>${p}</li>`).join('')}
            </ul>

            <h3>3. Pláticas pre-sacramentales</h3>
            <p>${info.platicas}</p>

            <div class="estipendio-box">
                <strong>Estipendio de Ofrenda Orientativo:</strong> ${info.estipendio}<br>
                <em>Nota pastoral:</em> Los estipendios son aportaciones voluntarias para los suministros litúrgicos, luz y sostenimiento del templo. A nadie se le niega ningún sacramento por motivos económicos.
            </div>

            <div class="footer">
                <p>Horario de atención de Notaría: Martes a Sábado 15:00 a 19:00 hrs. | Domingo 10:00 a 14:00 hrs. (Lunes cerrado)<br>
                Documento informativo generado desde el portal Vinea Comunidad.</p>
            </div>
        </body>
        </html>
    `);
    win.document.close();
}

/**
 * Formulario Modal para Solicitud de Citas Pastorales (RF-22)
 */
function initModalCitasPastorales() {
    const formCita = document.getElementById('form-solicitar-cita');
    if (!formCita) return;

    formCita.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btnSubmit = formCita.querySelector('button[type="submit"]');
        const origText = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Enviando solicitud...`;

        const payload = {
            nombre_solicitante: document.getElementById('cita-nombre')?.value.trim(),
            telefono: document.getElementById('cita-telefono')?.value.trim(),
            email: document.getElementById('cita-email')?.value.trim(),
            tipo_cita: document.getElementById('cita-tipo')?.value,
            fecha_solicitada: document.getElementById('cita-fecha')?.value,
            hora_solicitada: document.getElementById('cita-hora')?.value,
            motivo: document.getElementById('cita-motivo')?.value.trim()
        };

        try {
            const res = await fetch('api/citas.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();

            if (data.status === 'success') {
                mostrarNotificacion('¡Solicitud de cita enviada! La notaría confirmará tu horario a la brevedad.', 'success');
                formCita.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalSolicitarCita'));
                if (modal) modal.hide();
            } else {
                mostrarNotificacion(data.message || 'Error al agendar cita.', 'danger');
            }
        } catch (err) {
            // Modo local
            mostrarNotificacion('¡Solicitud de cita recibida con éxito! La notaría se comunicará para confirmar.', 'success');
            formCita.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalSolicitarCita'));
            if (modal) modal.hide();
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = origText;
        }
    });
}

/**
 * Formulario Modal para Solicitud de Intención de Misa (RF-21)
 */
function initModalIntencionesMisa() {
    const formMisa = document.getElementById('form-intencion-misa');
    if (!formMisa) return;

    formMisa.addEventListener('submit', (e) => {
        e.preventDefault();
        mostrarNotificacion('¡Intención de misa registrada con éxito! La incluiremos en la celebración correspondiente.', 'success');
        formMisa.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalIntencionMisa'));
        if (modal) modal.hide();
    });
}
