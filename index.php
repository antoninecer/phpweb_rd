<?php
require_once __DIR__ . '/inc/connect.php';
session_start();
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';

$langCode = $_COOKIE['lang'] ?? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$lang = in_array($langCode, ['cs', 'en', 'de', 'it']) ? $langCode : 'cs';

$titles = [
  'cs' => 'Bydlení v Itálii u moře dostupné pro každého 🇮🇹',
  'en' => 'Affordable seaside living in Italy for everyone 🇮🇹',
  'de' => 'Bezahlbares Wohnen am Meer in Italien für alle 🇮🇹',
  'it' => 'Vivere al mare in Italia accessibile a tutti 🇮🇹',
];

$translations = [
  'cs' => '<p>Chcete investovat do nemovitosti u moře? Nabízíme byty v krásném italském městě Scalea – za ceny, které vás překvapí.</p>
<ul>
  <li>Byty již od 499 EUR za m²</li>
  <li>Možnost osobní prohlídky i online prezentace</li>
  <li>Kompletní právní servis a pomoc s převodem</li>
</ul>',

  'en' => '<p>Looking to invest in a seaside property? We offer apartments in the beautiful Italian town of Scalea – at prices that will surprise you.</p>
<ul>
  <li>Apartments from just 499 EUR/m²</li>
  <li>Option for personal viewing or online tour</li>
  <li>Full legal support and transfer assistance</li>
</ul>',

  'de' => '<p>Möchten Sie in eine Immobilie am Meer investieren? Wir bieten Wohnungen in der schönen italienischen Stadt Scalea – zu erstaunlich günstigen Preisen.</p>
<ul>
  <li>Wohnungen ab 499 EUR/m²</li>
  <li>Persönliche Besichtigung oder Online-Führung möglich</li>
  <li>Kompletter Rechtsservice und Unterstützung beim Eigentumsübergang</li>
</ul>',

  'it' => '<p>Vuoi investire in una proprietà al mare? Offriamo appartamenti nella bellissima città italiana di Scalea – a prezzi sorprendenti.</p>
<ul>
  <li>Appartamenti da soli 499 EUR/m²</li>
  <li>Visita personale o tour online disponibili</li>
  <li>Servizio legale completo e assistenza al trasferimento</li>
</ul>'
];

$travelInfo = [
  'cs' => '<div style="margin-top: 30px; background: #f8f8f8; padding: 20px; border-radius: 10px;">
  <h3>Jak se dostat do Scalea ✈️🚆</h3>
  <ul>
    <li><strong>Letiště Neapol (NAP):</strong> nízkonákladové lety z Prahy, Krakova, Vídně (od 40 EUR)</li>
    <li><strong>Letiště Lamezia Terme (SUF):</strong> sezónní lety z Polska, Německa (od 60 EUR)</li>
    <li><strong>Z Neapole do Scalea:</strong> rychlovlak Trenitalia (cca 2,5 h, od 15 EUR)</li>
    <li><strong>Z Lamezia do Scalea:</strong> vlak (cca 1,5 h, od 8 EUR)</li>
    <li><strong>Autem:</strong> z Prahy 1700 km / 17 h, z Vídně 1400 km / 15 h</li>
  </ul>
</div>',

  'en' => '<div style="margin-top: 30px; background: #f8f8f8; padding: 20px; border-radius: 10px;">
  <h3>How to get to Scalea ✈️🚆</h3>
  <ul>
    <li><strong>Naples Airport (NAP):</strong> low-cost flights from Prague, Krakow, Vienna (from 40 EUR)</li>
    <li><strong>Lamezia Terme Airport (SUF):</strong> seasonal flights from Poland, Germany (from 60 EUR)</li>
    <li><strong>From Naples to Scalea:</strong> Trenitalia fast train (approx. 2.5 h, from 15 EUR)</li>
    <li><strong>From Lamezia to Scalea:</strong> train (approx. 1.5 h, from 8 EUR)</li>
    <li><strong>By car:</strong> from Prague 1700 km / 17 h, from Vienna 1400 km / 15 h</li>
  </ul>
</div>',

  'de' => '<div style="margin-top: 30px; background: #f8f8f8; padding: 20px; border-radius: 10px;">
  <h3>Wie kommt man nach Scalea ✈️🚆</h3>
  <ul>
    <li><strong>Flughafen Neapel (NAP):</strong> Billigflüge aus Prag, Krakau, Wien (ab 40 EUR)</li>
    <li><strong>Flughafen Lamezia Terme (SUF):</strong> saisonale Flüge aus Polen, Deutschland (ab 60 EUR)</li>
    <li><strong>Von Neapel nach Scalea:</strong> Schnellzug Trenitalia (ca. 2,5 Std., ab 15 EUR)</li>
    <li><strong>Von Lamezia nach Scalea:</strong> Zug (ca. 1,5 Std., ab 8 EUR)</li>
    <li><strong>Mit dem Auto:</strong> von Prag 1700 km / 17 Std., von Wien 1400 km / 15 Std.</li>
  </ul>
</div>',

  'it' => '<div style="margin-top: 30px; background: #f8f8f8; padding: 20px; border-radius: 10px;">
  <h3>Come arrivare a Scalea ✈️🚆</h3>
  <ul>
    <li><strong>Aeroporto di Napoli (NAP):</strong> voli low-cost da Praga, Cracovia, Vienna (da 40 EUR)</li>
    <li><strong>Aeroporto di Lamezia Terme (SUF):</strong> voli stagionali da Polonia, Germania (da 60 EUR)</li>
    <li><strong>Da Napoli a Scalea:</strong> treno veloce Trenitalia (circa 2,5 h, da 15 EUR)</li>
    <li><strong>Da Lamezia a Scalea:</strong> treno (circa 1,5 h, da 8 EUR)</li>
    <li><strong>In auto:</strong> da Praga 1700 km / 17 h, da Vienna 1400 km / 15 h</li>
  </ul>
</div>'
];

$routeLinks = [
  'cs' => [
    ['url' => 'https://www.rome2rio.com/map/Vienna/Scalea', 'label' => '📍 Vídeň → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Prague/Scalea', 'label' => '📍 Praha → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Kraków/Scalea', 'label' => '📍 Krakov → Scalea'],
  ],
  'en' => [
    ['url' => 'https://www.rome2rio.com/map/Vienna/Scalea', 'label' => '📍 Vienna → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Prague/Scalea', 'label' => '📍 Prague → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Kraków/Scalea', 'label' => '📍 Kraków → Scalea'],
  ],
  'de' => [
    ['url' => 'https://www.rome2rio.com/map/Vienna/Scalea', 'label' => '📍 Wien → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Prague/Scalea', 'label' => '📍 Prag → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Kraków/Scalea', 'label' => '📍 Krakau → Scalea'],
  ],
  'it' => [
    ['url' => 'https://www.rome2rio.com/map/Vienna/Scalea', 'label' => '📍 Vienna → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Prague/Scalea', 'label' => '📍 Praga → Scalea'],
    ['url' => 'https://www.rome2rio.com/map/Kraków/Scalea', 'label' => '📍 Cracovia → Scalea'],
  ],
];

$passportInfo = [
  'cs' => '<hr style="margin: 12px 0;">
  <p style="font-size: 14px; line-height: 1.5; margin: 6px 0;">
    🌍 Zajímá vás svoboda cestování a možnosti dlouhodobého života v zahraničí?<br>
    <a href="https://www.henleyglobal.com/passport-index" target="_blank" rel="noopener">
      Henley Passport Index – srovnání síly cestovních pasů
    </a>
  </p>',

  'en' => '<hr style="margin: 12px 0;">
  <p style="font-size: 14px; line-height: 1.5; margin: 6px 0;">
    🌍 Interested in global mobility and long-term living abroad?<br>
    <a href="https://www.henleyglobal.com/passport-index" target="_blank" rel="noopener">
      Henley Passport Index – global passport power ranking
    </a>
  </p>',

  'de' => '<hr style="margin: 12px 0;">
  <p style="font-size: 14px; line-height: 1.5; margin: 6px 0;">
    🌍 Interessieren Sie sich für Reisefreiheit und internationales Leben?<br>
    <a href="https://www.henleyglobal.com/passport-index" target="_blank" rel="noopener">
      Henley Passport Index – Vergleich der Reisepass-Stärke
    </a>
  </p>',

  'it' => '<hr style="margin: 12px 0;">
  <p style="font-size: 14px; line-height: 1.5; margin: 6px 0;">
    🌍 Ti interessa la libertà di movimento e la vita internazionale?<br>
    <a href="https://www.henleyglobal.com/passport-index" target="_blank" rel="noopener">
      Henley Passport Index – classifica globale dei passaporti
    </a>
  </p>',
];


?>

<section class="main-content" style="padding: 40px 20px;">
  <h1 style="text-align: center; color: #2e9c44; font-size: 28px; margin-bottom: 30px;">
    <?= $titles[$lang] ?>
  </h1>

  <!-- Dvousloupcové rozložení -->
  <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; align-items: flex-start;">
    
<!-- Levý sloupec: text + gif -->
<div style="flex: 1 1 350px; max-width: 580px;">
  <?= $translations[$lang] ?>
  <div style="margin-top: 20px; text-align: center;">
  
  <div style="max-width: 720px; margin: 0 auto; text-align: center;">
  <iframe width="100%" height="405"
          src="https://www.youtube.com/embed/pHC259-JRTA?rel=0&autoplay=0&controls=1&playlist=2gg2QKtcjz4,g18UKIwQk58,rvzp98uAOTY,kiQPJ4JBfKA,XgWq8bv5GnI,CaAlNF_9dCE,rQEz8pbs5AQ"
          title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen
          style="border-radius: 10px; box-shadow: 0 0 6px rgba(0,0,0,0.1);">
  </iframe>
</div>


  </div>
</div>

<!-- Pravý sloupec: tabulka + odkazy -->
<div style="flex: 1 1 300px; max-width: 420px; margin-top: 6px;">
  <div style="background: #f9f9f9; padding: 16px 18px 14px; border-radius: 10px; box-shadow: 0 0 6px rgba(0,0,0,0.05); font-size: 15px; line-height: 1.5;">
    <?= $travelInfo[$lang] ?>


    <hr style="margin: 10px 0;">
    <p style="margin-bottom: 6px; font-weight: bold;">Plánování trasy:</p>
    <ul style="list-style: none; padding-left: 0; margin: 0;">
  <?php foreach ($routeLinks[$lang] as $link): ?>
    <li><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['label']) ?></a></li>
  <?php endforeach; ?>
</ul>
<hr style="margin: 10px 0;"><br>
<a href="https://re.rightdone.eu/" target="_blank" >.</a>
<br>
<?= $passportInfo[$lang] ?>
  </div>
</div>


  <!-- CTA -->
  <div style="text-align: center; margin-top: 40px;">
    <a href="/contact.php" class="cta-btn">
      <?= [
        'cs' => 'Chci nezávaznou konzultaci',
        'en' => 'Request a free consultation',
        'de' => 'Kostenlose Beratung anfordern',
        'it' => 'Richiedi una consulenza gratuita'
      ][$lang] ?>
    </a>
  </div>
</section>


<?php include __DIR__ . '/inc/footer.php'; ?>
