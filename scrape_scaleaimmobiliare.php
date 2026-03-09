<?php
require_once __DIR__ . '/inc/connect.php';

$url = 'https://www.scaleaimmobiliare.it/portafoglio-agenzia-immobiliare-casamediterranea-scalea-italy-ville-villette-in-vendita';
$ch = curl_init($url);
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_USERAGENT => 'Mozilla/5.0'
]);
$html = curl_exec($ch);
curl_close($ch);

if (!$html) {
  die("Nepodařilo se načíst HTML.");
}

libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

// Vyhledáme bloky inzerátů – zde závisí na konkrétní struktuře stránky
$nodes = $xpath->query("//div[contains(@class, 'property-card')]"); // úprava podle reálného HTML

foreach ($nodes as $node) {
  // Název
  $titleNode = $xpath->query(".//h2", $node)->item(0);
  $title = $titleNode ? trim($titleNode->nodeValue) : '';

  // Popis
  $descNode = $xpath->query(".//div[contains(@class, 'desc')]", $node)->item(0);
  $description = $descNode ? trim($descNode->nodeValue) : '';

  // Cena
  $priceNode = $xpath->query(".//span[contains(@class, 'price')]", $node)->item(0);
  $price = $priceNode ? trim($priceNode->nodeValue) : '';

  // Odkaz
  $linkNode = $xpath->query(".//a[contains(@href, '/immobile/')]", $node)->item(0);
  $href = $linkNode ? $linkNode->getAttribute('href') : '';
  $fullUrl = $href ? 'https://www.scaleaimmobiliare.it' . $href : '';

  // Obrázek
  $imgNode = $xpath->query(".//img", $node)->item(0);
  $imgSrc = $imgNode ? $imgNode->getAttribute('src') : '';
  $imgUrl = $imgSrc ? 'https://www.scaleaimmobiliare.it' . $imgSrc : '';
  $filename = basename(parse_url($imgUrl, PHP_URL_PATH));
  $savePath = __DIR__ . '/imported_photos/' . $filename;

  if ($imgUrl && !file_exists($savePath)) {
    file_put_contents($savePath, file_get_contents($imgUrl));
  }

  // Uložení do databáze
  $stmt = $pdo->prepare("INSERT INTO imported_properties (title, price, description, url, photo_filename)
                         VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$title, $price, $description, $fullUrl, $filename]);

  echo "✅ Importováno: $title\n";
}

echo "\nHotovo.\n";

