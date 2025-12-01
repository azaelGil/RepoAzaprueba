<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="ea-success-wrapper" class="ea-success-wrapper">
    <div class="ea-success-card">

        <!-- Icono moderno -->
        <div class="ea-success-icon">
            <div class="ea-success-circle">
                <div class="ea-success-check"></div>
            </div>
        </div>

        <!-- Título -->
        <h1 class="ea-success-title">
            <?= lang('appointment_registered'); ?>
        </h1>

        <!-- Textos -->
        <p class="ea-success-text">
            Se le ha enviado un correo electrónico con los detalles de la cita.
        </p>

        <p class="ea-success-subtext">
            Si en unos minutos no recibe el correo, revise su carpeta de correo no deseado
            o póngase en contacto con nosotros.
        </p>

        <!-- Botones -->
        <div class="ea-success-actions">
            <a href="<?= site_url('appointments'); ?>"
               class="ea-success-btn ea-success-btn-primary">
                <?= lang('go_to_booking_page'); ?>
            </a>

            <?php if (isset($google_sync_link) && ! empty($google_sync_link)) : ?>
                <a href="<?= $google_sync_link; ?>"
                   class="ea-success-btn ea-success-btn-secondary">
                    <?= lang('add_to_google_calendar'); ?>
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
    /* ====== Layout general ====== */
    .ea-success-wrapper {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .ea-success-card {
        width: 100%;
        max-width: 720px;
        background: #ffffff;
        border-radius: 1.5rem;
        padding: 2.5rem 2rem;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
        text-align: center;
    }

    /* ====== Icono moderno ====== */
    .ea-success-icon {
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: center;
    }

    .ea-success-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #6ee7b7, #22c55e);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 32px rgba(34, 197, 94, 0.5);
    }

    .ea-success-check {
        width: 34px;
        height: 20px;
        border-bottom: 4px solid #ffffff;
        border-left: 4px solid #ffffff;
        transform: rotate(-45deg) translateY(-2px);
        border-radius: 2px;
    }

    /* ====== Tipografía ====== */
    .ea-success-title {
        font-size: 1.7rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.75rem;
    }

    .ea-success-text {
        font-size: 1rem;
        color: #1f2933;
        margin-bottom: 0.35rem;
    }

    .ea-success-subtext {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 1.5rem;
    }

    /* ====== Botones propios (sin depender de .btn de Bootstrap) ====== */
    .ea-success-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
        justify-content: center;
    }

    .ea-success-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.65rem 1.7rem;
        border-radius: 999px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease,
                    box-shadow 0.2s ease, transform 0.1s ease;
    }

    .ea-success-btn-primary {
        background: #2a7a68; /* Authaz verde */
        color: #ffffff;
        box-shadow: 0 10px 28px rgba(42, 122, 104, 0.55);
        border: none;
    }

    .ea-success-btn-primary:hover {
        background: #256a5b;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 14px 36px rgba(42, 122, 104, 0.6);
    }

    .ea-success-btn-secondary {
        background: #ffffff;
        color: #111827;
        border: 1px solid #d1d5db;
    }

    .ea-success-btn-secondary:hover {
        background: #f3f4f6;
        color: #111827;
    }

    /* ====== Responsive ====== */
    @media (min-width: 576px) {
        .ea-success-card {
            padding: 2.75rem 2.5rem;
        }

        .ea-success-actions {
            flex-direction: row;
        }
    }

    @media (max-width: 575.98px) {
        .ea-success-card {
            padding: 2.1rem 1.4rem;
            border-radius: 1.25rem;
        }

        .ea-success-title {
            font-size: 1.45rem;
        }

        .ea-success-text {
            font-size: 0.96rem;
        }

        .ea-success-subtext {
            font-size: 0.86rem;
        }
    }
</style>
