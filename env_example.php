<?php
// dev || test || prod
if (!defined('APP_ENV')) define('APP_ENV', '');

if (!defined('DOCUMENT_ROOT')) define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
if (!defined('SITE_TEMPLATE_PATH')) define('SITE_TEMPLATE_PATH', '');

if (!defined('DB_HOST')) define('DB_HOST', '');
if (!defined('DB_NAME')) define('DB_NAME', '');
if (!defined('DB_USER')) define('DB_USER', '');
if (!defined('DB_PASS')) define('DB_PASS', '');

if (!defined('SECRET_IEX_KEY')) define('SECRET_IEX_KEY', '');
if (!defined('PUBLIC_IEX_KEY')) define('PUBLIC_IEX_KEY', '');