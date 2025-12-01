<?php
/**
 * Override Authaz:
 * Expone el color de empresa como variable CSS --brand-color
 * para que todo el tema moderno lo use.
 *
 * @var string $company_color
 */

$color = $company_color ?: '#35A768';

/* Normalizamos un poco para evitar valores raros */
if (!preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $color)) {
    $color = '#35A768';
}
?>
<style>
    :root {
        /* Color principal de TODO (header, botones, etc.) */
        --brand-color: <?= $color ?>;
    }
</style>
