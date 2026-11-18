<!-- ==========================================================================
     MODALES BOOTSTRAP (FORMULARIOS ACCESIBLES) - VINEA COMUNIDAD
     ========================================================================== -->

<!-- Modal 1: Encender Velita Virtual (RF-25) -->
<div class="modal fade" id="modalEncenderVelita" tabindex="-1" aria-labelledby="modalEncenderVelitaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-bottom border-warning border-3">
                <h5 class="modal-title fw-bold" id="modalEncenderVelitaTitle" style="font-family: var(--font-heading);">
                    <i class="bi bi-fire text-warning me-2" aria-hidden="true"></i> Encender una Velita Virtual
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form-nueva-velita">
                <div class="modal-body p-4">
                    <div class="alert alert-warning py-2 small mb-3">
                        <i class="bi bi-shield-exclamation me-1" aria-hidden="true"></i> 
                        <strong>Privacidad comunitaria:</strong> Por respeto a tu familia, no incluyas apellidos completos ni diagnósticos médicos sensibles.
                    </div>

                    <div class="mb-3">
                        <label for="velita-categoria" class="form-label small fw-semibold">Motivo o Categoría *</label>
                        <select class="form-select" id="velita-categoria" required>
                            <option value="Salud">Salud y Fortaleza</option>
                            <option value="Trabajo">Trabajo y Sustento</option>
                            <option value="Difuntos">Eterno Descanso (Difuntos)</option>
                            <option value="Familia">Paz y Familia</option>
                            <option value="Agradecimiento">Acción de Gracias</option>
                            <option value="Especial">Intención Especial</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="velita-peticion" class="form-label small fw-semibold">Tu Petición u Oración *</label>
                        <textarea class="form-control" id="velita-peticion" rows="3" required placeholder="Escribe tu súplica o agradecimiento..."></textarea>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="velita-anonimo" checked>
                        <label class="form-check-label small fw-semibold" for="velita-anonimo">
                            Publicar como <strong>Anónimo</strong> en el muro público
                        </label>
                    </div>

                    <div class="mb-3" id="campo-nombre-velita" style="display: none;">
                        <label for="velita-nombre" class="form-label small fw-semibold">Tu Nombre de Pila</label>
                        <input type="text" class="form-control" id="velita-nombre" placeholder="Ej.: María o Familia G.">
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label for="velita-email" class="form-label small text-muted">Correo (Opcional)</label>
                            <input type="email" class="form-control form-control-sm" id="velita-email" placeholder="Para aviso si se menciona en misa">
                        </div>
                        <div class="col-6">
                            <label for="velita-whatsapp" class="form-label small text-muted">WhatsApp (Opcional)</label>
                            <input type="tel" class="form-control form-control-sm" id="velita-whatsapp" placeholder="Solo uso pastoral">
                        </div>
                    </div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">
                        Tus datos de contacto nunca son visibles al público y solo los consulta el sacerdote para dar seguimiento espiritual.
                    </small>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark btn-sm px-3 shadow-sm">
                        <i class="bi bi-fire me-1" aria-hidden="true"></i> Encender Velita (7 días)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Solicitar Cita Pastoral (RF-22) -->
<div class="modal fade" id="modalSolicitarCita" tabindex="-1" aria-labelledby="modalSolicitarCitaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-bottom border-warning border-3">
                <h5 class="modal-title fw-bold" id="modalSolicitarCitaTitle" style="font-family: var(--font-heading);">
                    <i class="bi bi-calendar2-check text-warning me-2" aria-hidden="true"></i> Solicitar Cita Pastoral
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form-solicitar-cita">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="cita-nombre" class="form-label small fw-semibold">Nombre Completo *</label>
                        <input type="text" class="form-control" id="cita-nombre" required placeholder="Tu nombre">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="cita-telefono" class="form-label small fw-semibold">Teléfono *</label>
                            <input type="tel" class="form-control" id="cita-telefono" required placeholder="238 000 0000">
                        </div>
                        <div class="col-6">
                            <label for="cita-email" class="form-label small fw-semibold">Correo Electrónico</label>
                            <input type="email" class="form-control" id="cita-email" placeholder="tu@correo.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cita-tipo" class="form-label small fw-semibold">Motivo de la Cita *</label>
                        <select class="form-select" id="cita-tipo" required>
                            <option value="pastoral_parroco">Acompañamiento Espiritual con el Párroco</option>
                            <option value="preparacion_matrimonial">Presentación y Expediente Matrimonial</option>
                            <option value="notarial_tramites">Trámites y Corrección de Actas</option>
                            <option value="otra">Bendición o Caso Especial</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="cita-fecha" class="form-label small fw-semibold">Fecha Deseada *</label>
                            <input type="date" class="form-control" id="cita-fecha" required>
                        </div>
                        <div class="col-6">
                            <label for="cita-hora" class="form-label small fw-semibold">Horario Preferente</label>
                            <select class="form-select" id="cita-hora">
                                <option value="16:00">16:00 hrs (Tarde)</option>
                                <option value="17:00">17:00 hrs (Tarde)</option>
                                <option value="18:00">18:00 hrs (Tarde)</option>
                                <option value="11:00">11:00 hrs (Domingo)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cita-motivo" class="form-label small fw-semibold">Breve Explicación *</label>
                        <textarea class="form-control" id="cita-motivo" rows="2" required placeholder="Describe brevemente el asunto..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold" style="background-color: var(--color-primary);">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Solicitar Intención de Misa (RF-21) -->
<div class="modal fade" id="modalIntencionMisa" tabindex="-1" aria-labelledby="modalIntencionMisaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-bottom border-warning border-3">
                <h5 class="modal-title fw-bold" id="modalIntencionMisaTitle" style="font-family: var(--font-heading);">
                    <i class="bi bi-journal-plus text-warning me-2" aria-hidden="true"></i> Registrar Intención de Misa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="form-intencion-misa">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="intencion-capilla" class="form-label small fw-semibold">Sede o Capilla *</label>
                        <select class="form-select" id="intencion-capilla" required>
                            <option value="1">Templo Parroquial (Sede Centro)</option>
                            <option value="2">Capilla del Observatorio (Sectores 14 y 15)</option>
                            <option value="3">Capilla San Juan Diego [SUPUESTO]</option>
                            <option value="4">Capilla Ntra. Sra. de Guadalupe [SUPUESTO]</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="intencion-tipo" class="form-label small fw-semibold">Tipo de Intención *</label>
                        <select class="form-select" id="intencion-tipo" required>
                            <option value="Difuntos">Eterno Descanso de Difunto</option>
                            <option value="Salud">Salud y Sanación</option>
                            <option value="Acción de Gracias">Acción de Gracias</option>
                            <option value="Especial">Necesidades Especiales / Familia</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="intencion-nombre" class="form-label small fw-semibold">Nombre de la Persona o Familia *</label>
                        <input type="text" class="form-control" id="intencion-nombre" required placeholder="Ej.: Por el descanso de Don Pedro Pérez">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="intencion-fecha" class="form-label small fw-semibold">Fecha de la Misa *</label>
                            <input type="date" class="form-control" id="intencion-fecha" required>
                        </div>
                        <div class="col-6">
                            <label for="intencion-hora" class="form-label small fw-semibold">Horario de Misa *</label>
                            <input type="time" class="form-control" id="intencion-hora" required value="12:00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="intencion-solicitante" class="form-label small fw-semibold">Nombre de quien solicita *</label>
                        <input type="text" class="form-control" id="intencion-solicitante" required placeholder="Tu nombre">
                    </div>
                    <div class="alert alert-light border small text-muted mb-0">
                        <strong>Estipendio de ofrenda:</strong> Aportación orientativa voluntaria de $50.00 MXN <code>[SUPUESTO]</code>. Puede entregarse en la notaría o antes de iniciar la celebración.
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold" style="background-color: var(--color-primary);">
                        Registrar Intención
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 4: Aviso de Privacidad Pastoral (RNF-10) -->
<div class="modal fade" id="modalPrivacidad" tabindex="-1" aria-labelledby="modalPrivacidadTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalPrivacidadTitle" style="font-family: var(--font-heading);">
                    Aviso de Privacidad Pastoral
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body small text-muted p-4">
                <p>La <strong>Parroquia María Madre de Dios</strong>, perteneciente a la Diócesis de Tehuacán, es responsable del tratamiento confidencial de los datos personales recabados a través de la plataforma <strong>Vinea Comunidad</strong>.</p>
                <h6>Finalidades del Tratamiento</h6>
                <p>Los datos suministrados voluntariamente (nombres, números de teléfono, correos electrónicos y solicitudes de citas o sacramentos) serán utilizados única y exclusivamente para fines pastorales, administrativos y de comunicación directa de la parroquia.</p>
                <h6>Confidencialidad en el Muro de Oraciones</h6>
                <p>Los correos y números de WhatsApp registrados en peticiones devocionales permanecen estrictamente ocultos del público y se emplean exclusivamente para notificar cuando una intención ha sido elevada en la Santa Misa dominical.</p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
