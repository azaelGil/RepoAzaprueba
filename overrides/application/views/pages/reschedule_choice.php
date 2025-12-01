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
        /* ====== SPINNER GLOBAL ====== */
        #loadingSpinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999999;
        }

        .spinner {
            border: 6px solid #ddd;
            border-top: 6px solid <?= $brandColor ?>;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            animation: spin 0.9s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ====== LAYOUT GENERAL ====== */
        body {
            background:#f6f8f9;
            font-family:Arial, sans-serif;
            margin:0;
        }

        .rc-page-wrapper {
            min-height: 100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:16px;
            box-sizing:border-box;
        }

        .rc-card {
            background:#fff;
            border:1px solid #e0e0e0;
            border-radius:16px;
            box-shadow:0 4px 14px rgba(0,0,0,0.1);
            padding:40px 50px;
            text-align:center;
            max-width:480px;        /* algo más estrecha por defecto */
            width:100%;
            box-sizing:border-box;
        }

        .rc-card h2 {
            color:#1b1b1b;
            margin-bottom:20px;
            font-size:24px;
        }

        .rc-card p {
            color:#444;
            margin-bottom:35px;
            font-size:15px;
            line-height:1.5;
        }

        .rc-actions {
            display:flex;
            justify-content:center;
            gap:25px;
            flex-wrap:wrap;
        }

        /* ====== MOBILE (≤ 576px) ====== */
        @media (max-width: 576px) {
            .rc-page-wrapper {
                padding:12px 8px;
            }

            .rc-card {
                padding:24px 16px;
                border-radius:12px;
                max-width:100%;          /* nunca más ancha que la pantalla */
            }

            .rc-card h2 {
                font-size:20px;
                margin-bottom:16px;
            }

            .rc-card p {
                font-size:14px;
                margin-bottom:24px;
            }

            /* Botones en columna ocupando todo el ancho */
            .rc-actions {
                display:block;
                gap:0;
            }

            .rc-actions a {
                display:block !important;
                width:100% !important;
                min-width:0 !important;
                box-sizing:border-box;
                margin:0 0 10px 0;
            }

            .rc-actions a:last-child {
                margin-bottom:0;
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

        <h2>
            ¿Qué desea hacer con su cita?
        </h2>

        <p>
            Puede reagendarla a otra hora o cancelarla definitivamente.
        </p>

        <div class="rc-actions">

            <!-- BOTÓN REAGENDAR -->
            <a href="<?= $base ?>/booking/reschedule/<?= $token ?>?mode=reschedule"
               onclick="showSpinner()"
               style="background-color:<?= $brandColor ?>;
                      color:#fff;
                      padding:14px 28px;
                      border-radius:8px;
                      text-decoration:none;
                      font-weight:bold;
                      font-size:15px;
                      min-width:160px;
                      transition:0.3s;
                      display:inline-block;
                      text-align:center;">
                🕒 Reagendar cita
            </a>

            <!-- BOTÓN CANCELAR -->
            <a href="<?= $base ?>/booking/reschedule/<?= $token ?>?mode=cancel"
               onclick="showSpinner()"
               style="background-color:<?= $brandColor ?>;
                      color:#fff;
                      padding:14px 28px;
                      border-radius:8px;
                      text-decoration:none;
                      font-weight:bold;
                      font-size:15px;
                      min-width:160px;
                      transition:0.3s;
                      display:inline-block;
                      text-align:center;">
                ❌ Cancelar cita
            </a>

        </div>

    </div>

</div>

</body>
</html>
