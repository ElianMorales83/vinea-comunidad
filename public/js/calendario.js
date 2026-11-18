/**
 * Vinea Comunidad — Motor del Calendario Litúrgico y Eventos (js/calendario.js)
 * Módulo 4: RF-16, RF-17
 */

class CalendarioParroquial {
    constructor() {
        this.fechaActual = new Date();
        this.mesActual = this.fechaActual.getMonth() + 1; // 1 - 12
        this.anioActual = this.fechaActual.getFullYear();
        this.capillaFiltro = 'todas';

        this.eventosCache = [];
        this.liturgicoCache = [];

        this.nombresMeses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        this.init();
    }

    init() {
        this.vincularControles();
        this.cargarDatosYRenderizar();
    }

    vincularControles() {
        const btnPrev = document.getElementById('cal-btn-prev');
        const btnNext = document.getElementById('cal-btn-next');
        const btnHoy = document.getElementById('cal-btn-hoy');
        const selectCapilla = document.getElementById('cal-filtro-capilla');

        if (btnPrev) {
            btnPrev.addEventListener('click', () => {
                this.mesActual--;
                if (this.mesActual < 1) {
                    this.mesActual = 12;
                    this.anioActual--;
                }
                this.cargarDatosYRenderizar();
            });
        }

        if (btnNext) {
            btnNext.addEventListener('click', () => {
                this.mesActual++;
                if (this.mesActual > 12) {
                    this.mesActual = 1;
                    this.anioActual++;
                }
                this.cargarDatosYRenderizar();
            });
        }

        if (btnHoy) {
            btnHoy.addEventListener('click', () => {
                const hoy = new Date();
                this.mesActual = hoy.getMonth() + 1;
                this.anioActual = hoy.getFullYear();
                this.cargarDatosYRenderizar();
            });
        }

        if (selectCapilla) {
            selectCapilla.addEventListener('change', (e) => {
                this.capillaFiltro = e.target.value;
                this.cargarDatosYRenderizar();
            });
        }
    }

    async cargarDatosYRenderizar() {
        this.actualizarEncabezado();
        
        try {
            const url = `api/eventos.php?mes=${this.mesActual}&anio=${this.anioActual}&capilla_id=${this.capillaFiltro}`;
            const res = await fetch(url);
            const json = await res.json();

            if (json.status === 'success' && json.data) {
                this.eventosCache = json.data.eventos || [];
                this.liturgicoCache = json.data.liturgico || [];
            } else {
                this.usarEventosLocales();
            }
        } catch (err) {
            this.usarEventosLocales();
        }

        this.renderizarGrilla();
        this.renderizarListaMovil();
    }

    usarEventosLocales() {
        // Datos de respaldo si se ejecuta sin backend PHP activo
        const mesPad = String(this.mesActual).padStart(2, '0');
        this.eventosCache = [
            {
                id: 1,
                capilla_id: 1,
                capilla_nombre: 'Templo Parroquial',
                titulo: 'Celebración Comunitaria de Confirmación',
                tipo_evento: 'fecha_fija_sacramento',
                fecha_inicio: `${this.anioActual}-${mesPad}-15`,
                hora_inicio: '11:00:00',
                descripcion: 'Fecha oficial comunitaria de Confirmación con el Vicario. [SUPUESTO]',
                es_fecha_fija: 1
            },
            {
                id: 2,
                capilla_id: 1,
                capilla_nombre: 'Templo Parroquial',
                titulo: 'Celebración Comunitaria de Primera Comunión',
                tipo_evento: 'fecha_fija_sacramento',
                fecha_inicio: `${this.anioActual}-${mesPad}-22`,
                hora_inicio: '10:00:00',
                descripcion: 'Fecha oficial comunitaria de Primera Comunión. [SUPUESTO]',
                es_fecha_fija: 1
            },
            {
                id: 3,
                capilla_id: 2,
                capilla_nombre: 'Capilla del Observatorio',
                titulo: 'Celebración de Bautismo',
                tipo_evento: 'sacramento_comunitario',
                fecha_inicio: `${this.anioActual}-${mesPad}-10`,
                hora_inicio: '12:00:00',
                descripcion: '',
                es_fecha_fija: 0
            },
            {
                id: 4,
                capilla_id: 2,
                capilla_nombre: 'Capilla del Observatorio',
                titulo: 'Fiesta Patronal y Peregrinación (Sectores 14 y 15)',
                tipo_evento: 'festividad_peregrinacion',
                fecha_inicio: `${this.anioActual}-${mesPad}-24`,
                hora_inicio: '17:00:00',
                descripcion: 'Peregrinación festiva por las calles de los sectores 14 y 15. [SUPUESTO]',
                es_fecha_fija: 0
            }
        ];

        if (this.capillaFiltro !== 'todas') {
            this.eventosCache = this.eventosCache.filter(e => String(e.capilla_id) === String(this.capillaFiltro));
        }

        this.liturgicoCache = [
            { fecha: `${this.anioActual}-${mesPad}-04`, tiempo_liturgico: 'T. Ordinario', color_liturgico: 'verde', santoral_celebracion: 'San Francisco de Asís', grado_celebracion: 'Memoria Libre' },
            { fecha: `${this.anioActual}-${mesPad}-07`, tiempo_liturgico: 'T. Ordinario', color_liturgico: 'blanco', santoral_celebracion: 'Ntra. Sra. del Rosario', grado_celebracion: 'Memoria Obligatoria' },
            { fecha: `${this.anioActual}-${mesPad}-11`, tiempo_liturgico: 'T. Ordinario', color_liturgico: 'verde', santoral_celebracion: 'Domingo Ordinario', grado_celebracion: 'Solemnidad' },
            { fecha: `${this.anioActual}-${mesPad}-18`, tiempo_liturgico: 'T. Ordinario', color_liturgico: 'verde', santoral_celebracion: 'San Lucas Evangelista', grado_celebracion: 'Fiesta' },
            { fecha: `${this.anioActual}-${mesPad}-28`, tiempo_liturgico: 'T. Ordinario', color_liturgico: 'rojo', santoral_celebracion: 'Santos Simón y Judas', grado_celebracion: 'Fiesta' }
        ];
    }

    actualizarEncabezado() {
        const tituloElem = document.getElementById('cal-titulo-mes');
        if (tituloElem) {
            tituloElem.textContent = `${this.nombresMeses[this.mesActual - 1]} ${this.anioActual}`;
        }
    }

    renderizarGrilla() {
        const gridElem = document.getElementById('cal-grid-dias');
        if (!gridElem) return;

        gridElem.innerHTML = '';

        const primerDiaSemana = new Date(this.anioActual, this.mesActual - 1, 1).getDay(); // 0 = Domingo
        const totalDiasMes = new Date(this.anioActual, this.mesActual, 0).getDate();
        const diasMesAnterior = new Date(this.anioActual, this.mesActual - 1, 0).getDate();

        const hoy = new Date();
        const esMismoMesActual = (hoy.getMonth() + 1 === this.mesActual && hoy.getFullYear() === this.anioActual);

        // 1. Días del mes anterior (relleno)
        for (let i = primerDiaSemana - 1; i >= 0; i--) {
            const numDia = diasMesAnterior - i;
            const celda = document.createElement('div');
            celda.className = 'calendar-cell other-month';
            celda.innerHTML = `<div class="calendar-day-num text-muted">${numDia}</div>`;
            gridElem.appendChild(celda);
        }

        // 2. Días del mes actual
        for (let dia = 1; dia <= totalDiasMes; dia++) {
            const celda = document.createElement('div');
            const fechaStr = `${this.anioActual}-${String(this.mesActual).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
            const esHoy = esMismoMesActual && (hoy.getDate() === dia);

            celda.className = `calendar-cell ${esHoy ? 'today' : ''}`;
            
            // Buscar datos litúrgicos de este día
            const liturgico = this.liturgicoCache.find(l => l.fecha === fechaStr);
            let badgeLiturgico = '';
            let santoralHtml = '';
            if (liturgico) {
                const color = liturgico.color_liturgico || 'verde';
                badgeLiturgico = `<span class="badge-liturgico ${color}" title="${liturgico.tiempo_liturgico} · ${liturgico.santoral_celebracion}"></span>`;
                santoralHtml = `<div class="text-truncate text-muted" style="font-size: 0.65rem;" title="${liturgico.santoral_celebracion}">${liturgico.santoral_celebracion}</div>`;
            }

            // Buscar eventos en este día
            const eventosDia = this.eventosCache.filter(e => e.fecha_inicio === fechaStr);
            let eventosHtml = '';

            eventosDia.forEach(ev => {
                let clasePill = 'festividad';
                let labelExtra = '';

                if (ev.tipo_evento === 'fecha_fija_sacramento' || ev.es_fecha_fija) {
                    clasePill = 'fijo';
                    labelExtra = '📌 [Fijo] ';
                } else if (ev.tipo_evento === 'sacramento_comunitario') {
                    clasePill = 'comunitario';
                }

                // En sacramentos comunitarios, solo mostrar tipo y hora (sin datos personales - Sección 7.1)
                const horaCorta = ev.hora_inicio ? ev.hora_inicio.substring(0, 5) : '';
                const textoPill = `${labelExtra}${horaCorta} ${ev.titulo}`;

                eventosHtml += `
                    <div class="event-pill ${clasePill}" 
                         title="${ev.titulo} (${ev.capilla_nombre || ''}) - ${ev.descripcion || 'Sin descripción'}"
                         tabindex="0" role="button" aria-label="${ev.titulo} a las ${horaCorta}">
                        ${textoPill}
                    </div>
                `;
            });

            celda.innerHTML = `
                <div class="calendar-day-num">
                    <span>${dia}</span>
                    <span>${badgeLiturgico}</span>
                </div>
                ${santoralHtml}
                <div class="events-list mt-1">
                    ${eventosHtml}
                </div>
            `;
            gridElem.appendChild(celda);
        }
    }

    renderizarListaMovil() {
        const listElem = document.getElementById('cal-mobile-list');
        if (!listElem) return;

        if (this.eventosCache.length === 0) {
            listElem.innerHTML = `
                <div class="alert alert-light text-center py-4 text-muted">
                    <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                    No hay eventos registrados para este mes en la sede seleccionada.
                </div>
            `;
            return;
        }

        // Ordenar eventos cronológicamente
        const eventosOrdenados = [...this.eventosCache].sort((a, b) => a.fecha_inicio.localeCompare(b.fecha_inicio));

        let html = '';
        eventosOrdenados.forEach(ev => {
            const fechaPartes = ev.fecha_inicio.split('-');
            const diaNum = fechaPartes[2];
            const horaCorta = ev.hora_inicio ? ev.hora_inicio.substring(0, 5) : '';

            let badgeTipo = `<span class="badge bg-success">Festividad</span>`;
            if (ev.tipo_evento === 'fecha_fija_sacramento' || ev.es_fecha_fija) {
                badgeTipo = `<span class="badge bg-primary">📌 Fecha Fija Oficial</span>`;
            } else if (ev.tipo_evento === 'sacramento_comunitario') {
                badgeTipo = `<span class="badge bg-warning text-dark">Sacramento Comunitario</span>`;
            }

            html += `
                <div class="card mb-2 shadow-sm border-0 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-primary">${diaNum} de ${this.nombresMeses[parseInt(fechaPartes[1], 10) - 1]} · ${horaCorta} hrs</span>
                        ${badgeTipo}
                    </div>
                    <h4 class="h6 fw-bold mb-1 text-dark">${ev.titulo}</h4>
                    <div class="small text-muted mb-1"><i class="bi bi-geo-alt me-1"></i> ${ev.capilla_nombre || 'Parroquia María Madre de Dios'}</div>
                    ${ev.descripcion ? `<p class="small text-muted mb-0">${ev.descripcion}</p>` : ''}
                </div>
            `;
        });

        listElem.innerHTML = html;
    }
}

// Inicializar el calendario cuando cargue el DOM
document.addEventListener('DOMContentLoaded', () => {
    window.calendarioParroquial = new CalendarioParroquial();
});
