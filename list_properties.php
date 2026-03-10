<?php
require_once __DIR__ . '/inc/bootstrap.php';
$lang = LANG;

include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';

$t = [
    'cs' => [
        'title' => 'Nabídka nemovitostí ve Scalee',
        'price' => 'Cena',
        'location' => 'Lokalita',
        'detail' => 'Zobrazit detail',
        'no_properties' => 'Žádné nemovitosti k zobrazení.'
    ],
    'en' => [
        'title' => 'Property Offers in Scalea',
        'price' => 'Price',
        'location' => 'Location',
        'detail' => 'View detail',
        'no_properties' => 'No properties to display.'
    ],
    'de' => [
        'title' => 'Immobilienangebote in Scalea',
        'price' => 'Preis',
        'location' => 'Standort',
        'detail' => 'Details anzeigen',
        'no_properties' => 'Keine Immobilien zum Anzeigen.'
    ],
    'it' => [
        'title' => 'Offerte immobiliari a Scalea',
        'price' => 'Prezzo',
        'location' => 'Posizione',
        'detail' => 'Visualizza dettaglio',
        'no_properties' => 'Nessun immobile da visualizzare.'
    ]
];

$stmt = $pdo->query("SELECT id, title, price, location, rif FROM imported_properties ORDER BY created_at DESC");
$properties = $stmt->fetchAll();
?>

<section class="main-content" style="padding: 40px 20px;">
    <h1><?= htmlspecialchars($t[$lang]['title']) ?></h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; margin-top: 30px;">
        <?php if ($properties): ?>
            <?php foreach ($properties as $prop): 
                $id = $prop['id'];
                $imgDir = __DIR__ . "/assets/properties/$id";
                $firstImg = 'assets/img/logo-rightdone-small.png'; // Fallback
                
                if (is_dir($imgDir)) {
                    $images = glob("$imgDir/image_*.jpg");
                    if ($images) {
                        $firstImg = "assets/properties/$id/" . basename($images[0]);
                    }
                }
            ?>
                <div style="background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden; display: flex; flex-direction: column;">
                    <div style="height: 200px; overflow: hidden; background: #eee;">
                        <img src="<?= htmlspecialchars($firstImg) ?>" alt="Property" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 20px; flex-grow: 1;">
                        <h3 style="margin-top: 0; font-size: 18px; color: #333; height: 3em; overflow: hidden;"><?= htmlspecialchars($prop['title']) ?></h3>
                        <p style="margin: 10px 0; color: #2e9c44; font-weight: bold; font-size: 20px;"><?= htmlspecialchars($prop['price']) ?></p>
                        <p style="margin: 5px 0; color: #666; font-size: 14px;">📍 <?= htmlspecialchars($prop['location']) ?></p>
                        <p style="margin: 5px 0; color: #999; font-size: 12px;">RIF: <?= htmlspecialchars($prop['rif']) ?></p>
                    </div>
                    <div style="padding: 20px; border-top: 1px solid #eee;">
                        <a href="property_detail.php?id=<?= $id ?>" style="display: block; text-align: center; background: #2e9c44; color: #fff; text-decoration: none; padding: 10px; border-radius: 5px; font-weight: bold;">
                            <?= htmlspecialchars($t[$lang]['detail']) ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= htmlspecialchars($t[$lang]['no_properties']) ?></p>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/inc/footer.php'; ?>
