<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Configuración de correo para Authaz Systems (segura con variables de entorno)
 */

$config['useragent']   = 'Authaz Systems';
$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';
$config['smtp_user']   = getenv('SMTP_USER');  // variable de entorno
$config['smtp_pass']   = getenv('SMTP_PASS');  // variable de entorno
$config['smtp_port']   = 587;
$config['smtp_crypto'] = 'tls';
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['crlf']        = "\r\n";
$config['wordwrap']    = TRUE;

// Remitente por defecto
$config['from_name']    = 'Authaz Systems';
$config['from_address'] = getenv('SMTP_USER');
$config['reply_to']     = getenv('SMTP_USER');

