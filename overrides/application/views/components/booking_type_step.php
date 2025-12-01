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
    <div class="frame-container service-step" style="--brand-color: <?= $brandColor ?>;">
        <h2 class="frame-title mb-4 service-step__title">
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
                        <div class="category-header">
                            <button
                                type="button"
                                class="category-toggle"
                                data-target="#<?= htmlspecialchars($categoryIdAttr, ENT_QUOTES, 'UTF-8') ?>"
                            >
                                <i class="fas fa-caret-down me-2 category-toggle-icon"></i>
                                <span class="category-title">
                                    <?= htmlspecialchars((string)$categoryName, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </button>

                            <span class="category-meta">
                                <?= htmlspecialchars($servicesLabel, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>

                        <?php if ($categoryDesc !== ''): ?>
                            <p class="category-description">
                                <?= nl2br(htmlspecialchars($categoryDesc, ENT_QUOTES, 'UTF-8')) ?>
                            </p>
                        <?php endif; ?>

                        <div id="<?= htmlspecialchars($categoryIdAttr, ENT_QUOTES, 'UTF-8') ?>" class="category-services">
                            <div class="row g-3">
                                <?php foreach ($servicesInCategory as $service): ?>
                                    <?php
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
                                        <div class="service-card">
                                            <div class="service-main">
                                                <h4 class="service-name">
                                                    <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>
                                                </h4>

                                                <?php if ($description !== ''): ?>
                                                    <p class="service-description">
                                                        <?= nl2br(htmlspecialchars($description, ENT_QUOTES, 'UTF-8')) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <?php if ($location !== ''): ?>
                                                    <div class="service-location">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        <?= htmlspecialchars($location, ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="service-actions">
                                                <div class="service-meta text-end">
                                                    <?php if ($hasPrice): ?>
                                                        <div class="service-price">
                                                            <?= number_format((float)$price, 2, ',', '.') ?>
                                                            <?= $currency ? ' ' . htmlspecialchars($currency, ENT_QUOTES, 'UTF-8') : '' ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($duration)): ?>
                                                        <div class="service-duration">
                                                            <?= (int)$duration . ' ' . lang('minutes') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-select-service service-cta"
                                                    data-service-id="<?= $id ?>"
                                                >
                                                    <?= 'Reservar' ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
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

<style>
    .service-step {
        --card-radius: 14px;
    }

    .service-step__title {
        font-weight: 700;
        color: #0f172a;
    }

    .services-by-category {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .service-category-block {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: var(--card-radius);
        padding: 16px 16px 10px 16px;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
    }

    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .category-toggle {
        border: none;
        background: transparent;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #0f172a;
        padding: 6px 0;
        cursor: pointer;
    }

    .category-toggle:focus-visible {
        outline: 2px solid var(--brand-color);
        outline-offset: 2px;
    }

    .category-toggle-icon {
        color: #0f172a;
        transition: transform 0.2s ease;
    }

    .category-title {
        font-size: 1.05rem;
    }

    .category-meta {
        font-size: 0.9rem;
        color: #6b7280;
        background: #ffffff;
        padding: 6px 12px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
    }

    .category-description {
        margin: 4px 0 10px 0;
        color: #6b7280;
        font-size: 0.92rem;
    }

    .category-services {
        margin-top: 6px;
    }

    .service-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: stretch;
        justify-content: space-between;
        gap: 14px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
    }

    .service-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .service-name {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: #0f172a;
    }

    .service-description {
        margin: 0;
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .service-location {
        color: #6b7280;
        font-size: 0.88rem;
    }

    .service-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .service-meta {
        min-width: 120px;
    }

    .service-price {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.95rem;
    }

    .service-duration {
        color: #6b7280;
        font-size: 0.85rem;
    }

    .service-cta {
        background: var(--brand-color);
        border-color: var(--brand-color);
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 14px 24px rgba(53, 167, 104, 0.3);
    }

    .service-cta:hover {
        filter: brightness(0.95);
        color: #fff;
    }

    .service-cta:focus-visible {
        outline: 3px solid rgba(53, 167, 104, 0.4);
        outline-offset: 2px;
    }

    @media (max-width: 768px) {
        .category-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .category-meta {
            align-self: flex-start;
        }

        .service-card {
            flex-direction: column;
        }

        .service-actions {
            width: 100%;
            justify-content: space-between;
        }

        .service-meta {
            text-align: left;
        }

        .service-cta {
            width: auto;
        }
    }

    @media (max-width: 576px) {
        .service-actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .service-cta {
            width: 100%;
            text-align: center;
        }

        .category-meta {
            width: 100%;
            text-align: left;
        }
    }
</style>
