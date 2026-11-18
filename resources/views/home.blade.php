@extends('layouts.app')

@section('title', 'Parroquia María Madre de Dios — Tehuacán | Vinea Comunidad')

@section('content')

        <!-- 1. HERO SECTION -->
        <section id="inicio" class="hero-section text-center text-lg-start">
            <div class="container-xl">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="hero-badge mb-3">
                            <i class="bi bi-geo-alt-fill me-1" aria-hidden="true"></i> Diócesis de Tehuacán · Puebla
                        </div>
                        <h1 class="hero-title mb-3">
                            Parroquia María Madre de Dios
                        </h1>
                        <p class="lead text-white-90 mb-4" style="font-size: 1.25rem; font-weight: 300;">
                            "Hagan lo que Él les diga" (Jn 2, 5). Comunidad viva de fe, esperanza y caridad que acoge a la sede parroquial y a sus capillas filiales en Tehuacán.
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                            <a href="#muro" class="btn btn-warning btn-lg fw-bold text-dark px-4 shadow">
                                <i class="bi bi-fire me-2" aria-hidden="true"></i> Encender Velita Virtual
                            </a>
                            <a href="#sacramentos" class="btn btn-outline-light btn-lg fw-semibold px-4">
                                <i class="bi bi-book me-2" aria-hidden="true"></i> Guía de Sacramentos
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card p-4 shadow-lg border-0 bg-white text-dark rounded-4">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                <h2 class="h5 fw-bold mb-0 text-primary" style="font-family: var(--font-heading);">
                                    <i class="bi bi-clock-history me-1 text-warning" aria-hidden="true"></i> Misas de Hoy
                                </h2>
                                <span class="badge bg-success">Horarios Habituales</span>
                            </div>
                            <ul class="list-unstyled mb-3 small">
                                <li class="py-2 border-bottom d-flex justify-content-between">
                                    <span><strong>Sede Parroquial:</strong></span>
                                    <span class="text-primary fw-semibold">19:00 hrs [SUPUESTO]</span>
                                </li>
                                <li class="py-2 border-bottom d-flex justify-content-between">
                                    <span><strong>Capilla del Observatorio:</strong></span>
                                    <span class="text-primary fw-semibold">Sáb 18:00 | Dom 11:00 hrs</span>
                                </li>
                                <li class="py-2 border-bottom d-flex justify-content-between">
                                    <span><strong>Notaría Parroquial:</strong></span>
                                    <span class="text-muted">Mar a Sáb 15:00 - 19:00 hrs</span>
                                </li>
                            </ul>
                            <a href="#horarios" class="btn btn-outline-primary btn-sm w-100 fw-semibold">
                                <i class="bi bi-calendar3 me-1" aria-hidden="true"></i> Ver todos los horarios y capillas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. SECCIÓN LA PARROQUIA (INFORMACIÓN INSTITUCIONAL - MÓDULO 1) -->
        <section id="parroquia" class="py-5 bg-white">
            <div class="container-xl">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <span class="text-uppercase fw-bold text-warning small tracking-wide">Nuestra Identidad</span>
                    <h2 class="h2 fw-bold text-primary mb-3">La Parroquia y su Comunidad</h2>
                    <p class="text-muted">
                        Somos una familia eclesial comprometida con la evangelización, la fraternidad solidaria y la devoción mariana en la Diócesis de Tehuacán.
                    </p>
                </div>

                <div class="row g-4 mb-5 align-items-center">
                    <div class="col-lg-6">
                        <h3 class="h4 fw-bold text-dark mb-3">Mensaje y Bienvenida Pastoral</h3>
                        <blockquote class="blockquote border-start border-4 border-warning ps-3 text-muted mb-4">
                            "Bienvenidos a Vinea Comunidad, el hogar digital de nuestra querida Parroquia María Madre de Dios. Esta plataforma nace del corazón de nuestra gente para que ningún hermano quede desinformado y para que la oración comunitaria nos mantenga siempre unidos."
                        </blockquote>
                        <p class="fw-semibold mb-1 text-primary">Pbro. Lic. Francisco Javier Morales [SUPUESTO]</p>
                        <small class="text-muted d-block mb-4">Párroco de María Madre de Dios</small>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSolicitarCita">
                                <i class="bi bi-calendar2-check me-1" aria-hidden="true"></i> Agendar Cita con el Párroco
                            </button>
                            <a href="https://wa.me/522383820000?text=Hola,%20quisiera%20información%20de%20la%20parroquia" 
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp me-1" aria-hidden="true"></i> WhatsApp Notaría
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card p-4 rounded-4 shadow-sm border-0 bg-light">
                            <h3 class="h5 fw-bold text-primary mb-3">Equipo Pastoral y Colaboradores</h3>
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white p-3 me-3 fs-4">
                                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Pbro. Francisco Javier Morales [SUPUESTO]</div>
                                    <small class="text-muted">Párroco y Guía Pastoral</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-warning text-dark p-3 me-3 fs-4">
                                    <i class="bi bi-person-badge-fill" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">C. Mateo Bautista [SUPUESTO]</div>
                                    <small class="text-muted">Sacristán y Auxiliar de Notaría</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success text-white p-3 me-3 fs-4">
                                    <i class="bi bi-people-fill" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Consejo Pastoral Parroquial</div>
                                    <small class="text-muted">Representantes de Capillas y Sectores</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Directorio Territorial de Capillas y Sectores -->
                <div class="mb-5">
                    <h3 class="h4 fw-bold text-primary mb-4 text-center">Directorio Territorial de Capillas y Sectores</h3>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 p-3 border-0 shadow-sm rounded-3">
                                <div class="badge bg-primary w-fit mb-2">Sede Principal</div>
                                <h4 class="h6 fw-bold mb-1">Templo Parroquial</h4>
                                <p class="small text-muted mb-2">Comprende los Sectores 1 al 13 [SUPUESTO]</p>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Calle 5 Poniente #120, Col. Centro</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 p-3 border-0 shadow-sm rounded-3 border-start border-3 border-warning">
                                <div class="badge bg-warning text-dark w-fit mb-2">Capilla Filial</div>
                                <h4 class="h6 fw-bold mb-1">Capilla del Observatorio</h4>
                                <p class="small text-dark fw-semibold mb-2">Comprende los Sectores 14 y 15 (Dato confirmado)</p>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Col. Observatorio, Tehuacán [SUPUESTO]</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 p-3 border-0 shadow-sm rounded-3">
                                <div class="badge bg-secondary w-fit mb-2">Capilla Filial [SUPUESTO]</div>
                                <h4 class="h6 fw-bold mb-1">Capilla San Juan Diego</h4>
                                <p class="small text-muted mb-2">Comprende los Sectores 16 y 17 [SUPUESTO]</p>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Col. San Diego, Tehuacán [SUPUESTO]</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 p-3 border-0 shadow-sm rounded-3">
                                <div class="badge bg-secondary w-fit mb-2">Capilla Filial [SUPUESTO]</div>
                                <h4 class="h6 fw-bold mb-1">Capilla Ntra. Sra. de Guadalupe</h4>
                                <p class="small text-muted mb-2">Comprende los Sectores 18 y 19 [SUPUESTO]</p>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Col. Tepeyac, Tehuacán [SUPUESTO]</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mapa Interactivo de Ubicación -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="h6 fw-bold mb-0">
                            <i class="bi bi-map me-1 text-warning" aria-hidden="true"></i> Ubicación Geográfica de la Parroquia y Capillas en Tehuacán
                        </h4>
                    </div>
                    <div class="ratio ratio-21x9" style="min-height: 280px;">
                        <!-- Mapa interactivo incrustado de Tehuacán, Puebla -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.3986427301016!2d-97.39851672392765!3d18.461019082618957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85c5bcd66e2c3cf3%3A0x6b772c67675f3a0a!2sTehuac%C3%A1n%2C%20Pue.!5e0!3m2!1ses-419!2smx!4v1700000000000!5m2!1ses-419!2smx" 
                                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                title="Mapa interactivo de la Parroquia María Madre de Dios y Capilla del Observatorio"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. SECCIÓN HORARIOS DE MISA (RF-02) -->
        <section id="horarios" class="py-5 bg-light">
            <div class="container-xl">
                <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
                    <div>
                        <span class="text-uppercase fw-bold text-warning small">Celebraciones Litúrgicas</span>
                        <h2 class="h2 fw-bold text-primary mb-1">Horarios de Misa por Capilla</h2>
                        <p class="text-muted mb-0">Filtra fácilmente las celebraciones de tu sector o capilla filial</p>
                    </div>
                    <div class="mt-3 mt-md-0" style="min-width: 260px;">
                        <label for="filtro-horarios-capilla" class="form-label small fw-semibold text-muted">Filtrar por sede:</label>
                        <select class="form-select shadow-sm" id="filtro-horarios-capilla" aria-label="Filtrar horarios por capilla">
                            <option value="todas">Todas las sedes y capillas</option>
                            <option value="1">Templo Parroquial (Centro)</option>
                            <option value="2">Capilla del Observatorio (Sectores 14 y 15)</option>
                            <option value="3">Capilla de San Juan Diego [SUPUESTO]</option>
                            <option value="4">Capilla Ntra. Sra. de Guadalupe [SUPUESTO]</option>
                        </select>
                    </div>
                </div>

                <div class="row g-4" id="contenedor-tarjetas-horarios">
                    <!-- Templo Parroquial -->
                    <div class="col-md-6 col-lg-4 tarjeta-horario" data-capilla-id="1">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 bg-white">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 class="h5 fw-bold text-primary mb-0">Templo Parroquial</h3>
                                <span class="badge bg-primary">Sede</span>
                            </div>
                            <p class="small text-muted mb-3"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Calle 5 Poniente #120, Col. Centro</p>
                            <hr class="my-2">
                            <div class="mb-2">
                                <strong class="d-block text-dark small">Misas de Domingo:</strong>
                                <span class="badge bg-light text-dark border me-1">08:00 AM</span>
                                <span class="badge bg-light text-dark border me-1">10:00 AM</span>
                                <span class="badge bg-warning text-dark border me-1">12:00 PM</span>
                                <span class="badge bg-light text-dark border">07:00 PM</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block text-dark small">Martes a Sábado:</strong>
                                <span class="badge bg-light text-dark border">07:00 PM [SUPUESTO]</span>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-auto" data-bs-toggle="modal" data-bs-target="#modalIntencionMisa">
                                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Solicitar Intención
                            </button>
                        </div>
                    </div>

                    <!-- Capilla del Observatorio -->
                    <div class="col-md-6 col-lg-4 tarjeta-horario" data-capilla-id="2">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 bg-white border-top border-4 border-warning">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 class="h5 fw-bold text-primary mb-0">Capilla del Observatorio</h3>
                                <span class="badge bg-warning text-dark">Sectores 14 y 15</span>
                            </div>
                            <p class="small text-muted mb-3"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Col. Observatorio, Tehuacán</p>
                            <hr class="my-2">
                            <div class="mb-2">
                                <strong class="d-block text-dark small">Misa de Sábado:</strong>
                                <span class="badge bg-light text-dark border">06:00 PM (Vigilia) [SUPUESTO]</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block text-dark small">Misa de Domingo:</strong>
                                <span class="badge bg-warning text-dark border">11:00 AM (Confirmado)</span>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-auto" data-bs-toggle="modal" data-bs-target="#modalIntencionMisa">
                                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Solicitar Intención
                            </button>
                        </div>
                    </div>

                    <!-- Capilla San Juan Diego -->
                    <div class="col-md-6 col-lg-4 tarjeta-horario" data-capilla-id="3">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 bg-white">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 class="h5 fw-bold text-primary mb-0">Capilla San Juan Diego</h3>
                                <span class="badge bg-secondary">Sectores 16 y 17 [SUPUESTO]</span>
                            </div>
                            <p class="small text-muted mb-3"><i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Col. San Diego [SUPUESTO]</p>
                            <hr class="my-2">
                            <div class="mb-3">
                                <strong class="d-block text-dark small">Misa de Domingo:</strong>
                                <span class="badge bg-light text-dark border">09:30 AM [SUPUESTO]</span>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-auto" data-bs-toggle="modal" data-bs-target="#modalIntencionMisa">
                                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Solicitar Intención
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SECCIÓN SERVICIOS PASTORALES Y SACRAMENTOS (MÓDULOS 2 Y 3) -->
        <section id="sacramentos" class="py-5 bg-white">
            <div class="container-xl">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <span class="text-uppercase fw-bold text-warning small tracking-wide">Trámites y Pastoral</span>
                    <h2 class="h2 fw-bold text-primary mb-3">Guía Interactiva de Sacramentos</h2>
                    <p class="text-muted">
                        Consulta la documentación requerida, perfil de padrinos, pláticas y descarga la lista oficial en PDF para realizar tu trámite con claridad y sin vueltas innecesarias.
                    </p>
                </div>

                <!-- Pestañas de Selección de Sacramento -->
                <ul class="nav nav-pills justify-content-center sacrament-tabs mb-4" id="sacramentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-bautismo" data-bs-toggle="pill" data-bs-target="#content-bautismo" type="button" role="tab" aria-controls="content-bautismo" aria-selected="true">
                            <i class="bi bi-droplet-fill me-1" aria-hidden="true"></i> Bautismo
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-comunion" data-bs-toggle="pill" data-bs-target="#content-comunion" type="button" role="tab" aria-controls="content-comunion" aria-selected="false">
                            <i class="bi bi-cup-hot-fill me-1" aria-hidden="true"></i> Primera Comunión
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-confirmacion" data-bs-toggle="pill" data-bs-target="#content-confirmacion" type="button" role="tab" aria-controls="content-confirmacion" aria-selected="false">
                            <i class="bi bi-fire me-1" aria-hidden="true"></i> Confirmación
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-matrimonio" data-bs-toggle="pill" data-bs-target="#content-matrimonio" type="button" role="tab" aria-controls="content-matrimonio" aria-selected="false">
                            <i class="bi bi-heart-fill me-1" aria-hidden="true"></i> Matrimonio
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las Pestañas -->
                <div class="tab-content" id="sacramentTabsContent">
                    <!-- BAUTISMO -->
                    <div class="tab-pane fade show active" id="content-bautismo" role="tabpanel" aria-labelledby="tab-bautismo">
                        <div class="card sacrament-card p-4 p-md-5">
                            <div class="row g-4 align-items-center mb-4">
                                <div class="col-md-8">
                                    <h3 class="h4 fw-bold text-primary mb-1">Sacramento del Bautismo</h3>
                                    <p class="text-muted mb-0">Para niños desde recién nacidos hasta antes de cumplir 7 años.</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button type="button" class="btn btn-primary fw-semibold btn-descargar-pdf shadow-sm" data-sacramento="bautismo" style="background-color: var(--color-primary);">
                                        <i class="bi bi-file-earmark-pdf me-1" aria-hidden="true"></i> Descargar Requisitos en PDF
                                    </button>
                                </div>
                            </div>

                            <div class="accordion" id="accordionBautismo">
                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="headingBautismo1">
                                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseB1" aria-expanded="true" aria-controls="collapseB1">
                                            1. Documentos requeridos para el niño(a)
                                        </button>
                                    </h4>
                                    <div id="collapseB1" class="accordion-collapse collapse show" aria-labelledby="headingBautismo1" data-bs-parent="#accordionBautismo">
                                        <div class="accordion-body small text-muted">
                                            <ul>
                                                <li>Acta de Nacimiento del niño(a) original y 2 copias legibles.</li>
                                                <li>Identificación oficial vigente (INE) de ambos padres.</li>
                                                <li>Comprobante de domicilio reciente (agua, luz o teléfono).</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="headingBautismo2">
                                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseB2" aria-expanded="false" aria-controls="collapseB2">
                                            2. Requisitos para los Padrinos
                                        </button>
                                    </h4>
                                    <div id="collapseB2" class="accordion-collapse collapse" aria-labelledby="headingBautismo2" data-bs-parent="#accordionBautismo">
                                        <div class="accordion-body small text-muted">
                                            <ul>
                                                <li><strong>Si son matrimonio:</strong> Deben estar casados por la Iglesia Católica (presentar Acta de Matrimonio Eclesiástico).</li>
                                                <li><strong>Si es soltero(a):</strong> Mayor de 16 años con sacramentos de Bautismo, Comunión y Confirmación.</li>
                                                <li>No pueden ser padrinos parejas en unión libre o casados solo por el civil.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="headingBautismo3">
                                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseB3" aria-expanded="false" aria-controls="collapseB3">
                                            3. Pláticas y Estipendio Orientativo
                                        </button>
                                    </h4>
                                    <div id="collapseB3" class="accordion-collapse collapse" aria-labelledby="headingBautismo3" data-bs-parent="#accordionBautismo">
                                        <div class="accordion-body small text-muted">
                                            <p><strong>Pláticas Prebautismales:</strong> Segundo y cuarto sábado de cada mes a las 16:00 hrs en el salón parroquial.</p>
                                            <div class="alert alert-warning py-2 mb-0">
                                                <strong>Estipendio orientativo sugerido:</strong> $250.00 MXN en misa comunitaria / $500.00 MXN individual <code>[SUPUESTO]</code>. Donativo voluntario para sostenimiento litúrgico.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PRIMERA COMUNIÓN -->
                    <div class="tab-pane fade" id="content-comunion" role="tabpanel" aria-labelledby="tab-comunion">
                        <div class="card sacrament-card p-4 p-md-5">
                            <div class="row g-4 align-items-center mb-4">
                                <div class="col-md-8">
                                    <h3 class="h4 fw-bold text-primary mb-1">Primera Comunión</h3>
                                    <p class="text-muted mb-0">Recepción del sacramento de la Eucaristía tras la formación catequética.</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button type="button" class="btn btn-primary fw-semibold btn-descargar-pdf shadow-sm" data-sacramento="comunion" style="background-color: var(--color-primary);">
                                        <i class="bi bi-file-earmark-pdf me-1" aria-hidden="true"></i> Descargar Requisitos en PDF
                                    </button>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-3 small">
                                <p><strong>Requisitos esenciales:</strong> Boleta de Bautismo actualizada, acta de nacimiento y constancia de 2 años de catequesis parroquial.</p>
                                <p class="mb-0"><strong>Fecha fija comunitaria:</strong> 22 de Noviembre de 2026, 10:00 hrs, Templo Parroquial (Solo lectura) <code>[SUPUESTO]</code>.</p>
                            </div>
                        </div>
                    </div>

                    <!-- CONFIRMACIÓN -->
                    <div class="tab-pane fade" id="content-confirmacion" role="tabpanel" aria-labelledby="tab-confirmacion">
                        <div class="card sacrament-card p-4 p-md-5">
                            <div class="row g-4 align-items-center mb-4">
                                <div class="col-md-8">
                                    <h3 class="h4 fw-bold text-primary mb-1">Sacramento de la Confirmación</h3>
                                    <p class="text-muted mb-0">Unción con el Santo Crisma para plenitud de la vida cristiana.</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button type="button" class="btn btn-primary fw-semibold btn-descargar-pdf shadow-sm" data-sacramento="confirmacion" style="background-color: var(--color-primary);">
                                        <i class="bi bi-file-earmark-pdf me-1" aria-hidden="true"></i> Descargar Requisitos en PDF
                                    </button>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-3 small">
                                <p><strong>Requisitos esenciales:</strong> Fe de Bautismo certificada, constancia de Primera Comunión y preparación de catequesis juvenil.</p>
                                <p class="mb-0"><strong>Fecha fija comunitaria:</strong> 15 de Noviembre de 2026, 11:00 hrs, Templo Parroquial (Presidida por el Vicario) <code>[SUPUESTO]</code>.</p>
                            </div>
                        </div>
                    </div>

                    <!-- MATRIMONIO -->
                    <div class="tab-pane fade" id="content-matrimonio" role="tabpanel" aria-labelledby="tab-matrimonio">
                        <div class="card sacrament-card p-4 p-md-5">
                            <div class="row g-4 align-items-center mb-4">
                                <div class="col-md-8">
                                    <h3 class="h4 fw-bold text-primary mb-1">Sacramento del Matrimonio</h3>
                                    <p class="text-muted mb-0">Unión sacramental de amor conyugal bendecida por la Iglesia.</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button type="button" class="btn btn-primary fw-semibold btn-descargar-pdf shadow-sm" data-sacramento="matrimonio" style="background-color: var(--color-primary);">
                                        <i class="bi bi-file-earmark-pdf me-1" aria-hidden="true"></i> Descargar Requisitos en PDF
                                    </button>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-3 small">
                                <p><strong>Trámite:</strong> Apertura de expediente matrimonial con 3 meses de anticipación, presentación con testigos y constancia de pláticas prematrimoniales.</p>
                                <p class="mb-0"><strong>Estipendio orientativo:</strong> $1,200.00 MXN <code>[SUPUESTO]</code>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. SECCIÓN CALENDARIO LITÚRGICO Y EVENTOS (MÓDULO 4 - RF-16) -->
        <section id="calendario" class="py-5 bg-light">
            <div class="container-xl">
                <div class="text-center max-w-700 mx-auto mb-4">
                    <span class="text-uppercase fw-bold text-warning small tracking-wide">Liturgia y Actividades</span>
                    <h2 class="h2 fw-bold text-primary mb-2">Calendario Parroquial y Litúrgico</h2>
                    <p class="text-muted">
                        Consulta las celebraciones litúrgicas, santoral, peregrinaciones y las fechas fijas oficiales de sacramentos comunitarios.
                    </p>
                </div>

                <div class="calendar-container shadow-sm mb-4">
                    <!-- Cabecera del Calendario -->
                    <div class="calendar-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-light btn-sm" id="cal-btn-prev" aria-label="Mes anterior">
                                <i class="bi bi-chevron-left" aria-hidden="true"></i>
                            </button>
                            <h3 class="h4 mb-0 fw-bold" id="cal-titulo-mes" style="font-family: var(--font-heading); min-width: 180px; text-align: center;">
                                Octubre 2026
                            </h3>
                            <button type="button" class="btn btn-outline-light btn-sm" id="cal-btn-next" aria-label="Mes siguiente">
                                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm text-dark fw-semibold ms-2" id="cal-btn-hoy">
                                Hoy
                            </button>
                        </div>

                        <!-- Filtro por Capilla -->
                        <div class="d-flex align-items-center gap-2">
                            <label for="cal-filtro-capilla" class="text-white small fw-semibold">Sede:</label>
                            <select class="form-select form-select-sm" id="cal-filtro-capilla" style="width: auto;" aria-label="Filtrar calendario por capilla">
                                <option value="todas">Todas las sedes</option>
                                <option value="1">Templo Parroquial</option>
                                <option value="2">Capilla del Observatorio (Sectores 14 y 15)</option>
                                <option value="3">Capilla San Juan Diego [SUPUESTO]</option>
                                <option value="4">Capilla Ntra. Sra. de Guadalupe [SUPUESTO]</option>
                            </select>
                        </div>
                    </div>

                    <!-- Leyenda Litúrgica Oficial -->
                    <div class="bg-white p-2 border-bottom d-flex flex-wrap justify-content-center gap-3 small text-muted">
                        <span class="d-flex align-items-center"><span class="badge-liturgico verde"></span> T. Ordinario</span>
                        <span class="d-flex align-items-center"><span class="badge-liturgico morado"></span> Cuaresma / Adviento</span>
                        <span class="d-flex align-items-center"><span class="badge-liturgico blanco"></span> Fiestas / Solemnidades</span>
                        <span class="d-flex align-items-center"><span class="badge-liturgico rojo"></span> Mártires</span>
                        <span class="d-flex align-items-center border-start ps-3"><span class="badge bg-primary text-white me-1">📌 [Fijo]</span> Fechas Fijas Oficiales</span>
                    </div>

                    <!-- Días de la Semana -->
                    <div class="calendar-grid">
                        <div class="calendar-day-header">DOM</div>
                        <div class="calendar-day-header">LUN</div>
                        <div class="calendar-day-header">MAR</div>
                        <div class="calendar-day-header">MIÉ</div>
                        <div class="calendar-day-header">JUE</div>
                        <div class="calendar-day-header">VIE</div>
                        <div class="calendar-day-header">SÁB</div>
                    </div>

                    <!-- Grilla de Celdas de Días (Desktop) -->
                    <div class="calendar-grid" id="cal-grid-dias">
                        <!-- Generado dinámicamente por js/calendario.js -->
                    </div>

                    <!-- Vista Alternativa Accesible para Móvil -->
                    <div class="calendar-mobile-list p-3" id="cal-mobile-list">
                        <!-- Generado dinámicamente por js/calendario.js -->
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. SECCIÓN MURO DE ORACIONES E INTENCIONES VIRTUALES (MÓDULO 6 - RF-25 AL RF-28) -->
        <section id="muro" class="py-5 bg-white">
            <div class="container-xl">
                <div class="row align-items-center justify-content-between mb-4 g-3">
                    <div class="col-md-8">
                        <span class="text-uppercase fw-bold text-warning small tracking-wide">Comunión y Esperanza</span>
                        <h2 class="h2 fw-bold text-primary mb-1">Muro de Oraciones e Intenciones Virtuales</h2>
                        <p class="text-muted mb-0">
                            Enciende una velita virtual que permanecerá viva durante 7 días en nuestro altar comunitario. Puedes publicar con tu nombre o en anonimato y rezar por tus hermanos.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button type="button" class="btn btn-warning btn-lg fw-bold text-dark shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEncenderVelita">
                            <i class="bi bi-fire me-1" aria-hidden="true"></i> Encender una Velita
                        </button>
                    </div>
                </div>

                <!-- Contenedor Dinámico de Velitas -->
                <div class="row g-4" id="muro-velitas-container">
                    <!-- Generado e interactuado mediante js/muro.js -->
                </div>
            </div>
        </section>

        <!-- 7. SECCIÓN GRUPOS PARROQUIALES Y VOLUNTARIADO (MÓDULO 5 - RF-24) -->
        <section id="grupos" class="py-5 bg-light">
            <div class="container-xl">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <span class="text-uppercase fw-bold text-warning small tracking-wide">Vida Comunitaria</span>
                    <h2 class="h2 fw-bold text-primary mb-2">Grupos Parroquiales y Voluntariado</h2>
                    <p class="text-muted">
                        Únete a los ministerios y apostolados de la parroquia. Da un paso de fe y servicio conectándote directamente con el coordinador de cada grupo.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Pastoral Juvenil -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 bg-white d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary-subtle text-primary p-3 me-3 fs-4">
                                    <i class="bi bi-heart-pulse-fill" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-0 text-dark">Pastoral Juvenil</h3>
                                    <small class="text-muted">Jóvenes de 14 a 25 años</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-3 flex-grow-1">
                                Formación espiritual, convivencias, retiros, misiones en capillas y alabanza juvenil.
                            </p>
                            <div class="small text-muted mb-3">
                                <i class="bi bi-clock me-1" aria-hidden="true"></i> Sábados 17:00 hrs · Salón Parroquial<br>
                                <i class="bi bi-person me-1" aria-hidden="true"></i> Coord.: Andrea R. [SUPUESTO]
                            </div>
                            <a href="https://wa.me/522383820000?text=Hola,%20deseo%20unirme%20al%20grupo%20de%20Pastoral%20Juvenil" 
                               target="_blank" class="btn btn-outline-success btn-sm w-100 fw-semibold">
                                <i class="bi bi-whatsapp me-1" aria-hidden="true"></i> Unirme al grupo
                            </a>
                        </div>
                    </div>

                    <!-- Catequesis Infantil -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 bg-white d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-warning-subtle text-warning p-3 me-3 fs-4">
                                    <i class="bi bi-book-half" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-0 text-dark">Catequesis Infantil</h3>
                                    <small class="text-muted">Comunión y Confirmación</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-3 flex-grow-1">
                                Preparación doctrinal y humana para niños y adolescentes en la fe católica.
                            </p>
                            <div class="small text-muted mb-3">
                                <i class="bi bi-clock me-1" aria-hidden="true"></i> Sábados 10:00 hrs · Aulas parroquiales<br>
                                <i class="bi bi-person me-1" aria-hidden="true"></i> Coord.: Profra. Carmen M. [SUPUESTO]
                            </div>
                            <a href="https://wa.me/522383820000?text=Hola,%20deseo%20información%20sobre%20la%20Catequesis%20Infantil" 
                               target="_blank" class="btn btn-outline-success btn-sm w-100 fw-semibold">
                                <i class="bi bi-whatsapp me-1" aria-hidden="true"></i> Unirme al grupo
                            </a>
                        </div>
                    </div>

                    <!-- Cáritas Parroquial -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 bg-white d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-danger-subtle text-danger p-3 me-3 fs-4">
                                    <i class="bi bi-hand-thumbs-up-fill" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold mb-0 text-dark">Cáritas y Pastoral Social</h3>
                                    <small class="text-muted">Solidaridad y ayuda fraterna</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-3 flex-grow-1">
                                Despensas alimentarias, visitas a enfermos y acompañamiento a familias vulnerables de los sectores.
                            </p>
                            <div class="small text-muted mb-3">
                                <i class="bi bi-clock me-1" aria-hidden="true"></i> Jueves 18:00 hrs · Dispensario<br>
                                <i class="bi bi-person me-1" aria-hidden="true"></i> Coord.: Sra. Lupita H. [SUPUESTO]
                            </div>
                            <a href="https://wa.me/522383820000?text=Hola,%20deseo%20ser%20voluntario%20en%20Cáritas%20Parroquial" 
                               target="_blank" class="btn btn-outline-success btn-sm w-100 fw-semibold">
                                <i class="bi bi-whatsapp me-1" aria-hidden="true"></i> Unirme al grupo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. SECCIÓN GALERÍA COMUNITARIA (GALERÍA DE LA ACTIVIDAD) -->
        <section id="galeria" class="py-5 bg-white">
            <div class="container-xl">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <span class="text-uppercase fw-bold text-warning small tracking-wide">Testimonio Gráfico</span>
                    <h2 class="h2 fw-bold text-primary mb-2">Galería de Vida y Fe</h2>
                    <p class="text-muted">Momentos significativos de nuestra comunidad en la celebración litúrgica y la fraternidad de capillas y sectores.</p>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                            <div class="bg-primary-subtle text-primary p-5 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                <i class="bi bi-image fs-1" aria-hidden="true"></i>
                            </div>
                            <div class="card-body p-3">
                                <p class="card-text small text-muted mb-0">Celebración Solemne en la Sede Parroquial de María Madre de Dios [SUPUESTO]</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                            <div class="bg-warning-subtle text-warning-emphasis p-5 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                <i class="bi bi-camera-fill fs-1" aria-hidden="true"></i>
                            </div>
                            <div class="card-body p-3">
                                <p class="card-text small text-muted mb-0">Peregrinación Comunitaria en la Capilla del Observatorio (Sectores 14 y 15) [SUPUESTO]</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                            <div class="bg-success-subtle text-success p-5 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                <i class="bi bi-people fs-1" aria-hidden="true"></i>
                            </div>
                            <div class="card-body p-3">
                                <p class="card-text small text-muted mb-0">Jornada de Formación y Retiro de Catequesis Infantil [SUPUESTO]</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 9. SECCIÓN CONTACTO Y NOTARÍA -->
        <section id="contacto" class="py-5 bg-light">
            <div class="container-xl">
                <div class="row g-5">
                    <div class="col-lg-5">
                        <span class="text-uppercase fw-bold text-warning small tracking-wide">Atención y Notaría</span>
                        <h2 class="h2 fw-bold text-primary mb-3">Contáctanos</h2>
                        <p class="text-muted mb-4">
                            Estamos para servirte y acompañarte. Consulta nuestros horarios de atención personalizada o déjanos un mensaje.
                        </p>

                        <div class="mb-4">
                            <h3 class="h6 fw-bold text-dark"><i class="bi bi-clock me-2 text-warning" aria-hidden="true"></i> Horario de Notaría Parroquial</h3>
                            <p class="small text-muted mb-1">Martes a Sábado: 15:00 a 19:00 hrs</p>
                            <p class="small text-muted mb-1">Domingo: 10:00 a 14:00 hrs</p>
                            <p class="small text-danger fw-semibold">Lunes: Cerrado por descanso pastoral</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="h6 fw-bold text-dark"><i class="bi bi-geo-alt me-2 text-warning" aria-hidden="true"></i> Dirección</h3>
                            <p class="small text-muted mb-0">Calle 5 Poniente #120, Col. Centro, C.P. 75700, Tehuacán, Puebla [SUPUESTO]</p>
                        </div>

                        <div>
                            <h3 class="h6 fw-bold text-dark"><i class="bi bi-telephone me-2 text-warning" aria-hidden="true"></i> Teléfono y WhatsApp</h3>
                            <p class="small text-muted mb-0">Tel. Notaría: +52 238 382 0000 [SUPUESTO]</p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
                            <h3 class="h4 fw-bold text-primary mb-3">Envíanos un Mensaje</h3>
                            <form id="formulario-contacto" novalidate>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="contacto-nombre" class="form-label small fw-semibold">Nombre Completo *</label>
                                        <input type="text" class="form-control" id="contacto-nombre" required placeholder="Tu nombre">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contacto-email" class="form-label small fw-semibold">Correo Electrónico *</label>
                                        <input type="email" class="form-control" id="contacto-email" required placeholder="tu@correo.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contacto-telefono" class="form-label small fw-semibold">Teléfono / WhatsApp</label>
                                        <input type="tel" class="form-control" id="contacto-telefono" placeholder="238 000 0000">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contacto-asunto" class="form-label small fw-semibold">Asunto</label>
                                        <select class="form-select" id="contacto-asunto">
                                            <option value="Informes de Sacramentos">Informes de Sacramentos</option>
                                            <option value="Trámites de Notaría">Trámites de Notaría</option>
                                            <option value="Intención de Misa">Intención de Misa</option>
                                            <option value="Consulta Pastoral">Consulta Pastoral</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="contacto-mensaje" class="form-label small fw-semibold">Mensaje *</label>
                                        <textarea class="form-control" id="contacto-mensaje" rows="4" required placeholder="¿En qué podemos ayudarte?"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check small text-muted">
                                            <input class="form-check-input" type="checkbox" id="check-privacidad" required checked>
                                            <label class="form-check-label" for="check-privacidad">
                                                He leído y acepto el <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad">Aviso de Privacidad</a> de la parroquia.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" style="background-color: var(--color-primary);">
                                            <i class="bi bi-send me-1" aria-hidden="true"></i> Enviar Mensaje a Notaría
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection

