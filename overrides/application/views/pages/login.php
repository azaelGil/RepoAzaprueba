<?php
extend('layouts/account_layout');

/**
 * Color de marca del login
 *  - Se toma de la configuración de la instancia (company_color).
 *  - Si no está definido, usa #35A768 como fallback.
 */
if (function_exists('setting')) {
    $brandColor = setting('company_color', '#35A768');
} else {
    $brandColor = '#35A768';
}
?>

<?php section('content'); ?>

<style>
    /* ============================
     * Pantalla de login Authaz
     * ============================ */

    .authaz-login-shell {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1.5rem;
        background: transparent;
    }

    .authaz-login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 1.25rem;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.16);
        padding: 2.3rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .authaz-login-accent {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    .authaz-login-accent::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 160px;
        height: 160px;
        border-radius: 999px;
        background:
            radial-gradient(
                circle at 30% 30%,
                rgba(255, 255, 255, 0.9),
                transparent 55%
            ),
            <?= $brandColor ?>;
        box-shadow: 0 0 0 40px rgba(148, 163, 184, 0.08);
        opacity: 0.40;
    }

    @media (max-width: 576px) {
        .authaz-login-card {
            padding: 1.9rem 1.4rem;
            border-radius: 1rem;
        }

        .authaz-login-shell {
            padding: 1.8rem 0;
        }
    }

    .authaz-login-header {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        margin-bottom: 1.4rem;
        position: relative;
        z-index: 1;
    }

    .authaz-login-icon {
        width: 46px;
        height: 46px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: <?= $brandColor ?>;
        color: #ffffff;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.35);
        flex-shrink: 0;
    }

    .authaz-login-title {
        font-weight: 700;
        font-size: 1.35rem;
        line-height: 1.2;
        color: #111827;
    }

    .authaz-login-subtitle {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .authaz-login-separator {
        height: 1px;
        width: 100%;
        background: linear-gradient(
            to right,
            <?= $brandColor ?>,
            rgba(243, 244, 246, 0.1)
        );
        opacity: 0.55;
        margin: 1.1rem 0 1.4rem 0;
    }

    .authaz-login-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #374151;
        margin-bottom: 0.25rem;
    }

    .authaz-login-input {
        border-radius: 999px !important;
        padding: 0.55rem 1rem;
        font-size: 0.95rem;
        border: 1px solid #d1d5db;
    }

    .authaz-login-input:focus {
        border-color: <?= $brandColor ?>;
        box-shadow: 0 0 0 0.11rem rgba(0, 0, 0, 0.10);
        outline: none;
    }

    .authaz-login-alert {
        font-size: 0.85rem;
        border-radius: 0.9rem;
        padding: 0.6rem 0.9rem;
    }

    /* Botón de login con color de marca */
    .authaz-login-btn {
        border-radius: 999px;
        padding: 0.55rem 1.9rem;
        font-weight: 600;
        border: none;
        background: <?= $brandColor ?>;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.20);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        transition:
            transform 0.08s ease-out,
            box-shadow 0.08s ease-out,
            filter 0.12s ease-out;
    }

    .authaz-login-btn:hover {
        opacity: 0.96;
        box-shadow: 0 10px 26px rgba(0, 0, 0, 0.23);
        transform: translateY(-1px);
    }

    .authaz-login-btn:active {
        transform: translateY(0);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
    }

    .authaz-login-footer {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 1.25rem;
        text-align: center;
    }

    .authaz-login-forgot {
        font-size: 0.85rem;
        text-decoration: none;
        color: <?= $brandColor ?>;
    }

    .authaz-login-forgot:hover {
        text-decoration: underline;
    }
</style>

<div class="authaz-login-shell">
    <div class="authaz-login-card">
        <div class="authaz-login-accent"></div>

        <!-- Cabecera -->
        <div class="authaz-login-header">
            <div class="authaz-login-icon">
                <i class="fas fa-lock"></i>
            </div>

            <div>
                <div class="authaz-login-title">
                    Área privada Authaz Systems
                </div>
                <div class="authaz-login-subtitle">
                    Accede a tu panel de gestión interna.
                </div>
            </div>
        </div>

        <div class="authaz-login-separator"></div>

        <!-- Alertas -->
        <div class="alert d-none authaz-login-alert mb-3"></div>

        <!-- Formulario -->
        <form id="login-form" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="authaz-login-label">
                    <?= lang('username') ?>
                </label>
                <input
                    type="text"
                    id="username"
                    placeholder="<?= lang('enter_username_here') ?>"
                    class="form-control authaz-login-input"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="password" class="authaz-login-label">
                    <?= lang('password') ?>
                </label>
                <input
                    type="password"
                    id="password"
                    placeholder="<?= lang('enter_password_here') ?>"
                    class="form-control authaz-login-input"
                    required
                />
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-1">
                <a href="<?= site_url('recovery') ?>" class="authaz-login-forgot">
                    <?= lang('forgot_your_password') ?>
                </a>

                <button type="submit" id="login" class="authaz-login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span><?= lang('login') ?></span>
                </button>
            </div>

            <div class="authaz-login-footer">
                <?= lang('page_title') ?> · <?= vars('company_name') ?>
            </div>
        </form>
    </div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/fontawesome.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/@fortawesome-fontawesome-free/solid.min.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/login_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/pages/login.js') ?>"></script>

<?php end_section('scripts'); ?>
