<?php
$menu = [
  'cs' => [
    'home' => 'Úvod',
    'about' => 'O nás',
    'services' => 'Služby',
    'contact' => 'Kontakt',
    'faq' => 'Často kladené otázky',
    'movies' => 'Videa',
    'offer' => 'Nabídky',
  ],
  'en' => [
    'home' => 'Home',
    'about' => 'About us',
    'services' => 'Services',
    'contact' => 'Contact',
    'faq' => 'FAQ',
    'movies' => 'Videos',
    'offer' => 'Offers',
  ],
  'de' => [
    'home' => 'Startseite',
    'about' => 'Über uns',
    'services' => 'Leistungen',
    'contact' => 'Kontakt',
    'faq' => 'Häufige Fragen',
    'movies' => 'Videos',
    'offer' => 'Angebote',
  ],
  'it' => [
    'home' => 'Home',
    'about' => 'Chi siamo',
    'services' => 'Servizi',
    'contact' => 'Contatto',
    'faq' => 'Domande frequenti',
    'movies' => 'Video',
    'offer' => 'Offerte',
  ]
];

$lang = $_COOKIE['lang'] ?? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$lang = in_array($lang, ['cs', 'en', 'de', 'it']) ? $lang : 'cs';
?>
<nav class="main-menu">
  <ul>
    <li><a href="/index.php"><?= htmlspecialchars($menu[$lang]['home']) ?></a></li>
    <li><a href="/about.php"><?= htmlspecialchars($menu[$lang]['about']) ?></a></li>
    <li><a href="/services.php"><?= htmlspecialchars($menu[$lang]['services']) ?></a></li>
    <li><a href="/contact.php"><?= htmlspecialchars($menu[$lang]['contact']) ?></a></li>
    <li><a href="/faq.php"><?= htmlspecialchars($menu[$lang]['faq']) ?></a></li>
    <li><a href="/videos.php"><?= htmlspecialchars($menu[$lang]['movies']) ?></a></li>
    <li><a href="/offer/preview.php"><?= htmlspecialchars($menu[$lang]['offer']) ?></a></li>
  </ul>
</nav>
