<?php
/**
 * Local variables.
 *
 * @var array $appointment
 * @var array $service
 * @var array $provider
 * @var array $customer
 * @var array $settings
 * @var array $timezone
 * @var string $reason
 */

// Color corporativo del tenant (fallback a negro)
$brandColor = setting('company_color') && setting('company_color') !== '#ffffff'
    ? setting('company_color')
    : '#000000';

// Nombre de la empresa
$companyName = e($settings['company_name']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= lang('appointment_cancelled_title') ?> | <?= $companyName ?></title>
</head>

<body style="margin:0;padding:25px;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;color:#333;">

<div style="max-width:650px;margin:auto;background:#ffffff;border-radius:12px;
            box-shadow:0 6px 20px rgba(0,0,0,0.08);overflow:hidden;">

    <!-- HEADER (sin logo, solo nombre como el saved) -->
    <div style="background:<?= $brandColor ?>;padding:18px 22px;text-align:left;">
        <span style="font-size:20px;font-weight:bold;color:#ffffff;"><?= $companyName ?></span>
    </div>

    <!-- CONTENT -->
    <div style="padding:28px;">

        <!-- TÍTULO PRINCIPAL -->
        <h2 style="color:#000;font-size:22px;margin-top:10px;margin-bottom:10px;">
            <?= lang('appointment_cancelled_title') ?>
        </h2>

        <!-- SUBTÍTULO -->
        <p style="font-size:15px;color:#555;margin-bottom:25px;">
            <?= lang('appointment_removed_from_schedule') ?>
        </p>

        <!-- SECCIÓN: DETALLES DE LA CITA -->
        <h3 style="color:#000;margin-top:25px;margin-bottom:10px;font-size:18px;">
            <?= lang('appointment_details_title') ?>
        </h3>

        <table width="100%" cellspacing="0" cellpadding="6" style="margin-bottom:20px;font-size:14px;">
            <tr><td style="font-weight:bold;width:150px;"><?= lang('service') ?></td><td><?= e($service['name']) ?></td></tr>
            <tr><td style="font-weight:bold;"><?= lang('provider') ?></td><td><?= e($provider['first_name'].' '.$provider['last_name']) ?></td></tr>
            <tr><td style="font-weight:bold;"><?= lang('start') ?></td><td><?= format_date_time($appointment['start_datetime']) ?></td></tr>
            <tr><td style="font-weight:bold;"><?= lang('end') ?></td><td><?= format_date_time($appointment['end_datetime']) ?></td></tr>
            <tr><td style="font-weight:bold;"><?= lang('timezone') ?></td><td><?= format_timezone($timezone) ?></td></tr>

            <?php if (!empty($appointment['status'])): ?>
            <tr><td style="font-weight:bold;"><?= lang('status') ?></td><td><?= e($appointment['status']) ?></td></tr>
            <?php endif; ?>

            <tr><td style="font-weight:bold;"><?= lang('description') ?></td><td><?= e($service['description']) ?></td></tr>

            <?php if (!empty($appointment['location'])): ?>
            <tr><td style="font-weight:bold;"><?= lang('location') ?></td><td><?= e($appointment['location']) ?></td></tr>
            <?php endif; ?>

            <?php if (!empty($appointment['notes'])): ?>
            <tr><td style="font-weight:bold;"><?= lang('notes') ?></td><td><?= e($appointment['notes']) ?></td></tr>
            <?php endif; ?>
        </table>

        <!-- SECCIÓN: DETALLES DEL CLIENTE (igual estilo que saved) -->
        <h3 style="color:#000;margin-top:25px;margin-bottom:10px;font-size:18px;">
            <?= lang('customer_details_title') ?>
        </h3>

        <table width="100%" cellspacing="0" cellpadding="6" style="margin-bottom:20px;font-size:14px;">
            <tr>
                <td style="font-weight:bold;width:150px;"><?= lang('name') ?></td>
                <td><?= e($customer['first_name'].' '.$customer['last_name']) ?></td>
            </tr>
            <tr>
                <td style="font-weight:bold;"><?= lang('email') ?></td>
                <td><?= e($customer['email']) ?></td>
            </tr>
            <tr>
                <td style="font-weight:bold;"><?= lang('phone_number') ?></td>
                <td><?= e($customer['phone_number']) ?></td>
            </tr>
            <tr>
                <td style="font-weight:bold;"><?= lang('address') ?></td>
                <td><?= e($customer['address']) ?></td>
            </tr>
        </table>

        <!-- SECCIÓN: RAZÓN -->
        <h3 style="color:#000;margin-top:25px;margin-bottom:10px;font-size:18px;">
            <?= lang('reason') ?>
        </h3>

        <p style="font-size:14px;color:#555;margin-bottom:25px;">
            <?= e($reason) ?>
        </p>

    </div>

    <!-- FOOTER -->
    <div style="background:#fafafa;border-top:1px solid #e0e0e0;padding:18px;text-align:center;color:#777;font-size:13px;">
        <strong><?= $companyName ?></strong><br>
        <span><?= date('Y') ?> — Todos los derechos reservados.</span>
    </div>

</div>

</body>
</html>
