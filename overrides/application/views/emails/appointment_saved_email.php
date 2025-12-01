<?php
/**
 * Local variables.
 *
 * @var string $subject
 * @var string $message
 * @var array  $appointment
 * @var array  $service
 * @var array  $provider
 * @var array  $customer
 * @var array  $settings
 * @var array  $timezone
 * @var string $appointment_link
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= e($subject) ?> | <?= e($settings['company_name']) ?></title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 25px;
            color: #444;
        }

        .email-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            max-width: 650px;
            margin: auto;
            overflow: hidden;
        }

        /* HEADER SIN LOGO */
        #email-header {
            background-color: <?= setting('company_color') ?: '#000000' ?>;
            padding: 20px;
            text-align: left;
        }

        #email-header span {
            font-size: 22px;
            font-weight: bold;
            color: #ffffff;
        }

        #content {
            padding: 25px;
        }

        h2 {
            color: #222;
            margin-bottom: 12px;
            margin-top: 25px;
            font-size: 20px;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        td.label {
            font-weight: bold;
            padding: 6px 4px;
            width: 140px;
        }

        td {
            padding: 6px 4px;
        }

        /* BOTÓN MISMO COLOR QUE EL HEADER */
        .cta-button {
            background-color: <?= setting('company_color') ?: '#000000' ?>;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }

        /* FOOTER */
        #email-footer {
            padding: 16px;
            text-align: center;
            background:#fafafa;
            border-top:1px solid #e0e0e0;
            font-size:13px;
            color:#777;
        }

        /* Ajuste móvil: reducir márgenes pero mantener botón compacto */
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            #content {
                padding: 18px;
            }
            .cta-button {
                display: inline-block;   /* seguimos dejándolo compacto */
                width: auto;             /* ancho según el texto */
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="email-container">

    <!-- HEADER SIN LOGO -->
    <div id="email-header">
        <span><?= e($settings['company_name']) ?></span>
    </div>

    <!-- CONTENT -->
    <div id="content">

        <h2><?= e($subject) ?></h2>

        <p><?= nl2br(e($message)) ?></p>

        <!-- 🔝 BLOQUE GESTIONAR CITA ARRIBA DEL TODO -->
        <h2>Gestionar cita</h2>
        <p>Puede cambiar o cancelar su cita desde el siguiente botón:</p>

        <p style="text-align:center; margin:20px 0 30px 0;">
            <a href="<?= e($appointment_link) ?>" class="cta-button">
                Gestionar mi cita
            </a>
        </p>

        <!-- INFO EXTRA: DETALLES DE LA CITA -->
        <h2><?= lang('appointment_details_title') ?></h2>
        <table>
            <tr>
                <td class="label"><?= lang('service') ?></td>
                <td><?= e($service['name']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('provider') ?></td>
                <td><?= e($provider['first_name'] . ' ' . $provider['last_name']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('start') ?></td>
                <td><?= format_date_time($appointment['start_datetime']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('end') ?></td>
                <td><?= format_date_time($appointment['end_datetime']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('timezone') ?></td>
                <td><?= format_timezone($timezone) ?></td>
            </tr>

            <?php if (!empty($appointment['status'])): ?>
            <tr>
                <td class="label"><?= lang('status') ?></td>
                <td><?= e($appointment['status']) ?></td>
            </tr>
            <?php endif; ?>

            <tr>
                <td class="label"><?= lang('description') ?></td>
                <td><?= e($service['description']) ?></td>
            </tr>

            <?php if (!empty($appointment['location'])): ?>
            <tr>
                <td class="label"><?= lang('location') ?></td>
                <td><?= e($appointment['location']) ?></td>
            </tr>
            <?php endif; ?>

            <?php if (!empty($appointment['notes'])): ?>
            <tr>
                <td class="label"><?= lang('notes') ?></td>
                <td><?= e($appointment['notes']) ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <h2><?= lang('customer_details_title') ?></h2>
        <table>
            <tr>
                <td class="label"><?= lang('name') ?></td>
                <td><?= e($customer['first_name'] . ' ' . $customer['last_name']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('email') ?></td>
                <td><?= e($customer['email']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('phone_number') ?></td>
                <td><?= e($customer['phone_number']) ?></td>
            </tr>
            <tr>
                <td class="label"><?= lang('address') ?></td>
                <td><?= e($customer['address']) ?></td>
            </tr>
        </table>

    </div>

    <!-- FOOTER -->
    <div id="email-footer">
        <strong><?= e($settings['company_name']) ?></strong><br>
        <span>© <?= date('Y') ?> — Todos los derechos reservados.</span>
    </div>

</div>

</body>
</html>
