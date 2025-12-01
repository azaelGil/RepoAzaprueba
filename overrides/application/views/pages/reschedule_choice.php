<?php
/**
 * Página Authaz Systems: elección de reagendar o cancelar cita
 * Se muestra cuando un cliente entra desde el enlace del correo.
 */

// Color corporativo del tenant
$brandColor = setting('company_color') ?: '#000000';

// Construcción de URL base
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host   = $_SERVER['HTTP_HOST'];
$base   = $scheme . "://" . $host . "/index.php";

// Extraer token
$uri   = $_SERVER['REQUEST_URI'] ?? '';
$parts = explode('/', trim($uri, '/'));
$token = end($parts);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de cita | Authaz Systems</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --brand-color: <?= $brandColor ?>;
            --surface: #ffffff;
            --surface-alt: #f7f9fb;
            --text-main: #0f172a;
            --text-muted: #556173;
            --border-soft: #e5e7eb;
            --shadow-soft: 0 18px 45px rgba(15, 23, 42, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at 18% 20%, rgba(42, 122, 104, 0.08), transparent 28%),
                        radial-gradient(circle at 80% 0%, rgba(42, 122, 104, 0.05), transparent 30%),
                        #eef2f5;
            color: var(--text-main);
        }

        /* ====== SPINNER GLOBAL ====== */
        #loadingSpinner {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999999;
            backdrop-filter: blur(2px);
        }

        .spinner {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 6px solid rgba(15, 23, 42, 0.08);
            border-top-color: var(--brand-color);
            animation: spin 0.85s linear infinite;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.4);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ====== LAYOUT GENERAL ====== */
        .rc-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
        }

        .rc-card {
            background: var(--surface);
            border-radius: 20px;
            box-shadow: var(--shadow-soft);
            padding: 34px 32px;
            width: 100%;
            max-width: 620px;
            position: relative;
            overflow: hidden;
        }

        .rc-card::before {
            content: "";
            position: absolute;
            top: -70px;
            right: -50px;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), transparent 60%), var(--brand-color);
            opacity: 0.12;
            border-radius: 50%;
        }

        .rc-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .rc-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(145deg, var(--brand-color), rgba(255, 255, 255, 0.12));
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 12px 28px rgba(42, 122, 104, 0.35);
        }

        .rc-card-title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .rc-card-subtitle {
            margin: 4px 0 0 0;
            color: var(--text-muted);
            font-size: 0.97rem;
        }

        .rc-highlight {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-alt);
            padding: 10px 14px;
            border-radius: 14px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.92rem;
            margin: 10px 0 22px 0;
            border: 1px solid var(--border-soft);
        }

        .rc-text {
            margin: 0 0 26px 0;
            color: var(--text-muted);
            line-height: 1.6;
            font-size: 1rem;
        }

        .rc-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .rc-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 16px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            border: 1px solid transparent;
            transition: transform 0.12s ease, box-shadow 0.12s ease, opacity 0.2s ease;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
        }

        .rc-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
        }

        .rc-btn:active {
            transform: translateY(0);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.16);
        }

        .rc-btn-primary {
            background: var(--brand-color);
            color: #fff;
            border-color: var(--brand-color);
        }

        .rc-btn-secondary {
            background: #fff;
            color: var(--text-main);
            border-color: var(--border-soft);
        }

        .rc-btn-secondary:hover {
            border-color: var(--brand-color);
        }

        .rc-note {
            margin-top: 18px;
            font-size: 0.9rem;
            color: var(--text-muted);
            text-align: center;
        }

        /* ====== MOBILE (≤ 576px) ====== */
        @media (max-width: 576px) {
            .rc-card {
                padding: 26px 18px;
                border-radius: 16px;
            }

            .rc-card-title {
                font-size: 1.2rem;
            }

            .rc-card-subtitle {
                font-size: 0.92rem;
            }

            .rc-highlight {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            .rc-text {
                font-size: 0.95rem;
            }

            .rc-actions {
                grid-template-columns: 1fr;
            }

            .rc-btn {
                width: 100%;
            }
        }
    </style>

    <script>
        // Mostrar spinner inmediatamente al hacer clic
        function showSpinner() {
            document.getElementById("loadingSpinner").style.display = "flex";
        }
    </script>

</head>

<body>

<!-- CONTENEDOR DEL SPINNER -->
<div id="loadingSpinner">
    <div class="spinner"></div>
</div>

<div class="rc-page-wrapper">
    <div class="rc-card">
        <div class="rc-card-header">
            <div class="rc-card-icon">🗓️</div>
            <div>
                <h1 class="rc-card-title">Gestione su cita</h1>
                <p class="rc-card-subtitle">Seleccione si desea reprogramar o cancelar.</p>
            </div>
        </div>

        <div class="rc-highlight">
            <span>Acción segura</span>
            <span style="font-size: 1.1rem; color: var(--brand-color);">•</span>
            <span>Se conservarán sus datos hasta finalizar</span>
        </div>

        <p class="rc-text">
            Puede reubicar su reserva a la fecha y hora que mejor le encaje o anularla si ya no puede asistir. Esta pantalla está optimizada para móvil y escritorio para que complete el proceso en pocos pasos.
        </p>

        <div class="rc-actions">
            <!-- BOTÓN REAGENDAR -->
            <a
                href="<?= $base ?>/booking/reschedule/<?= $token ?>?mode=reschedule"
                onclick="showSpinner()"
                class="rc-btn rc-btn-primary"
            >
                🕒 Reagendar cita
            </a>

            <!-- BOTÓN CANCELAR -->
            <a
                href="<?= $base ?>/booking/reschedule/<?= $token ?>?mode=cancel"
                onclick="showSpinner()"
                class="rc-btn rc-btn-secondary"
            >
                ❌ Cancelar cita
            </a>
        </div>

        <div class="rc-note">
            Si tiene dudas, contacte con su centro para confirmar cambios o resolver incidencias.
        </div>
    </div>
</div>

</body>
</html>
