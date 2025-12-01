<?php
/**
 * Plantilla correo confirmación de cita - Authaz Systems
 * CTA arriba para evitar que Gmail lo oculte al plegar contenido.
 */

$brandColor = setting('company_color') ?: '#35A768';
$year       = date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            color: #111827;
        }

        .wrap {
            padding: 16px 8px;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 14px;
            padding: 18px 16px 16px 16px;
        }

        h2 {
            margin: 0 0 6px 0;
            font-size: 20px;
            font-weight: 600;
            color: <?= $brandColor ?>;
        }

        p {
            margin: 6px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        h3 {
            margin: 16px 0 6px 0;
            font-size: 15px;
        }

        .btn {
            display: inline-block;
            padding: 11px 20px;
            background-color: <?= $brandColor ?>;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 999px;
            font-size: 14px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 14px 0;
            font-size: 14px;
        }

        .details-table th,
        .details-table td {
            padding: 4px 0;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .details-table th {
            width: 38%;
            color: #6b7280;
            font-weight: 500;
        }

        .footer {
            margin-top: 14px;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }

        @media (max-width: 480px) {
            .card {
                padding: 14px 12px;
            }
            h2 { font-size: 18px; }
            h3 { font-size: 14px; }
            .btn {
                display: block;
                width: 100%;
                text-align: center;
                padding: 12px 0;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">

        <h2><?= $company_name ?></h2>

        <p><strong>Su cita ha sido agendada correctamente.</strong></p>
        <p>Puede gestionar su cita (cambiarla o cancelarla) desde el siguiente botón:</p>

        <!-- CTA ARRIBA DEL TODO -->
        <p style="text-align:center; margin: 14px 0 12px 0;">
            <a href="<?= $appointment_link ?>" class="btn">Gestionar mi cita</a>
        </p>

        <!-- Pequeño resumen por si recorta el resto -->
        <p style="font-size:13px; color:#6b7280; margin-bottom: 12px;">
            Servicio: <?= $service ?> ·
            <?= $start_datetime ?> (<?= $timezone ?>)
        </p>

        <!-- A partir de aquí, si Gmail pliega algo, será lo menos crítico -->
        <h3>Detalles de la cita</h3>
        <table class="details-table">
            <tr>
                <th>Servicio</th>
                <td><?= $service ?></td>
            </tr>
            <tr>
                <th>Proveedor</th>
                <td><?= $provider ?></td>
            </tr>
            <tr>
                <th>Inicio</th>
                <td><?= $start_datetime ?></td>
            </tr>
            <tr>
                <th>Final</th>
                <td><?= $end_datetime ?></td>
            </tr>
            <tr>
                <th>Zona horaria</th>
                <td><?= $timezone ?></td>
            </tr>
            <tr>
                <th>Estado</th>
                <td><?= $status ?></td>
            </tr>
        </table>

        <div class="footer">
            © <?= $year ?> <?= $company_name ?> – Todos los derechos reservados.
        </div>
    </div>
</div>
</body>
</html>
