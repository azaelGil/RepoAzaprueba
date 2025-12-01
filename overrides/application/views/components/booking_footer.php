<?php
/**
 * Local variables.
 *
 * @var bool $display_login_button
 */
?>

<style>
    /* ===== Footer reserva Authaz ===== */
    #frame-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        background: #f9fafb;
        font-size: 0.85rem;
        color: #6b7280;
    }

    #frame-footer small {
        color: #6b7280;
    }

    /* Botón backend con color de marca (brandColor) */
    #frame-footer .backend-link {
        border-radius: 999px;
        border: none;
        background: var(--brand-color, #35A768); /* variable de marca */
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.4rem 1.2rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
    }

    #frame-footer .backend-link i {
        margin-right: 0.35rem;
    }

    #frame-footer .backend-link:hover {
        opacity: 0.96;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    /* Adaptación a móvil */
    @media (max-width: 768px) {
        #frame-footer {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }

        #frame-footer small {
            width: 100%;
            justify-content: flex-end;
        }

        #frame-footer .backend-link {
            width: 100%;
            justify-content: center;
            margin-left: 0;
        }
    }
</style>

<div id="frame-footer" class="text-end pe-3 py-2">
    <small class="d-inline-flex align-items-center gap-3 flex-wrap">

        <!--
        Bloque original de selector de idioma (OCULTO).
        Si quieres volver a mostrarlo, elimina estos comentarios.

        <span id="select-language" class="badge bg-secondary">
            <i class="fas fa-language me-2"></i>
            <?= ucfirst(config('language')) ?>
        </span>
        -->

        <?php if ($display_login_button): ?>
            <a class="backend-link shadow-sm"
               href="<?= session('user_id') ? site_url('calendar') : site_url('login') ?>">
                <i class="fas fa-sign-in-alt me-2"></i>
                <?= session('user_id') ? lang('backend_section') : lang('login') ?>
            </a>
        <?php endif; ?>

    </small>
</div>
