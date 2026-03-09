<?php
require_once __DIR__ . '/inc/connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Neplatné ID.");
}

$stmt = $pdo->prepare("SELECT * FROM imported_properties WHERE id = ?");
$stmt->execute([$id]);
$prop = $stmt->fetch();

if (!$prop) {
    die("Nemovitost nenalezena.");
}

// Cesta k obrázkům
$imageDir = __DIR__ . "/assets/properties/" . $id;
$imageUrlPath = "/assets/properties/" . $id;
$images = glob($imageDir . "/*.jpg");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($prop['title']) ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 800px; margin: auto; }
        h1 { margin-top: 0; }
        .nav { margin-bottom: 20px; }
        .images img { width: 100%; max-width: 400px; margin-bottom: 10px; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>

<div class="nav">
    <?php if ($id > 1): ?>
        <a href="?id=<?= $id - 1 ?>">⬅️ Předchozí</a>
    <?php endif; ?>
    |
    <a href="/property_list.php">🏠 Zpět na seznam</a>
    |
    <a href="?id=<?= $id + 1 ?>">Další ➡️</a>
</div>

<h1><?= htmlspecialchars($prop['title']) ?></h1>
<p><strong>Cena:</strong> <?= htmlspecialchars($prop['price']) ?></p>
<p><strong>Lokalita:</strong> <?= htmlspecialchars($prop['location']) ?></p>
<p><strong>RIF:</strong> <?= htmlspecialchars($prop['rif']) ?></p>

<h3>Popis</h3>
<pre><?= htmlspecialchars($prop['description']) ?></pre>

<h3>Detaily</h3>
<pre><?= htmlspecialchars($prop['details_general']) ?></pre>

<h3>Umístění</h3>
<pre><?= htmlspecialchars($prop['position_info']) ?></pre>

<h3>Obrázky</h3>
<div class="images">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $img): ?>
            <img src="<?= $imageUrlPath . '/' . basename($img) ?>" alt="Obrázek">
        <?php endforeach; ?>
    <?php else: ?>
        <p><em>Žádné obrázky k dispozici.</em></p>
    <?php endif; ?>
</div>

</body>
</html>

