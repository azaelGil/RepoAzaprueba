<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Color de marca configurable (fallback al verde Authaz) */
$brandColor = setting('company_color') ?: '#2a7a68';
?>

<?php extend('layouts/message_layout'); ?>

<?php section('content'); ?>

<div id="ea-confirmation-page" class="ea-confirmation-wrapper">
    <div class="ea-confirmation-card mx-auto">

        <!-- Icono principal de éxito -->
        <div class="ea-confirmation-icon mb-3">
            <div class="ea-confirmation-circle">
                <svg class="ea-confirmation-check-svg" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 12.5 10 16 18 8" />
                </svg>
            </div>
        </div>

        <!-- Título -->
        <h4 class="ea-confirmation-title mb-3">
            <?= lang('appointment_registered') ?>
        </h4>

        <p class="ea-confirmation-text mb-1">
            <?= lang('appointment_details_was_sent_to_you') ?>
        </p>

        <p class="ea-confirmation-subtext mb-4">
            <?= lang('check_spam_folder') ?>
        </p>

        <!-- Botones -->
        <div class="ea-confirmation-actions">
            <a href="<?= site_url() ?>" class="ea-btn ea-btn-primary">
                <i class="fas fa-calendar-alt me-2"></i>
                <?= lang('go_to_booking_page') ?>
            </a>

            <?php if (!empty(vars('add_to_google_url'))) : ?>
                <a href="<?= vars('add_to_google_url') ?>" id="add-to-google-calendar"
                   class="ea-btn ea-btn-secondary" target="_blank" rel="noopener">
                    <i class="fas fa-plus me-2"></i>
                    <?= lang('add_to_google_calendar') ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* ====== Layout general (desktop + móviles) ====== */
    #ea-confirmation-page.ea-confirmation-wrapper {
        min-height: calc(100vh - 80px); /* se adapta al alto de pantalla */
        padding: 1.5rem 0.9rem 2.1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
    }

    .ea-confirmation-card {
        width: 100%;
        max-width: 800px;
        background: #ffffff;
        border-radius: 1.5rem;
        padding: 2.3rem 2rem;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.16);
        text-align: center;
    }

    /* ====== Icono principal (tick protagonista pero limpio) ====== */
    .ea-confirmation-icon {
        display: flex;
        justify-content: center;
    }

    .ea-confirmation-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid <?= $brandColor ?>;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow:
            0 0 0 6px rgba(148, 210, 189, 0.35),
            0 12px 26px rgba(15, 23, 42, 0.12);
    }

    .ea-confirmation-check-svg {
        width: 28px;
        height: 28px;
        fill: none;
        stroke: <?= $brandColor ?>;
        stroke-width: 2.4;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* ====== Tipografía ====== */
    .ea-confirmation-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
    }

    .ea-confirmation-text {
        font-size: 1rem;
        color: #1f2933;
    }

    .ea-confirmation-subtext {
        font-size: 0.9rem;
        color: #6b7280;
    }

    /* ====== Botones ====== */
    .ea-confirmation-actions {
        margin-top: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
        justify-content: center;
    }

    .ea-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.65rem 1.9rem;
        border-radius: 999px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease,
                    box-shadow 0.2s ease, transform 0.1s ease;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .ea-btn-primary {
        background: <?= $brandColor ?>;
        color: #ffffff;
        box-shadow: 0 10px 28px rgba(42, 122, 104, 0.55);
    }

    .ea-btn-primary:hover {
        filter: brightness(0.94);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .ea-btn-secondary {
        background: #ffffff;
        color: #111827;
        border-color: #d1d5db;
    }

    .ea-btn-secondary:hover {
        background: #f3f4f6;
        color: #111827;
    }

    /* ====== Breakpoints para TODOS los móviles ====== */

    /* Tablets / móviles grandes */
    @media (max-width: 768px) {
        .ea-confirmation-card {
            max-width: 520px;
            padding: 2.1rem 1.6rem;
        }

        .ea-confirmation-title {
            font-size: 1.5rem;
        }
    }

    /* Móviles estándar (≤ 576px) */
    @media (max-width: 575.98px) {
        #ea-confirmation-page.ea-confirmation-wrapper {
            padding: 1.25rem 0.75rem 1.8rem;
            align-items: flex-start; /* la tarjeta sube un poco y se evita hueco raro abajo */
        }

        .ea-confirmation-card {
            padding: 2rem 1.4rem;
            border-radius: 1.25rem;
            max-width: 100%;
        }

        .ea-confirmation-title {
            font-size: 1.4rem;
        }

        .ea-confirmation-text {
            font-size: 0.95rem;
        }

        .ea-confirmation-subtext {
            font-size: 0.84rem;
        }

        .ea-btn {
            width: 100%; /* botones a todo el ancho en móvil */
        }

        .ea-confirmation-circle {
            width: 60px;
            height: 60px;
        }

        .ea-confirmation-check-svg {
            width: 26px;
            height: 26px;
        }
    }

    /* Móviles muy pequeños (≤ 400px de ancho) */
    @media (max-width: 400px) {
        #ea-confirmation-page.ea-confirmation-wrapper {
            padding: 1rem 0.6rem 1.5rem;
        }

        .ea-confirmation-card {
            padding: 1.8rem 1.2rem;
        }

        .ea-confirmation-title {
            font-size: 1.3rem;
        }

        .ea-confirmation-text {
            font-size: 0.92rem;
        }

        .ea-confirmation-subtext {
            font-size: 0.8rem;
        }

        .ea-confirmation-circle {
            width: 54px;
            height: 54px;
        }

        .ea-confirmation-check-svg {
            width: 22px;
            height: 22px;
        }
    }
</style>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<?php component('google_analytics_script', ['google_analytics_code' => vars('google_analytics_code')]); ?>
<?php component('matomo_analytics_script', [
    'matomo_analytics_url' => vars('matomo_analytics_url'),
    'matomo_analytics_site_id' => vars('matomo_analytics_site_id'),
]); ?>

<?php end_section('scripts'); ?>
