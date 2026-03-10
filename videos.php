<?php
require_once __DIR__ . '/inc/bootstrap.php';
$lang = LANG;
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';

$videos = [
  [
    'id' => '1A6JkuXfYpc',
    'titles' => [
      'cs' => 'První návštěva našeho bytu ve Scalee před rekonstrukcí',
      'en' => 'First visit to our apartment in Scalea before renovation',
      'de' => 'Erster Besuch unserer Wohnung in Scalea vor der Renovierung',
      'it' => 'Prima visita al nostro appartamento a Scalea prima della ristrutturazione'
    ],
    'descriptions' => [
      'cs' => 'Prohlídka bytu před rekonstrukcí, užíváme si moře a italskou atmosféru.',
      'en' => 'Tour of our apartment before renovation, enjoying the sea and Italian vibes.',
      'de' => 'Besichtigung unserer Wohnung vor der Renovierung, wir genießen das Meer und die italienische Atmosphäre.',
      'it' => 'Tour del nostro appartamento prima della ristrutturazione, godendoci il mare e l’atmosfera italiana.'
    ]
  ],
  [
    'id' => 'g18UKIwQk58',
    'titles' => [
      'cs' => 'Tajná pláž ve Scalee – výlet lodí',
      'en' => 'Secret beach in Scalea – boat trip',
      'de' => 'Geheimer Strand in Scalea – Bootsausflug',
      'it' => 'Spiaggia segreta a Scalea – gita in barca'
    ],
    'descriptions' => [
      'cs' => 'Výlet lodí a návštěva tajné pláže v okolí Scalee.',
      'en' => 'Boat trip and visiting a secret beach near Scalea.',
      'de' => 'Bootsausflug und Besuch eines geheimen Strandes in der Nähe von Scalea.',
      'it' => 'Gita in barca e visita a una spiaggia segreta vicino a Scalea.'
    ]
  ],
  [
    'id' => 'LFdicWm3QO0',
    'titles' => [
      'cs' => 'Prohlídka vily – nemovitosti na prodej',
      'en' => 'Villa tour – property for sale',
      'de' => 'Villabesichtigung – Immobilien zum Verkauf',
      'it' => 'Tour della villa – immobili in vendita'
    ],
    'descriptions' => [
      'cs' => 'Prohlídka vily v rámci prodeje nemovitostí ve Scalee.',
      'en' => 'Villa tour as part of our property sales in Scalea.',
      'de' => 'Besichtigung einer Villa im Rahmen des Immobilienverkaufs in Scalea.',
      'it' => 'Tour di una villa nell’ambito della vendita di immobili a Scalea.'
    ]
  ],
  [
    'id' => 'eunvUibLqdw',
    'titles' => [
      'cs' => 'Prohlídka apartmánu – nemovitosti na prodej',
      'en' => 'Apartment tour – property for sale',
      'de' => 'Wohnungsbesichtigung – Immobilien zum Verkauf',
      'it' => 'Tour dell’appartamento – immobili in vendita'
    ],
    'descriptions' => [
      'cs' => 'Prohlídka apartmánu v rámci prodeje nemovitostí ve Scalee.',
      'en' => 'Apartment tour as part of our property sales in Scalea.',
      'de' => 'Besichtigung einer Wohnung im Rahmen des Immobilienverkaufs in Scalea.',
      'it' => 'Tour di un appartamento nell’ambito della vendita di immobili a Scalea.'
    ]
  ]
];
?>
<section class="video-gallery" style="margin: 40px auto; max-width: 1200px; padding: 0 15px;">
  <h1 style="text-align: center; margin-bottom: 30px;">
    <?= [
      'cs' => 'Naše videa',
      'en' => 'Our Videos',
      'de' => 'Unsere Videos',
      'it' => 'I nostri video'
    ][$lang] ?>
  </h1>

  <div class="video-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
    <?php foreach ($videos as $video): ?>
      <div class="video-item" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 15px;">
        <iframe width="100%" height="200" src="https://www.youtube.com/embed/<?= $video['id'] ?>" 
          title="<?= $video['titles'][$lang] ?>" frameborder="0" allowfullscreen
          style="border-radius: 8px;"></iframe>
        <h3 style="margin: 10px 0;"><?= $video['titles'][$lang] ?></h3>
        <p style="font-size: 14px; color: #555;"><?= $video['descriptions'][$lang] ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/inc/footer.php'; ?>
