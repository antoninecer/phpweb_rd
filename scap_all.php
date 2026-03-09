<?php
// Přehled všech vil z výpisu Casa Mediterranea

function fetchRemotePage($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => "Mozilla/5.0 (compatible; RightDoneBot/1.0)",
        CURLOPT_TIMEOUT => 15,
    ]);
    $data = curl_exec($ch);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($data === false) {
        echo "❌ Chyba při načítání $url: $err\n";
    }
    return $data;
}

$url = "https://www.scaleaimmobiliare.it/portafoglio-agenzia-immobiliare-casamediterranea-scalea-italy-ville-villette-in-vendita";
$html = fetchRemotePage($url);

if (!$html) {
    die("❌ Nelze načíst vzdálenou stránku: $url\n");
}

libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($doc);
$links = $xpath->query('//a[contains(@href, "/villa-rif-")]');

if ($links->length === 0) {
    die("❌ Nenašly se žádné odkazy na vily.\n");
}

echo "🔎 Nalezeno " . $links->length . " odkazů\n";

// Unikátní adresy
$urls = [];
foreach ($links as $link) {
    $href = trim($link->getAttribute('href'));
    if (strpos($href, 'http') !== 0) {
        $href = 'https://www.scaleaimmobiliare.it' . $href;
    }
    $urls[$href] = true;
}

echo "➡️  Po odfiltrování duplicit: " . count($urls) . " unikátních stránek.\n";

// Zpracuj každou vilu přes scap.php
foreach (array_keys($urls) as $i => $pageUrl) {
    echo "\n👉 Zpracovávám č. " . ($i + 1) . ": $pageUrl\n";
    //$_GET['page'] = $pageUrl;
    //include __DIR__ . '/scap.php';
}

echo "\n✅ Hotovo.\n";

