<?php
/**
 * Local variables.
 *
 * @var array $grouped_timezones
 */
?>
<style>
/* === ESQUINAS REDONDAS EN LA PÁGINA DE RESERVA === */
#book-appointment-wizard .btn,
#book-appointment-wizard .form-select,
#book-appointment-wizard .form-control {
    border-radius: 0.6rem !important;
}

/* === PÍLDORAS DE EMPLEADOS === */
#provider-step2-pills .provider-pill {
    border-radius: 999px !important;
    padding: 0.45rem 1.4rem;
    font-weight: 600;
    cursor: pointer;
}

/* ============================= */
/* === CALENDARIO FLATPICKR === */
/* ============================= */

/* Contenedor */
.flatpickr-calendar {
    border-radius: 1rem !important;
    overflow: hidden !important;
}

/* Días */
.flatpickr-day {
    border-radius: 0.5rem !important;
}

/* ========================================= */
/* ====== FLECHAS ALINEADAS Y MODERNAS ===== */
/* ========================================= */

.flatpickr-calendar .flatpickr-months {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding-top: 6px !important; /* Alineación precisa */
}

/* Flechas izquierda/derecha */
.flatpickr-prev-month,
.flatpickr-next-month {
    display: flex !important;
    visibility: visible !important;
    opacity: 1 !important;
    pointer-events: all !important;
    align-items: center !important;
    justify-content: center !important;
    width: 34px !important;
    height: 34px !important;
    margin-top: 4px !important; /* BAJA LAS FLECHAS PARA QUE QUEDEN SIMÉTRICAS */
    margin-left: 8px !important;
    margin-right: 8px !important;
    border-radius: 50% !important;
    color: white !important;
    font-size: 19px !important;
    transition: 0.25s;
}

/* Hover suave */
.flatpickr-prev-month:hover,
.flatpickr-next-month:hover {
    background: rgba(255,255,255,0.25) !important;
}

/* Quitar piquito */
.flatpickr-calendar::before,
.flatpickr-calendar::after {
    display: none !important;
    visibility: hidden !important;
}

/* ============================= */
/* === OCULTAR ICONO TRADUCTOR GOOGLE (tick verde) === */
/* ============================= */

.goog-te-spinner-pos,
.goog-te-balloon-frame,
.goog-te-menu-frame.skiptranslate,
.goog-te-gadget-simple,
.goog-tooltip,
.goog-logo-link,
.goog-te-banner-frame {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
}

body { top: 0 !important; }

/* ============================= */
/* === HORAS DISPONIBLES ======= */
/* ============================= */

#available-hours .available-hour,
#available-hours .available-hour.selected-hour {
    border-radius: 0.7rem !important;
}

/* ============================= */
/* === OCULTAR ZONA HORARIA ==== */
/* ============================= */

#select-timezone,
label[for="select-timezone"] {
    display: none !important;
}

</style>

<div id="wizard-frame-2" class="wizard-frame" style="display:none;">
    <div class="frame-container">

        <h2 class="frame-title"><?= lang('appointment_date_and_time') ?></h2>

        <!-- Selector de EMPLEADO tipo píldoras -->
        <div class="mb-3">
            <label class="form-label">
                <strong>Empleado</strong>
            </label>

            <!-- Select oculto para JS -->
            <select id="select-provider-step2" class="form-select d-none"></select>

            <!-- Contenedor de píldoras -->
            <div id="provider-step2-pills" class="d-flex flex-wrap gap-2"></div>
        </div>

        <div class="row frame-content">
            <div class="col-12 col-md-6">
                <div id="select-date"></div>
                <?php slot('after_select_date'); ?>
            </div>

            <div class="col-12 col-md-6">
                <div id="select-time">

                    <!-- Selector zona horaria (OCULTO) -->
                    <div class="mb-3">
                        <label for="select-timezone" class="form-label">
                            <?= lang('timezone') ?>
                        </label>
                        <?php component('timezone_dropdown', [
                            'attributes' => 'id="select-timezone" class="form-select" value="Europe/Madrid"',
                            'grouped_timezones' => $grouped_timezones,
                        ]); ?>
                    </div>

                    <?php slot('after_select_timezone'); ?>

                    <!-- Horas disponibles -->
                    <div id="available-hours"></div>

                    <?php slot('after_available_hours'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="command-buttons">
        <button type="button" id="button-back-2"
                class="btn button-back btn-outline-secondary"
                data-step_index="2">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>

        <button type="button" id="button-next-2"
                class="btn button-next btn-dark"
                data-step_index="2">
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>
