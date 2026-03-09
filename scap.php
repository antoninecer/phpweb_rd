<?php
require_once __DIR__ . '/inc/connect.php';

$url = $_GET['page'] ?? '';
if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
    die("❌ Neplatná nebo chybějící URL.");
}

// Načtení HTML
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
]);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($html === false || $code !== 200) die("❌ Nelze načíst stránku (kód $code).");

libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
libxml_clear_errors();
$xpath = new DOMXPath($doc);

// Název
$title = trim($doc->getElementsByTagName("title")[0]?->nodeValue ?? 'Neznámý název');
$original_title = $title;
preg_match('/Rif[^0-9]*([0-9]+)/i', $title, $rifMatch);
$rif = isset($rifMatch[0]) ? trim($rifMatch[0]) : null;

// Čištění title
$title = preg_replace('/Rif[^\/]+\/Casa Mediterranea/i', '', $title);
$title = preg_replace('/Casa Mediterranea/i', '', $title);
$title = preg_replace('/Rlf\s*\d+/i', '', $title);
$title = trim($title);

// Cena
$priceNode = $xpath->query("//*[contains(text(), 'Prezzo')]")->item(0);
$price = trim($priceNode?->textContent ?? 'Neznámá cena');

// Parsování sekcí
$paragraphs = $xpath->query("//*[contains(@class, 'dmNewParagraph')]");
$base_features = $interior_desc = $general_details = $position_info = '';
$section = '';

foreach ($paragraphs as $p) {
    $text = trim($p->textContent);
    if (!$text) continue;

    if (str_starts_with($text, 'Caratteristiche')) $section = 'base';
    elseif (str_starts_with($text, 'Descrizione')) $section = 'desc';
    elseif (str_starts_with($text, 'Dettagli')) $section = 'details';
    elseif (str_starts_with($text, 'Posizione')) $section = 'position';

    if ($section === 'base') $base_features .= $text . "\n";
    elseif ($section === 'desc') $interior_desc .= $text . "\n";
    elseif ($section === 'details') $general_details .= $text . "\n";
    elseif ($section === 'position') $position_info .= $text . "\n";
}

// Extrakce location z textu
$location = null;
if (preg_match('/si trova (nella|nel|nello) (.+?)\./i', $position_info, $m)) {
    $location = trim($m[2]);
}

// ID
$externalId = md5($url);
$now = date('Y-m-d H:i:s');

// Kontrola existence
$stmt = $pdo->prepare("SELECT id FROM imported_properties WHERE external_id = ?");
$stmt->execute([$externalId]);
$row = $stmt->fetch();

$description = $interior_desc;
$detail_url = $url;

if ($row) {
    $update = $pdo->prepare("
        UPDATE imported_properties
        SET title=?, price=?, description=?, base_features=?, interior_desc=?, general_details=?, position_info=?, rif=?, updated_at=?, location=?, detail_url=?
        WHERE id=?
    ");
    $update->execute([
        $title, $price, $description, $base_features, $interior_desc, $general_details, $position_info,
        $rif, $now, $location, $detail_url, $row['id']
    ]);
    $id = $row['id'];
    echo "♻️ Záznam aktualizován. ID: $id<br>";
} else {
    $insert = $pdo->prepare("
        INSERT INTO imported_properties
        (external_id, url, title, price, description, base_features, interior_desc, general_details, position_info, rif, created_at, location, detail_url)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $insert->execute([
        $externalId, $url, $title, $price, $description, $base_features, $interior_desc, $general_details, $position_info,
        $rif, $now, $location, $detail_url
    ]);
    $id = $pdo->lastInsertId();
    echo "✅ Nový záznam vložen. ID: $id<br>";
}

// Obrázky
$imageDir = __DIR__ . "/assets/properties/$id";
@mkdir($imageDir, 0777, true);
$imgs = $xpath->query("//img");
$downloaded = 0;

foreach ($imgs as $i => $img) {
    $src = trim($img->getAttribute('src'));
    if (!$src || str_starts_with($src, 'data:')) continue;
    $imgUrl = str_starts_with($src, 'http') ? $src : dirname($url) . '/' . ltrim($src, '/');

    $ch2 = curl_init($imgUrl);
    curl_setopt_array($ch2, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0',
    ]);
    $imgData = curl_exec($ch2);
    $size = strlen($imgData);
    curl_close($ch2);

    if ($imgData && $size > 55000) {
        file_put_contents("$imageDir/image_$i.jpg", $imgData);
        echo "📸 Uložen obrázek ($size B): $imageDir/image_$i.jpg<br>";
        $downloaded++;
    }
}

echo "🔑 Key-Pair Images: $downloaded<br>";
?>

