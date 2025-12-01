<?php
/**
 * Local variables.
 *
 * @var string $user_display_name
 */

// Color de marca dinámico desde la configuración
$brandColor = setting('company_color') ?: '#138C73';
?>
<footer id="footer"
        class="footer mt-auto py-2 px-3 border-top text-center text-lg-start"
        style="background:#ffffff;">
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">

        <!-- Marca + versión -->
        <div class="d-flex align-items-center footer-left text-muted small">
            <div class="d-flex align-items-center px-2 py-1 rounded-pill"
                 style="background:rgba(0,0,0,0.03);">
                <img class="me-2" src="<?= base_url('assets/img/logo-16x16.png') ?>" alt="Authaz Systems Logo">
                <span class="fw-semibold">
                    Authaz Systems
                </span>
                <span class="ms-2" style="opacity:0.7;">
                    v<?= e(config('version')) ?>
                </span>
            </div>
        </div>

        <!-- Botón moderno: Ir a la página de reservas -->
        <div class="footer-center">
            <a href="<?= site_url('appointments') ?>"
               class="btn fw-semibold shadow-sm d-inline-flex align-items-center justify-content-center"
               style="
                   background: <?= $brandColor ?>;
                   color: #ffffff;
                   padding: 8px 22px;
                   border-radius: 999px;
                   font-size: 14px;
                   border: none;
               ">
                <i class="fas fa-calendar-alt me-2"></i>
                <?= lang('go_to_booking_page') ?>
            </a>
        </div>

        <!-- Saludo al usuario -->
        <div class="footer-user text-muted small fw-semibold d-flex align-items-center">
            <span class="me-1">👋</span>
            <span><?= lang('hello') . ', ' . e($user_display_name) ?>!</span>
        </div>

        <!-- 
        ===== Idioma (bloque conservado en comentario, por si quieres reactivarlo) =====

        <div class="d-flex align-items-center footer-language">
            <span id="select-language" class="badge bg-secondary text-uppercase py-2 px-3 shadow-sm">
                <i class="fas fa-language me-2"></i>
                <?= ucfirst(config('language')) ?>
            </span>
        </div>
        -->

    </div>
</footer>

<style>
    /* Ajustes generales de tipografía del footer */
    #footer {
        border-top-color: rgba(0, 0, 0, 0.06) !important;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.06);
    }

    #footer .footer-user span {
        white-space: nowrap;
    }

    /* Responsive móvil */
    @media (max-width: 576px) {
        #footer {
            padding: 6px 10px !important;
        }

        #footer .container-fluid {
            gap: 6px;
        }

        .footer-left {
            width: 100%;
            justify-content: center;
        }

        .footer-center {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .footer-center .btn {
            width: 100%;
            max-width: 260px;
            font-size: 13px;
            padding: 7px 18px;
        }

        .footer-user {
            width: 100%;
            justify-content: center;
            font-size: 12px;
        }
    }
</style>
