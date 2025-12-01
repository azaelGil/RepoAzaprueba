<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - Configuración persistente Authaz Systems
 * ---------------------------------------------------------------------------- */

class Config {
    // GENERAL SETTINGS
    const BASE_URL      = 'http://192.168.0.126:8080';
    const LANGUAGE      = 'spanish';
    const DEBUG_MODE    = TRUE;

    // DATABASE SETTINGS
    const DB_HOST       = 'db';
    const DB_NAME       = 'ea_main';
    const DB_USERNAME   = 'easyuser_main';
    const DB_PASSWORD   = 'EasyPass_Main_ChangeMe';
    const DB_DRIVER     = 'mysqli';
    const TABLE_PREFIX  = '';

    // GOOGLE CALENDAR (opcional)
    const GOOGLE_SYNC_FEATURE = 'TRUE';
    const GOOGLE_PRODUCT_NAME = 'Authaz Systems';
    const GOOGLE_CLIENT_ID = '946278397-ai90e1fnkk8adqe0lqitohiocc7ctivj.apps.googleusercontent.com';
    const GOOGLE_CLIENT_SECRET = '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';
    const GOOGLE_API_KEY = '';
}

// ---------------------------------------------------------------------------
// API TOKEN (ESTE BLOQUE DEBE IR FUERA DE LA CLASE)
// ---------------------------------------------------------------------------

$config['api_token'] = 'prueba1';
