<?php
require_once __DIR__ . '/inc/bootstrap.php';
$lang = LANG;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: list_properties.php");
    exit;
}

// Načti data z DB
$stmt = $pdo->prepare("SELECT * FROM imported_properties WHERE id = ?");
$stmt->execute([$id]);
$property = $stmt->fetch();

if (!$property) {
    header("Location: list_properties.php");
    exit;
}

// Najdi obrázky
$imgDir = __DIR__ . "/assets/properties/{$property['id']}";
$images = [];
if (is_dir($imgDir)) {
    $files = glob("$imgDir/image_*.jpg");
    foreach ($files as $img) {
        $images[] = "assets/properties/{$property['id']}/" . basename($img);
    }
}

// Navigace (předchozí a další ID)
$prev = $pdo->prepare("SELECT id FROM imported_properties WHERE id < ? ORDER BY id DESC LIMIT 1");
$prev->execute([$id]);
$prevId = $prev->fetchColumn();

$next = $pdo->prepare("SELECT id FROM imported_properties WHERE id > ? ORDER BY id ASC LIMIT 1");
$next->execute([$id]);
$nextId = $next->fetchColumn();

include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';

$t = [
    'cs' => ['back' => 'Zpět na seznam', 'price' => 'Cena', 'rif' => 'RIF', 'location' => 'Lokalita', 'desc' => 'Popis', 'details' => 'Detaily', 'position' => 'Poloha'],
    'en' => ['back' => 'Back to list', 'price' => 'Price', 'rif' => 'RIF', 'location' => 'Location', 'desc' => 'Description', 'details' => 'Details', 'position' => 'Position'],
    'de' => ['back' => 'Zurück zur Liste', 'price' => 'Preis', 'rif' => 'RIF', 'location' => 'Standort', 'desc' => 'Beschreibung', 'details' => 'Details', 'position' => 'Lage'],
    'it' => ['back' => 'Torna all\'elenco', 'price' => 'Prezzo', 'rif' => 'RIF', 'location' => 'Posizione', 'desc' => 'Descrizione', 'details' => 'Dettagli', 'position' => 'Posizione']
];
?>

<section class="main-content" style="padding: 40px 20px;">
    <div class="nav" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <?php if ($prevId): ?><a href="property_detail.php?id=<?= $prevId ?>" style="text-decoration: none; font-weight: bold; color: #2e9c44;">⬅️</a><?php endif; ?>
            <a href="list_properties.php" style="margin: 0 20px; text-decoration: none; color: #666;"><?= htmlspecialchars($t[$lang]['back']) ?></a>
            <?php if ($nextId): ?><a href="property_detail.php?id=<?= $nextId ?>" style="text-decoration: none; font-weight: bold; color: #2e9c44;">➡️</a><?php endif; ?>
        </div>
    </div>

    <h1 style="color: #333; margin-bottom: 10px;"><?= htmlspecialchars($property['title']) ?></h1>
    <div style="display: flex; gap: 20px; margin-bottom: 30px; color: #666; font-size: 18px;">
        <span><strong><?= $t[$lang]['price'] ?>:</strong> <span style="color: #2e9c44; font-weight: bold;"><?= htmlspecialchars($property['price']) ?></span></span>
        <span><strong><?= $t[$lang]['rif'] ?>:</strong> <?= htmlspecialchars($property['rif']) ?></span>
    </div>
    <p style="font-size: 16px; color: #666; margin-bottom: 30px;">📍 <?= htmlspecialchars($property['location']) ?></p>

    <div class="gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 40px;">
        <?php foreach ($images as $img): ?>
            <a href="/<?= $img ?>" target="_blank">
                <img src="/<?= $img ?>" alt="Foto" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            </a>
        <?php endforeach; ?>
        <?php if (empty($images)): ?>
            <p><em>Bez obrázků</em></p>
        <?php endif; ?>
    </div>

    <div style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="border-bottom: 2px solid #2e9c44; padding-bottom: 10px; margin-top: 0;"><?= $t[$lang]['desc'] ?></h2>
        <div style="white-space: pre-wrap; line-height: 1.6; color: #444; margin-bottom: 30px;"><?= htmlspecialchars($property['description']) ?></div>

        <?php if (!empty($property['details_general'])): ?>
            <h2 style="border-bottom: 2px solid #2e9c44; padding-bottom: 10px;"><?= $t[$lang]['details'] ?></h2>
            <div style="white-space: pre-wrap; line-height: 1.6; color: #444; margin-bottom: 30px;"><?= htmlspecialchars($property['details_general']) ?></div>
        <?php endif; ?>

        <?php if (!empty($property['position_info'])): ?>
            <h2 style="border-bottom: 2px solid #2e9c44; padding-bottom: 10px;"><?= $t[$lang]['position'] ?></h2>
            <div style="white-space: pre-wrap; line-height: 1.6; color: #444;"><?= htmlspecialchars($property['position_info']) ?></div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/inc/footer.php'; ?>
