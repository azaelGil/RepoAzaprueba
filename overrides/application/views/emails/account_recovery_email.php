<?php
/**
 * Local variables.
 *
 * @var string $subject
 * @var string $message
 * @var array $settings
 */
?>
<html lang="en">
<head>
    <title><?= $subject ?> | Authaz Systems</title>
</head>
<body style="font: 13px arial, helvetica, tahoma;">

<div class="email-container" style="width: 650px; border: 1px solid #eee; margin: 30px auto;">
    <div id="header" style="background-color: #429a82; height: 45px; padding: 10px 15px;">
        <strong id="logo" style="color: white; font-size: 20px; margin-top: 10px; display: inline-block">
            <?= e($settings['company_name']) ?>
        </strong>
    </div>

    <div id="content" style="padding: 10px 15px; min-height: 400px">
        <h2>
            <?= $subject ?>
        </h2>
        <p>
            <?= $message ?>
        </p>
    </div>

    <div id="footer" style="
    padding:15px;
    text-align:center;
    border-top:1px solid #EEE;
    background:#FAFAFA;
    font-size:13px;
    color:#777;">
    <strong><?= e($settings['company_name']) ?></strong><br>
    <span style="color:#aaa;"><?= date('Y') ?> Authaz Systems — Todos los derechos reservados.</span>
</div>

</div>

</body>
</html>
