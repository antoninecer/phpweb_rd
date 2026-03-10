<?php
require_once __DIR__ . '/inc/bootstrap.php';
$lang = LANG;
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/menu.php';

$texts = [
  'cs' => [
    'content' => '<h1>Nezávazná konzultace</h1>
    <p>Pokud uvažujete o pořízení nemovitosti v Itálii a chcete poradit od lidí, kteří tím sami prošli, napište nám.</p>
    <p><b>Right Done s.r.o.	IČ: 23387858</b><br>671 40, Újezd 58<br>Spisová značka: C 145692 vedená u Krajského soudu v Brně<br>DIČ: CZ23387858 Nejsme plátci DPH</p>
    <p><strong>Telefon / Fax:</strong> +420 910 128 749 <span class="note">(Pondělí –Pátek 10:00–18:00, mimo České státní svátky)</span></p>
    <p><strong>📨 Email:</strong> <a href="mailto:info@rightdone.eu">info@rightdone.eu</a></p><p><b>ISDS: </b> jq5idtk</p>',
    'name' => 'Vaše jméno:',
    'email' => 'Váš e-mail:',
    'message' => 'Vaše zpráva:',
    'send' => 'Odeslat zprávu'
  ],
  'en' => [
    'content' => '<h1>Non-binding Consultation</h1>
    <p>If you are considering purchasing property in Italy and want advice from people who have been through it themselves, write to us.</p>
    <p><b>Right Done s.r.o.    ID: 23387858</b><br>671 40, Újezd 58<br>File number: C 145692 registered at the Regional Court in Brno<br>VAT ID: CZ23387858 We are not VAT payers</p>
    <p><strong>Phone / Fax:</strong> +420 910 128 749 <span class="note">(Monday–Friday 10:00–18:00, excluding Czech national holidays)</span></p>
    <p><strong>📨 Email:</strong> <a href="mailto:info@rightdone.eu">info@rightdone.eu</a></p><p><b>ISDS: </b> jq5idtk</p>',
    'name' => 'Your name:',
    'email' => 'Your email:',
    'message' => 'Your message:',
    'send' => 'Send message'
  ],
  'de' => [
    'content' => '<h1>Unverbindliche Beratung</h1>
    <p>Wenn Sie den Kauf einer Immobilie in Italien in Erwägung ziehen und Ratschläge von Menschen erhalten möchten, die diesen Weg selbst gegangen sind, schreiben Sie uns.</p>
    <p><b>Right Done s.r.o.    ID: 23387858</b><br>671 40, Újezd 58<br>Aktenzeichen: C 145692 eingetragen beim Kreisgericht in Brünn<br>USt-IdNr.: CZ23387858 Wir sind nicht umsatzsteuerpflichtig</p>
    <p><strong>Telefon / Fax:</strong> +420 910 128 749 <span class="note">(Montag–Freitag 10:00–18:00, außer an tschechischen Feiertagen)</span></p>
    <p><strong>📨 E-Mail:</strong> <a href="mailto:info@rightdone.eu">info@rightdone.eu</a></p><p><b>ISDS: </b> jq5idtk</p>',
    'name' => 'Ihr Name:',
    'email' => 'Ihre E-Mail:',
    'message' => 'Ihre Nachricht:',
    'send' => 'Nachricht senden'
  ],
  'it' => [
    'content' => '<h1>Consulenza senza impegno</h1>
    <p>Se stai pensando di acquistare una proprietà in Italia e desideri consigli da chi ci è già passato, scrivici.</p>
    <p><b>Right Done s.r.o.    ID: 23387858</b><br>671 40, Újezd 58<br>Numero di registro: C 145692 registrato presso il Tribunale Regionale di Brno<br>Partita IVA: CZ23387858 Non siamo soggetti a IVA</p>
    <p><strong>Telefono / Fax:</strong> +420 910 128 749 <span class="note">(Lunedì–Venerdì 10:00–18:00, escluse le festività nazionali ceche)</span></p>
    <p><strong>📨 Email:</strong> <a href="mailto:info@rightdone.eu">info@rightdone.eu</a></p><p><b>ISDS: </b> jq5idtk</p>',
    'name' => 'Il tuo nome:',
    'email' => 'La tua email:',
    'message' => 'Il tuo messaggio:',
    'send' => 'Invia messaggio'
  ]
];
?>

<section class="contact-section">
  <div class="contact-wrapper">
    <?= $texts[$lang]['content'] ?>

    <form method="post" action="send_contact.php" class="contact-form">
      <label for="name"><?= $texts[$lang]['name'] ?></label>
      <input type="text" id="name" name="name" required>

      <label for="email"><?= $texts[$lang]['email'] ?></label>
      <input type="email" id="email" name="email" required>

      <label for="message"><?= $texts[$lang]['message'] ?></label>
      <textarea id="message" name="message" rows="7" required></textarea>

      <button type="submit"><?= $texts[$lang]['send'] ?></button>
    </form>
  </div>
</section>

<?php
$sentStatus = $_GET['sent'] ?? null;

if ($sentStatus !== null) {
  $messages = [
    'cs' => [
      'success' => 'Zpráva byla úspěšně odeslána.',
      'error' => 'Zprávu se nepodařilo odeslat. Zkuste to prosím znovu.',
      'button' => 'Zavřít'
    ],
    'en' => [
      'success' => 'Message sent successfully.',
      'error' => 'Failed to send the message. Please try again.',
      'button' => 'Close'
    ],
    'de' => [
      'success' => 'Nachricht erfolgreich gesendet.',
      'error' => 'Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es erneut.',
      'button' => 'Schließen'
    ],
    'it' => [
      'success' => 'Messaggio inviato con successo.',
      'error' => 'Invio del messaggio non riuscito. Riprova.',
      'button' => 'Chiudi'
    ]
  ];

  $msg = $sentStatus == '1' ? $messages[$lang]['success'] : $messages[$lang]['error'];
  $btn = $messages[$lang]['button'];

  echo "
  <div id=\"messagePopup\" style=\"position:fixed; top:20px; left:50%; transform:translateX(-50%); background:#f0f0f0; border:1px solid #aaa; padding:15px 20px; border-radius:5px; box-shadow:0 0 10px rgba(0,0,0,0.2); z-index:9999;\">
    <p style=\"margin:0 0 10px 0;\">$msg</p>
    <button onclick=\"document.getElementById('messagePopup').style.display='none'\">$btn</button>
  </div>
  <script>
    setTimeout(() => {
      const popup = document.getElementById('messagePopup');
      if (popup) popup.style.display = 'none';
    }, 5000);
  </script>
  ";
}
?>

<?php include 'inc/footer.php'; ?>
