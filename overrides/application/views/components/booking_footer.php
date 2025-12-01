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
        border-top: 1px solid rgba(0, 0, 0, 0.04);
        background: linear-gradient(180deg, #f9fafb 0%, #f3f4f6 100%);
        font-size: 0.85rem;
        color: #6b7280;
        padding: 0.85rem 1.25rem;
        border-radius: 0 0 14px 14px;
        display: flex;
        justify-content: flex-end;
    }

    #frame-footer small {
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Botón backend con color de marca (brandColor) */
    #frame-footer .backend-link {
        border-radius: 10px;
        border: none;
        background: var(--brand-color, #35A768);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.5rem 1.2rem;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
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
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.16);
    }

    /* Adaptación a móvil */
    @media (max-width: 768px) {
        #frame-footer {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
            justify-content: center;
        }

        #frame-footer small {
            width: 100%;
            justify-content: center;
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
