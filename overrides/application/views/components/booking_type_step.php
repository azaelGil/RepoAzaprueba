<?php
/**
 * Step 1: Selección de servicio (con categorías) + provider oculto.
 */

// Color corporativo de la empresa
$brandColor = setting('company_color') ?: '#35A768';

// Servicios disponibles (vienen del Booking controller)
$services = vars('available_services') ?? [];

// Agrupar servicios por id_service_categories
$servicesByCategory = [];
$categoryIds        = [];

foreach ($services as $serviceRaw) {
    // Normalizamos a array (por si viene como objeto)
    $service = (array)$serviceRaw;

    // Algunos servicios pueden no tener categoría → los ponemos en 0 ("Otros")
    $catId = isset($service['id_service_categories']) ? (int)$service['id_service_categories'] : 0;

    if ($catId > 0) {
        $categoryIds[$catId] = $catId;
    }

    if (!isset($servicesByCategory[$catId])) {
        $servicesByCategory[$catId] = [];
    }

    $servicesByCategory[$catId][] = $service;
}

// Cargar nombres + descripciones de categorías desde la BD (ea_service_categories)
$categoryData = [];

if (!empty($categoryIds)) {
    $CI =& get_instance();

    $CI->db->select('id, name, description');
    $CI->db->from('ea_service_categories');
    $CI->db->where_in('id', array_values($categoryIds));
    $query = $CI->db->get();

    foreach ($query->result() as $row) {
        $categoryData[(int)$row->id] = [
            'name'        => $row->name,
            'description' => $row->description,
        ];
    }
}

/**
 * Helper: título del paso.
 * Si no hay traducción de "select_service_and_provider", mostramos "Seleccione Servicio".
 */
$rawTitle  = lang('select_service_and_provider');
$stepTitle = ($rawTitle !== 'select_service_and_provider')
    ? $rawTitle
    : 'Seleccione Servicio';
?>

<div id="wizard-frame-1" class="wizard-frame">
    <div class="frame-container">
        <h2 class="frame-title mb-4">
            <?= htmlspecialchars($stepTitle, ENT_QUOTES, 'UTF-8') ?>
        </h2>

        <!-- 🔒 Selects ORIGINALES (OCULTOS) para mantener la lógica interna -->
        <div class="d-none">
            <div class="mb-3">
                <label for="select-service" class="form-label">
                    <?= lang('service') ?>
                </label>
                <select id="select-service" class="form-select">
                    <option value=""><?= lang('please_select') ?></option>
                    <?php foreach ($services as $serviceRaw): ?>
                        <?php $service = (array)$serviceRaw; ?>
                        <option value="<?= (int)($service['id'] ?? 0) ?>">
                            <?= htmlspecialchars((string)($service['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="select-provider" class="form-label">
                    <?= lang('provider') ?>
                </label>
                <select id="select-provider" class="form-select">
                    <!-- Ocultamos la opción 'please select' si no hay proveedor seleccionado -->
                    <option value="" class="d-none"><?= lang('please_select') ?></option> <!-- Oculta el "Please Select" -->
                    <!-- Se rellenará desde booking.js -->
                </select>
            </div>
        </div>
        <!-- 🔒 FIN selects ocultos -->

        <!-- 🔥 NUEVA UI: TARJETAS AGRUPADAS POR CATEGORÍA -->
        <?php if (!empty($servicesByCategory)): ?>
            <div class="services-by-category">

                <?php foreach ($servicesByCategory as $catId => $servicesInCategory): ?>
                    <?php
                    $categoryIdAttr = 'category-' . ($catId > 0 ? (int)$catId : 0);

                    $categoryName = lang('services');
                    $categoryDesc = '';

                    if ($catId > 0 && isset($categoryData[$catId])) {
                        $categoryName = $categoryData[$catId]['name'] ?: $categoryName;
                        $categoryDesc = trim((string)$categoryData[$catId]['description']);
                    }

                    $servicesCount = count($servicesInCategory);
                    $servicesLabel = $servicesCount === 1
                        ? '1 servicio'
                        : $servicesCount . ' servicios';
                    ?>
                    <div class="service-category-block mb-4">
                        <!-- Cabecera de categoría con flecha + contador -->
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <button
                                type="button"
                                class="btn btn-link p-0 d-flex align-items-center category-toggle"
                                data-target="#<?= htmlspecialchars($categoryIdAttr, ENT_QUOTES, 'UTF-8') ?>"
                                style="text-decoration: none; color: #000;"
                            >
                                <i class="fas fa-caret-down me-2 category-toggle-icon" style="color:#000;"></i>
                                <span class="fw-bold fs-5 text-black">
                                    <?= htmlspecialchars((string)$categoryName, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </button>

                            <span class="small text-muted ms-2">
                                <?= htmlspecialchars($servicesLabel, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>

                        <?php if ($categoryDesc !== ''): ?>
                            <p class="category-description small text-muted ms-4 mb-2">
                                <?= nl2br(htmlspecialchars($categoryDesc, ENT_QUOTES, 'UTF-8')) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Lista de servicios de la categoría -->
                        <div id="<?= htmlspecialchars($categoryIdAttr, ENT_QUOTES, 'UTF-8') ?>" class="category-services">
                            <div class="row g-3">
                                <?php foreach ($servicesInCategory as $service): ?>
                                    <?php
                                    // $service ya es array
                                    $id          = (int)($service['id'] ?? 0);
                                    $name        = (string)($service['name'] ?? '');
                                    $duration    = $service['duration'] ?? null;
                                    $price       = $service['price'] ?? null;
                                    $currency    = (string)($service['currency'] ?? '');
                                    $location    = (string)($service['location'] ?? '');
                                    $description = trim((string)($service['description'] ?? ''));

                                    $hasPrice = ($price !== null && $price !== '' && is_numeric($price));
                                    ?>
                                    <div class="col-12">
                                        <div
                                            class="service-card border rounded-3 px-2 py-1 d-flex flex-row justify-content-between align-items-stretch"
                                            style="min-height: 90px; font-size: 0.8rem;"
                                        >
                                            <!-- Columna izquierda: nombre + descripción + ubicación -->
                                            <div class="flex-grow-1 pe-3 d-flex flex-column justify-content-center">
                                                <h4 class="h6 mb-1">
                                                    <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>
                                                </h4>

                                                <?php if ($description !== ''): ?>
                                                    <p class="mb-1 small text-muted">
                                                        <?= nl2br(htmlspecialchars($description, ENT_QUOTES, 'UTF-8')) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <?php if ($location !== ''): ?>
                                                    <div class="small text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        <?= htmlspecialchars($location, ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Columna derecha: precio + duración (a la izquierda) + botón -->
                                            <div class="ms-3 d-flex align-items-center justify-content-end flex-shrink-0">
                                                <div class="me-3 text-end">
                                                    <?php if ($hasPrice): ?>
                                                        <div class="fw-bold small">
                                                            <?= number_format((float)$price, 2, ',', '.') ?>
                                                            <?= $currency ? ' ' . htmlspecialchars($currency, ENT_QUOTES, 'UTF-8') : '' ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($duration)): ?>
                                                        <div class="text-muted small">
                                                            <?= (int)$duration . ' ' . lang('minutes') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-select-service"
                                                    data-service-id="<?= $id ?>"
                                                    style="
                                                        background-color: <?= $brandColor ?>;
                                                        border-color: <?= $brandColor ?>;
                                                        border-radius: 8px;
                                                        padding-inline: 12px;
                                                        padding-block: 4px;
                                                        font-size: 0.8rem;
                                                    "
                                                >
                                                    <?= 'Reservar' ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div> <!-- /.row -->
                        </div> <!-- /.category-services -->
                    </div>
                <?php endforeach; ?>

            </div>
        <?php else: ?>
            <p class="text-muted">
                <?= lang('no_records_found') ?>
            </p>
        <?php endif; ?>

        <!-- Descripción extra: la dejamos OCULTA para que nunca se vea -->
        <div id="service-description" class="mt-3 d-none"></div>
    </div>

    <!-- Botón siguiente OCULTO: lo dispara booking.js al hacer clic en "Reservar" -->
    <div class="command-buttons d-none">
        <button
            type="button"
            id="button-next-1"
            class="btn button-next btn-dark"
            data-step_index="1"
        >
            <?= lang('next') ?>
            <i class="fas fa-chevron-right ms-2"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle de categorías (mostrar / ocultar servicios)
    document.querySelectorAll('.category-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const targetSelector = this.getAttribute('data-target');
            if (!targetSelector) return;

            const target = document.querySelector(targetSelector);
            if (!target) return;

            const icon = this.querySelector('.category-toggle-icon');
            const isCollapsed = target.classList.toggle('d-none');

            if (icon) {
                icon.classList.toggle('fa-caret-down', !isCollapsed);
                icon.classList.toggle('fa-caret-right', isCollapsed);
            }
        });
    });
});
</script>
