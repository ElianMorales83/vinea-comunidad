/**
 * Vinea Comunidad — Muro de Oraciones e Intenciones Virtuales (js/muro.js)
 * Módulo 6: RF-25, RF-26, RF-27, RF-28, RF-31
 */

class MuroOraciones {
    constructor() {
        this.velitas = [];
        this.authorToken = this.obtenerOGenerarAuthorToken();
        this.oracionesLocales = this.obtenerOracionesLocales();
        this.pollingInterval = null;

        this.init();
    }

    init() {
        this.vincularFormulario();
        this.cargarVelitas();
        this.iniciarPolling();
    }

    obtenerOGenerarAuthorToken() {
        let token = localStorage.getItem('vinea_author_token');
        if (!token) {
            token = 'autor_' + Math.random().toString(36).substring(2) + Date.now().toString(36);
            localStorage.setItem('vinea_author_token', token);
        }
        return token;
    }

    obtenerOracionesLocales() {
        try {
            return JSON.parse(localStorage.getItem('vinea_oraciones_realizadas') || '{}');
        } catch (e) {
            return {};
        }
    }

    guardarOracionLocal(intencionId) {
        this.oracionesLocales[intencionId] = Date.now();
        localStorage.setItem('vinea_oraciones_realizadas', JSON.stringify(this.oracionesLocales));
    }

    yaOroHoy(intencionId) {
        const ultimaVez = this.oracionesLocales[intencionId];
        if (!ultimaVez) return false;
        const unDiaEnMs = 24 * 60 * 60 * 1000;
        return (Date.now() - ultimaVez) < unDiaEnMs;
    }

    iniciarPolling() {
        // Consulta periódica cada 35 segundos para refrescar oraciones sin recargar la página (RF-28)
        this.pollingInterval = setInterval(() => {
            this.cargarVelitas(true);
        }, 35000);
    }

    async cargarVelitas(esPolling = false) {
        const contenedor = document.getElementById('muro-velitas-container');
        if (!contenedor) return;

        if (!esPolling && contenedor.children.length === 0) {
            contenedor.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Cargando velitas del altar...</span>
                    </div>
                    <p class="text-muted mt-2">Cargando las velitas encendidas en el altar...</p>
                </div>
            `;
        }

        try {
            const res = await fetch(`api/intenciones.php?author_token=${this.authorToken}`);
            const json = await res.json();
            if (json.status === 'success' && Array.isArray(json.data)) {
                this.velitas = json.data;
            } else {
                this.usarVelitasLocales();
            }
        } catch (err) {
            this.usarVelitasLocales();
        }

        this.renderizarVelitas();
    }

    usarVelitasLocales() {
        // Datos en caso de ejecución puramente offline/local
        if (this.velitas.length === 0) {
            this.velitas = [
                {
                    id: 101,
                    autor_nombre: 'Familia Gómez Méndez [SUPUESTO]',
                    es_anonimo: 0,
                    categoria: 'Salud',
                    peticion: 'Pedimos la intercesión de la Virgen María por la salud de nuestra abuela Rosa que se encuentra hospitalizada.',
                    oraciones_recibidas: 8,
                    dias_restantes: 5,
                    mencionada_en_misa: 1,
                    mencionada_nota: 'Misa dominical 12:00 PM'
                },
                {
                    id: 102,
                    autor_nombre: 'Anónimo',
                    es_anonimo: 1,
                    categoria: 'Trabajo',
                    peticion: 'Por la providencia divina para conseguir empleo y llevar sustento digno a mi familia.',
                    oraciones_recibidas: 14,
                    dias_restantes: 6,
                    mencionada_en_misa: 0,
                    mencionada_nota: null
                },
                {
                    id: 103,
                    autor_nombre: 'Marta Elena [SUPUESTO]',
                    es_anonimo: 0,
                    categoria: 'Difuntos',
                    peticion: 'Por el descanso eterno de Don Roberto en su tercer mes de partida a la presencia del Padre.',
                    oraciones_recibidas: 5,
                    dias_restantes: 4,
                    mencionada_en_misa: 1,
                    mencionada_nota: 'Capilla del Observatorio'
                },
                {
                    id: 104,
                    autor_nombre: 'Anónimo',
                    es_anonimo: 1,
                    categoria: 'Familia',
                    peticion: 'Por la reconciliación y paz en nuestro hogar en este momento de prueba.',
                    oraciones_recibidas: 19,
                    dias_restantes: 7,
                    mencionada_en_misa: 0,
                    mencionada_nota: null
                }
            ];
        }
    }

    renderizarVelitas() {
        const contenedor = document.getElementById('muro-velitas-container');
        if (!contenedor) return;

        if (this.velitas.length === 0) {
            contenedor.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-fire fs-1 text-warning d-block mb-2"></i>
                    <h3 class="h5 fw-bold text-dark">Aún no hay velitas encendidas</h3>
                    <p class="text-muted">Sé el primero en encender una velita por una necesidad o acción de gracias.</p>
                </div>
            `;
            return;
        }

        let html = '';
        this.velitas.forEach(v => {
            // Escala de la flama según número de oraciones recibidas (RF-27)
            const oraciones = parseInt(v.oraciones_recibidas, 10) || 0;
            let claseFlama = 'flame-sm';
            if (oraciones >= 12) {
                claseFlama = 'flame-max';
            } else if (oraciones >= 7) {
                claseFlama = 'flame-lg';
            } else if (oraciones >= 3) {
                claseFlama = 'flame-md';
            }

            const yaOro = this.yaOroHoy(v.id);
            const autorLabel = v.es_anonimo ? 'Anónimo (Feligrés)' : escapeHtml(v.autor_nombre);
            const diasTexto = v.dias_restantes !== undefined ? `${v.dias_restantes} días de vigencia` : 'Vela activa (7 días)';

            let badgeMencionada = '';
            if (v.mencionada_en_misa) {
                badgeMencionada = `
                    <div class="badge bg-success-subtle text-success border border-success-subtle mb-2 small w-100 text-start py-1">
                        <i class="bi bi-check2-circle me-1"></i> Mencionada en la Santa Misa
                    </div>
                `;
            }

            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="candle-card p-3 h-100 shadow-sm" id="candle-card-${v.id}">
                        <!-- Representación Visual de la Velita Virtual -->
                        <div class="candle-wrapper">
                            <div class="flame ${claseFlama}" id="flame-${v.id}"></div>
                            <div class="candle-wick"></div>
                            <div class="candle-body"></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-warning-subtle text-warning-emphasis fw-semibold">
                                ${escapeHtml(v.categoria)}
                            </span>
                            <span class="text-muted small">
                                <i class="bi bi-clock me-1"></i> ${diasTexto}
                            </span>
                        </div>

                        <h4 class="h6 fw-bold text-dark mb-1">${autorLabel}</h4>

                        <p class="card-text text-muted small flex-grow-1 mb-3">
                            "${escapeHtml(v.peticion)}"
                        </p>

                        ${badgeMencionada}

                        <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-semibold" id="counter-${v.id}">
                                <i class="bi bi-fire text-warning me-1"></i> 
                                <span class="num-oraciones">${oraciones}</span> ${oraciones === 1 ? 'oración' : 'oraciones'}
                            </span>

                            <button type="button" 
                                    class="btn ${yaOro ? 'btn-outline-secondary' : 'btn-outline-warning text-dark'} btn-sm fw-semibold btn-rezar" 
                                    data-id="${v.id}" 
                                    ${yaOro ? 'disabled' : ''}
                                    title="${yaOro ? 'Ya te uniste en oración hoy' : 'Unirte en oración por este hermano'}">
                                <i class="bi bi-heart-fill text-danger me-1"></i> 
                                ${yaOro ? 'Oración unida' : 'Yo rezo por ti'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        contenedor.innerHTML = html;
        this.vincularBotonesRezar();
    }

    vincularBotonesRezar() {
        const botones = document.querySelectorAll('.btn-rezar');
        botones.forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const id = btn.getAttribute('data-id');
                await this.orarPorIntencion(id, btn);
            });
        });
    }

    async orarPorIntencion(intencionId, boton) {
        if (this.yaOroHoy(intencionId)) {
            mostrarNotificacion('Ya has ofrecido tu oración por esta velita hoy. ¡Muchas gracias!', 'info');
            return;
        }

        boton.disabled = true;
        boton.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Rezando...`;

        try {
            const res = await fetch('api/intenciones.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    accion: 'rezar',
                    intencion_id: intencionId,
                    visitor_token: this.authorToken
                })
            });
            const json = await res.json();

            if (json.status === 'success') {
                this.guardarOracionLocal(intencionId);
                const nuevoTotal = json.data?.oraciones_recibidas || (this.obtenerTotalActual(intencionId) + 1);
                this.actualizarCardVelita(intencionId, nuevoTotal);
                mostrarNotificacion('¡Gracias por rezar! La flama ha brillado con más fuerza por tu hermano.', 'success');
            } else {
                mostrarNotificacion(json.message || 'No se pudo registrar la oración.', 'warning');
            }
        } catch (err) {
            // Modo local
            this.guardarOracionLocal(intencionId);
            const nuevoTotal = this.obtenerTotalActual(intencionId) + 1;
            this.actualizarCardVelita(intencionId, nuevoTotal);
            mostrarNotificacion('¡Gracias por orar! Tu oración avivó la flama de esta velita.', 'success');
        } finally {
            boton.innerHTML = `<i class="bi bi-check2 me-1"></i> Oración unida`;
            boton.className = 'btn btn-outline-secondary btn-sm fw-semibold';
        }
    }

    obtenerTotalActual(id) {
        const item = this.velitas.find(v => String(v.id) === String(id));
        return item ? parseInt(item.oraciones_recibidas, 10) : 0;
    }

    actualizarCardVelita(id, nuevoTotal) {
        const item = this.velitas.find(v => String(v.id) === String(id));
        if (item) {
            item.oraciones_recibidas = nuevoTotal;
        }

        const counterElem = document.querySelector(`#counter-${id} .num-oraciones`);
        if (counterElem) {
            counterElem.textContent = nuevoTotal;
        }

        // Crecimiento interactivo de la flama (RF-27)
        const flamaElem = document.getElementById(`flame-${id}`);
        if (flamaElem) {
            flamaElem.className = 'flame';
            if (nuevoTotal >= 12) {
                flamaElem.classList.add('flame-max');
            } else if (nuevoTotal >= 7) {
                flamaElem.classList.add('flame-lg');
            } else if (nuevoTotal >= 3) {
                flamaElem.classList.add('flame-md');
            } else {
                flamaElem.classList.add('flame-sm');
            }
        }
    }

    vincularFormulario() {
        const form = document.getElementById('form-nueva-velita');
        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const btnSubmit = form.querySelector('button[type="submit"]');
            const originalText = btnSubmit.innerHTML;
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Encendiendo velita...`;

            const esAnonimo = document.getElementById('velita-anonimo')?.checked || false;
            const autorNombre = document.getElementById('velita-nombre')?.value.trim() || 'Feligrés';
            const categoria = document.getElementById('velita-categoria')?.value || 'Salud';
            const peticion = document.getElementById('velita-peticion')?.value.trim() || '';
            const email = document.getElementById('velita-email')?.value.trim() || '';
            const whatsapp = document.getElementById('velita-whatsapp')?.value.trim() || '';

            if (peticion.length < 5) {
                mostrarNotificacion('Por favor redacta tu petición con al menos 5 caracteres.', 'danger');
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalText;
                return;
            }

            const payload = {
                accion: 'publicar',
                autor_nombre: esAnonimo ? 'Anónimo' : autorNombre,
                es_anonimo: esAnonimo ? 1 : 0,
                categoria: categoria,
                peticion: peticion,
                email_contacto: email,
                whatsapp_contacto: whatsapp,
                author_token: this.authorToken
            };

            try {
                const res = await fetch('api/intenciones.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const json = await res.json();

                if (json.status === 'success') {
                    mostrarNotificacion('¡Tu velita ha sido encendida en el altar comunitario por 7 días!', 'success');
                    form.reset();
                    // Cerrar modal de Bootstrap
                    const modalElem = document.getElementById('modalEncenderVelita');
                    if (modalElem) {
                        const modalBs = bootstrap.Modal.getInstance(modalElem);
                        if (modalBs) modalBs.hide();
                    }
                    this.cargarVelitas();
                } else {
                    mostrarNotificacion(json.message || 'Error al encender velita.', 'danger');
                }
            } catch (err) {
                // Modo local
                mostrarNotificacion('¡Tu velita ha sido encendida simbólicamente por 7 días en el altar!', 'success');
                form.reset();
                const modalElem = document.getElementById('modalEncenderVelita');
                if (modalElem) {
                    const modalBs = bootstrap.Modal.getInstance(modalElem);
                    if (modalBs) modalBs.hide();
                }
                this.cargarVelitas();
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalText;
            }
        });
    }
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

document.addEventListener('DOMContentLoaded', () => {
    window.muroOraciones = new MuroOraciones();
});
