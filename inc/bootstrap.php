<?php
declare(strict_types=1);

// Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load local configuration
$config = require __DIR__ . '/config.local.php';

// Session management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Language detection
$supportedLangs = ['cs', 'en', 'de', 'it'];
$defaultLang = 'cs';

if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLangs)) {
    setcookie('lang', $_GET['lang'], time() + (86400 * 30), "/");
    $_COOKIE['lang'] = $_GET['lang'];
    // Redirection should be handled in the entry script if needed
}

$langCode = $_COOKIE['lang'] ?? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
$lang = in_array($langCode, $supportedLangs) ? $langCode : $defaultLang;
define('LANG', $lang);

// Include common functions
require_once __DIR__ . '/functions.php';

// Database connection
try {
    $dsn = sprintf(
        "mysql:host=%s;dbname=%s;charset=utf8mb4",
        $config['db']['host'],
        $config['db']['dbname']
    );
    $pdo = new PDO($dsn, $config['db']['username'], $config['db']['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Database connection error.");
}
