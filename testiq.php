<?php
// ----------------- CONFIG -----------------
define('WEBHOOK_START', 'https://n8n.rightdone.eu/webhook/iq/start');
define('WEBHOOK_SUBMIT', 'https://n8n.rightdone.eu/webhook/iq/submit');
// ------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['testId'])) {
    // === krok 2: odeslání odpovědí ===
    $answers = [];
    foreach ($_POST as $key => $val) {
        if (preg_match('/^q_(.+)$/', $key, $m)) {
            $answers[] = ['id' => $m[1], 'choice' => (int)$val];
        }
    }

    $payload = [
        'testId' => $_POST['testId'],
        'token'  => $_POST['token'],
        'payload'=> $_POST['payload'],
        'answers'=> $answers
    ];

    $ch = curl_init(WEBHOOK_SUBMIT);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $resp = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($resp, true);
    ?>
    <h2>✅ Výsledek testu</h2>
    <p><b>Skóre:</b> <?= htmlspecialchars($data['score']['correct']) ?>/<?= htmlspecialchars($data['score']['total']) ?> (<?= htmlspecialchars($data['score']['pct']) ?>%)</p>
    <p><b>Úroveň:</b> <?= htmlspecialchars($data['score']['band']) ?></p>
    <pre><?= htmlspecialchars($data['feedback']) ?></pre>
    <p><small><?= htmlspecialchars($data['disclaimer']) ?></small></p>
    <a href="?">🔁 Spustit znovu</a>
    <?php
    exit;
}

// === krok 1: načtení testu ===
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'cs', 0, 2);
$url = WEBHOOK_START . '?lang=' . urlencode($lang);

$json = file_get_contents($url);
$test = json_decode($json, true);
if (!$test || empty($test['questions'])) {
    echo "<p>Chyba při načítání testu.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="utf-8">
<title>IQ tréninkový test</title>
<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 30px auto; line-height: 1.6; }
fieldset { margin-bottom: 20px; border-radius: 8px; border: 1px solid #ccc; padding: 15px; }
legend { font-weight: bold; }
button { padding: 10px 20px; font-size: 16px; }
</style>
</head>
<body>
<h1>🧠 Tréninkový IQ test</h1>
<form method="post">
<input type="hidden" name="testId" value="<?= htmlspecialchars($test['testId']) ?>">
<input type="hidden" name="token" value="<?= htmlspecialchars($test['token']) ?>">
<input type="hidden" name="payload" value='<?= htmlspecialchars($test['payload'], ENT_QUOTES) ?>'>

<?php foreach ($test['questions'] as $q): ?>
<fieldset>
  <legend><?= htmlspecialchars($q['text']) ?></legend>
  <?php foreach ($q['options'] as $i => $opt): ?>
    <label>
      <input type="radio" name="q_<?= htmlspecialchars($q['id']) ?>" value="<?= $i ?>" required>
      <?= htmlspecialchars($opt) ?>
    </label><br>
  <?php endforeach; ?>
</fieldset>
<?php endforeach; ?>

<button type="submit">Odeslat test</button>
</form>
</body>
</html>

