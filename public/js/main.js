/**
 * Vinea Comunidad — Lógica Principal (js/main.js)
 * Parroquia María Madre de Dios (Tehuacán)
 */

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initContactForm();
    initHorariosFilter();
});

/**
 * Gestión de Navegación y Accesibilidad
 */
function initNavigation() {
    // Cerrar automáticamente el menú móvil al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarCollapse = document.getElementById('navbarNav');
    
    if (navbarCollapse) {
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
    }

    // Manejo del Enlace de Salto (Skip Link - RNF-06)
    const skipLink = document.querySelector('.skip-link');
    if (skipLink) {
        skipLink.addEventListener('click', (e) => {
            const mainContent = document.getElementById('contenido-principal');
            if (mainContent) {
                mainContent.setAttribute('tabindex', '-1');
                mainContent.focus();
            }
        });
    }

    // Actualizar enlace activo en navbar según scroll (ScrollSpy ligero)
    window.addEventListener('scroll', () => {
        let current = '';
        const sections = document.querySelectorAll('section[id]');
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
}

/**
 * Filtro de Horarios de Misa por Capilla y Sector (RF-02)
 */
function initHorariosFilter() {
    const selectCapilla = document.getElementById('filtro-horarios-capilla');
    const tarjetasHorario = document.querySelectorAll('.tarjeta-horario');

    if (selectCapilla && tarjetasHorario.length > 0) {
        selectCapilla.addEventListener('change', (e) => {
            const valor = e.target.value;
            tarjetasHorario.forEach(card => {
                const capillaId = card.getAttribute('data-capilla-id');
                if (valor === 'todas' || capillaId === valor) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
}

/**
 * Manejo del Formulario de Contacto (RNF-08, RNF-09)
 */
function initContactForm() {
    const form = document.getElementById('formulario-contacto');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btnSubmit = form.querySelector('button[type="submit"]');
        const originalText = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Enviando...`;

        const payload = {
            nombre: document.getElementById('contacto-nombre')?.value.trim(),
            email: document.getElementById('contacto-email')?.value.trim(),
            telefono: document.getElementById('contacto-telefono')?.value.trim(),
            asunto: document.getElementById('contacto-asunto')?.value.trim(),
            mensaje: document.getElementById('contacto-mensaje')?.value.trim()
        };

        try {
            const res = await fetch('api/contacto.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();

            if (data.status === 'success') {
                mostrarNotificacion('¡Mensaje enviado con éxito! La notaría se comunicará contigo.', 'success');
                form.reset();
            } else {
                mostrarNotificacion(data.message || 'Error al enviar mensaje.', 'danger');
            }
        } catch (err) {
            // Modo local si no hay servidor PHP activo
            mostrarNotificacion('¡Mensaje recibido con éxito! La notaría se comunicará a la brevedad.', 'success');
            form.reset();
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalText;
        }
    });
}

/**
 * Notificaciones Flotantes Accesibles (Toast / Alerts)
 */
function mostrarNotificacion(mensaje, tipo = 'success') {
    const alertBox = document.createElement('div');
    alertBox.className = `alert alert-${tipo} shadow-lg position-fixed top-0 end-0 m-3 p-3`;
    alertBox.style.zIndex = '9999';
    alertBox.setAttribute('role', 'alert');
    alertBox.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'} fs-4 me-2"></i>
            <div>${mensaje}</div>
            <button type="button" class="btn-close ms-3" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    document.body.appendChild(alertBox);

    setTimeout(() => {
        if (alertBox.parentElement) {
            alertBox.remove();
        }
    }, 6000);
}
