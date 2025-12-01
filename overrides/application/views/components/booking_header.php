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

<div id="header" class="booking-header" style="--brand-color: <?= $brandColor ?>;">
    <div class="booking-header-inner">
        <div class="booking-brand">
            <div class="booking-logo-wrap">
                <img src="<?= vars('company_logo') ?: base_url('assets/img/logo.png') ?>"
                     alt="logo"
                     id="company-logo"
                     class="booking-logo">
            </div>
            <div class="booking-title-group">
                <span class="booking-company"><?= e($company_name) ?></span>
                <div class="booking-meta">
                    <span class="display-selected-service booking-pill invisible">
                        <?= lang('service') ?>
                    </span>
                    <span class="display-selected-provider booking-pill invisible">
                        <?= lang('provider') ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="booking-steps" id="steps">
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
    .booking-header {
        background: linear-gradient(90deg, rgba(0,0,0,0.18), rgba(0,0,0,0.05)), var(--brand-color);
        border-radius: 14px;
        padding: 14px 16px;
        color: #fff;
        margin-bottom: 18px;
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.12);
    }

    .booking-header-inner {
        display: flex;
        align-items: center;
        gap: 16px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .booking-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 220px;
    }

    .booking-logo-wrap {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        display: grid;
        place-items: center;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.1);
    }

    .booking-logo {
        height: 30px;
        width: auto;
        max-width: 120px;
    }

    .booking-title-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .booking-company {
        font-weight: 700;
        font-size: 1.05rem;
        line-height: 1.2;
    }

    .booking-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
    }

    .booking-pill {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 4px 9px;
        border-radius: 999px;
        line-height: 1.2;
    }

    .booking-steps {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 6px 10px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.1);
        flex-wrap: nowrap;
    }

    .book-step {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 34px !important;
        height: 34px !important;
        color: #fff !important;
        font-weight: 700 !important;
        border-radius: 10px !important;
        transition: transform 0.2s ease, background-color 0.25s ease !important;
        position: relative !important;
        background: rgba(255,255,255,0.08);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.15);
    }

    .book-step strong {
        display: none !important;
    }

    .book-step::after {
        content: attr(data-visual-step);
        font-size: 0.95rem;
        font-weight: 700;
    }

    #steps .book-step:last-child {
        margin-left: 0 !important;
    }

    .book-step:hover {
        background-color: rgba(255,255,255,0.18) !important;
        transform: translateY(-1px);
    }

    .book-step.active-step {
        background-color: rgba(255,255,255,0.22) !important;
        color: #fff !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.18);
    }

    @media (max-width: 768px) {
        .booking-header {
            padding: 14px;
        }

        .booking-header-inner {
            gap: 12px;
        }

        .booking-brand {
            width: 100%;
        }

        .booking-steps {
            width: 100%;
            justify-content: center;
            gap: 8px;
        }

        .book-step {
            width: 32px !important;
            height: 32px !important;
        }
    }
</style>
