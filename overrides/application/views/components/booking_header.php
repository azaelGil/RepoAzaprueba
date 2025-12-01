<?php
/**
 * Local variables.
 *
 * @var string $company_name
 * @var array|null $appointment_data
 */

// Color corporativo (por si quieres que sea variable).
$brandColor = setting('company_color') ?: '#2a7a68';

// Detectar si venimos con proveedor y servicio en la URL.
$ci =& get_instance();
$providerParam = $ci->input->get('provider');
$serviceParam  = $ci->input->get('service');

// Si hay provider + service => hemos saltado el paso de seleccionar servicio.
$skipServiceStep = !empty($providerParam) && !empty($serviceParam);

// Números que se muestran en cada paso.
if ($skipServiceStep) {
    // No se renderiza step-1. Visualmente habrá 1,2,3.
    $labelStep2 = 1;
    $labelStep3 = 2;
    $labelStep4 = 3;
} else {
    // Flujo normal 1,2,3,4.
    $labelStep2 = 2;
    $labelStep3 = 3;
    $labelStep4 = 4;
}
?>

<div id="header" class="container-fluid py-2 px-3"
     style="background-color:<?= $brandColor ?>;border-radius:8px; overflow: hidden;">
    <div class="row align-items-center">

        <!-- Logo y nombre de empresa -->
        <div class="col-md-5 col-sm-12 d-flex align-items-center">
            <img src="<?= vars('company_logo') ?: base_url('assets/img/logo.png') ?>"
                 alt="logo"
                 id="company-logo"
                 style="height:36px;width:auto;margin-right:10px;">

            <div>
                <span class="fw-bold text-white fs-5">
                    <?= e($company_name) ?>
                </span>
                <div class="d-flex flex-wrap small text-white-50">
                    <span class="display-selected-service me-1 pe-1 border-end invisible">
                        <?= lang('service') ?>
                    </span>
                    <span class="display-selected-provider invisible ms-1">
                        <?= lang('provider') ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Pasos numerados alineados horizontalmente -->
        <div class="col-md-4 col-sm-12 text-center my-2 my-md-0" id="steps"
             style="display: flex; justify-content: center; gap: 5px; overflow: hidden;">

            <?php if (!$skipServiceStep): ?>
                <div id="step-1"
                     class="book-step active-step"
                     data-tippy-content="<?= lang('service_and_provider') ?>"
                     data-visual-step="1">
                    <strong>1</strong>
                </div>
            <?php endif; ?>

            <div id="step-2"
                 class="book-step"
                 data-tippy-content="<?= lang('appointment_date_and_time') ?>"
                 data-visual-step="<?= $labelStep2 ?>">
                <strong><?= $labelStep2 ?></strong>
            </div>

            <div id="step-3"
                 class="book-step"
                 data-tippy-content="<?= lang('customer_information') ?>"
                 data-visual-step="<?= $labelStep3 ?>">
                <strong><?= $labelStep3 ?></strong>
            </div>

            <div id="step-4"
                 class="book-step"
                 data-tippy-content="<?= lang('appointment_confirmation') ?>"
                 data-visual-step="<?= $labelStep4 ?>">
                <strong><?= $labelStep4 ?></strong>
            </div>
        </div>

    </div>
</div>

<style>
#steps {
    display: flex !important; /* Asegura que los pasos estén en una fila */
    justify-content: center !important; /* Centra los pasos */
    gap: 3px !important; /* Reducir aún más el espaciado entre los pasos */
    flex-wrap: nowrap !important; /* Evita que se apilen en varias líneas */
    overflow: hidden !important; /* Evita que aparezca una barra de desplazamiento */
}

.book-step {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 30px !important;  /* Hacer los pasos más pequeños */
    height: 30px !important; /* Ajustar la altura para hacerlo más cuadrado */
    color: white !important;
    font-weight: bold !important;
    border-radius: 5px !important; /* Bordes más redondeados */
    transition: background-color 0.3s ease !important;
    position: relative !important;
}

/* Ocultamos el número interno por si el JS lo cambia */
.book-step strong {
    display: none !important;
}

/* Mostramos siempre el número "bueno" desde data-visual-step */
.book-step::after {
    content: attr(data-visual-step);
    font-size: 15px;
    font-weight: 700;
}

/* Aseguramos que el último paso tenga el mismo tamaño */
#steps .book-step:last-child {
    margin-left: 0 !important;
    width: 30px !important;
}

.book-step:hover {
    background-color: #2295a1 !important;
}

.book-step.active-step {
    background-color: rgba(17, 24, 39, 0.7) !important; /* color activo */
    color: white !important;
}

.btn-lg {
    padding: 0.5rem 1rem !important; /* Reducir tamaño de los botones */
    font-size: 1.1rem !important; /* Reducir tamaño de la fuente */
    border-radius: 0.25rem !important; /* Botón más redondeado */
}
</style>
