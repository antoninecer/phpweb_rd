<?php
require_once __DIR__ . '/inc/connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Neplatné ID.");
}

// Načti data z DB
$stmt = $pdo->prepare("SELECT * FROM imported_properties WHERE id = ?");
$stmt->execute([$id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$property) {
    die("Nemovitost nebyla nalezena.");
}

// Najdi obrázky
$imgDir = __DIR__ . "/assets/properties/{$property['id']}";
$images = [];
if (is_dir($imgDir)) {
    foreach (glob("$imgDir/image_*.jpg") as $img) {
        $images[] = str_replace(__DIR__, '', $img);
    }
}

// Navigace (předchozí a další ID)
$prev = $pdo->prepare("SELECT id FROM imported_properties WHERE id < ? ORDER BY id DESC LIMIT 1");
$prev->execute([$id]);
$prevId = $prev->fetchColumn();

$next = $pdo->prepare("SELECT id FROM imported_properties WHERE id > ? ORDER BY id ASC LIMIT 1");
$next->execute([$id]);
$nextId = $next->fetchColumn();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($property['title']) ?></title>
    <style>
        body { font-family: sans-serif; margin: 2em; background: #f9f9f9; }
        .nav { margin-bottom: 1em; }
        .nav a { margin: 0 1em; text-decoration: none; }
        .gallery img { max-width: 300px; margin: 10px; border-radius: 8px; box-shadow: 0 0 5px #999; }
        pre { background: #fff; padding: 1em; border-radius: 6px; box-shadow: 0 0 5px #ccc; }
    </style>
</head>
<body>
    <div class="nav">
        <?php if ($prevId): ?><a href="property_detail.php?id=<?= $prevId ?>">⬅️ Předchozí</a><?php endif; ?>
        <a href="list_properties.php">🏠 Zpět na seznam</a>
        <?php if ($nextId): ?><a href="property_detail.php?id=<?= $nextId ?>">Další ➡️</a><?php endif; ?>
    </div>

    <h1><?= htmlspecialchars($property['title']) ?></h1>
    <p><strong>Cena:</strong> <?= htmlspecialchars($property['price']) ?></p>
    <p><strong>RIF:</strong> <?= htmlspecialchars($property['rif']) ?></p>
    <p><strong>Adresa / Lokace:</strong> <?= htmlspecialchars($property['location']) ?></p>

    <div class="gallery">
        <?php foreach ($images as $img): ?>
            <img src="<?= htmlspecialchars($img) ?>" alt="Foto">
        <?php endforeach; ?>
        <?php if (empty($images)): ?>
            <p>Bez obrázků</p>
        <?php endif; ?>
    </div>

    <h2>Popis</h2>
    <pre><?= htmlspecialchars($property['description']) ?></pre>

    <h2>Detaily</h2>
    <pre><?= htmlspecialchars($property['details_general']) ?></pre>

    <h2>Poloha</h2>
    <pre><?= htmlspecialchars($property['position_info']) ?></pre>
</body>
</html>

