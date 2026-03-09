<?php
// --- Jazyková detekce a přepínač ---
$supportedLangs = ['cs', 'en', 'de', 'it'];
$defaultLang = 'cs';

// 1. Zpracuj jazyk z GET a ulož do cookie
if (isset($_GET['lang']) && in_array($_GET['lang'], $supportedLangs)) {
    setcookie('lang', $_GET['lang'], time() + (86400 * 30), "/"); // 30 dní
    $_COOKIE['lang'] = $_GET['lang']; // pro okamžité použití
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?')); // přesměruj bez ?lang=...
    exit;
}

// 2. Urči jazyk
if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $supportedLangs)) {
    $lang = $_COOKIE['lang'];
} else {
    $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
    $lang = in_array($browserLang, $supportedLangs) ? $browserLang : $defaultLang;
}

// --- Výběr náhodného banneru ---
$banners = glob(__DIR__ . '/../assets/img/banner/*.jpg');
$selectedBanner = $banners ? $banners[array_rand($banners)] : '/assets/img/banner/default.jpg';
$selectedBannerRel = str_replace(__DIR__ . '/../', '', $selectedBanner);

// --- Titulek stránky podle jazyka ---
$pageTitles = [
  'cs' => 'Right Done – Nemovitosti u moře',
  'en' => 'Right Done – Sea-side Properties',
  'de' => 'Right Done – Immobilien am Meer',
  'it' => 'Right Done – Case al mare'
];
$pageTitle = $pageTitles[$lang] ?? $pageTitles[$defaultLang];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="icon" href="/assets/img/favicon.png" type="image/png">
  <link rel="stylesheet" href="/assets/css/style.css">
  
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GL465JKLQ2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GL465JKLQ2', {
    'linker': {
      'domains': ['rightdone.eu', 'myscalea.it']
    }
  });
</script>

</head>
<body>

<!-- Přepínač jazyka -->
<form method="get" class="language-switch" style="position:absolute;top:10px;right:10px;z-index:1000">
  <select name="lang" onchange="this.form.submit()">
    <option value="cs" <?= $lang == 'cs' ? 'selected' : '' ?>>🇨🇿 Čeština</option>
    <option value="en" <?= $lang == 'en' ? 'selected' : '' ?>>🇬🇧 English</option>
    <option value="de" <?= $lang == 'de' ? 'selected' : '' ?>>🇩🇪 Deutsch</option>
    <option value="it" <?= $lang == 'it' ? 'selected' : '' ?>>🇮🇹 Italiano</option>
  </select>
</form>

<section class="hero">
  <img src="/<?= htmlspecialchars($selectedBannerRel) ?>" alt="Banner" class="hero-img">
  <div class="hero-logo-top">
    <img src="/assets/img/logo-rightdone-transparent.png" alt="Right Done logo">
  </div>
</section>
