<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Send email using Right Done SMTP settings
 */
function sendEmail($to, $toName, $subject, $htmlBody, $plainBody = '') {
    global $config;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host       = $config['smtp_rightdone']['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['smtp_rightdone']['username'];
        $mail->Password   = $config['smtp_rightdone']['password'];
        $mail->SMTPSecure = $config['smtp_rightdone']['secure'];
        $mail->Port       = $config['smtp_rightdone']['port'];

        $mail->setFrom($config['smtp_rightdone']['username'], 'Right Done');
        $mail->addAddress($to, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $plainBody ?: strip_tags($htmlBody);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Send email using MyScalea SMTP settings
 */
function sendEmail_myscalea($to, $toName, $subject, $htmlBody, $plainBody = '') {
    global $config;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host       = $config['smtp_myscalea']['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['smtp_myscalea']['username'];
        $mail->Password   = $config['smtp_myscalea']['password'];
        $mail->SMTPSecure = $config['smtp_myscalea']['secure'];
        $mail->Port       = $config['smtp_myscalea']['port'];

        $mail->setFrom($config['smtp_myscalea']['username'], 'MyScalea.it');
        $mail->addAddress($to, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $plainBody ?: strip_tags($htmlBody);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("E-mail error: " . $mail->ErrorInfo);
        return false;
    }
}

function generatePiwigoPassword(string $agencyName, int $agencyId): string {
    global $config;
    $secret = $config['app_secret'] ?? 'fallback_secret';
    $cleanName = strtolower(preg_replace('/[^a-z0-9]/', '', $agencyName));
    $raw = $cleanName . $agencyId . $secret;
    return substr(hash('sha256', $raw), 0, 12);
}

function createPiwigoCategory(PDO $pdo, string $name, int $parentId): bool {
    $stmt = $pdo->prepare("SELECT uppercats, global_rank FROM piwigo_categories WHERE id = ?");
    $stmt->execute([$parentId]);
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parent) return false;

    $uppercats = $parent['uppercats'] . ',';
    $global_rank = $parent['global_rank'] . '.';

    $insert = $pdo->prepare("INSERT INTO piwigo_categories
        (name, id_uppercat, comment, `rank`, status, site_id, visible, uppercats, commentable, global_rank)
        VALUES (?, ?, '', 1, 'public', 1, 'true', ?, 'true', ?)");

    return $insert->execute([$name, $parentId, $uppercats . '?', $global_rank . '?']);
}

function makeLinks($text) {
    $escaped = htmlspecialchars($text);
    $linked = preg_replace_callback(
        '/(https?:\/\/[^\s<]+)/i',
        function($matches) {
            $url = $matches[1];
            return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
        },
        $escaped
    );
    return nl2br($linked);
}

function formatDateStandard($dateStr) {
    $dt = DateTime::createFromFormat('Y-m-d', $dateStr);
    return $dt ? $dt->format('d. m. Y') : $dateStr;
}

function generateProformaBlock($iban, $amount, $vs, $dueDate, $propertyName) {
    $amountFormatted = number_format($amount, 2, '.', '');
    $msg = "Reservation $vs";

    $qrText = "SPD*1.0*ACC:$iban*AM:$amountFormatted*CC:CZK*MSG:$msg";
    $qrEncoded = urlencode($qrText);
    $qrUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$qrEncoded";

    return "
    <div style='border: 1px solid #ccc; padding: 20px; max-width: 500px;'>
      <h2>Proforma Invoice – $propertyName</h2>
      <p><strong>Amount to Pay:</strong> $amountFormatted CZK</p>
      <p><strong>Variable Symbol:</strong> $vs</p>
      <p><strong>Bank Account:</strong> $iban</p>
      <p><strong>Due Date:</strong> $dueDate</p>
      <p><strong>Payment Note:</strong> $msg</p>
      <img src='$qrUrl' alt='QR Payment' style='margin-top: 15px;'>
      <p style='margin-top: 15px; font-size: 0.9em; color: #666;'>The reservation will be confirmed after the payment is received. If the payment is not made by the due date, the reservation will be automatically canceled.</p>
    </div>";
}

function generateVariableSymbol(DateTime $fromDate, string $email, int $reservationId): string {
    $prefix = $fromDate->format('ymd');
    $emailPart = strtoupper(substr(md5(strtolower(trim(explode('@', $email)[0]))), 0, 3));
    $suffix = str_pad($reservationId % 100000, 5, '0', STR_PAD_LEFT);

    return $prefix . $emailPart . $suffix;
}

function extractReservationIdFromVS(string $vs): ?int {
    if (preg_match('/^[0-9]{6}[A-Z0-9]{3}([0-9]{5})$/', $vs, $matches)) {
        return intval($matches[1]);
    }
    return null;
}

function generateQrPayment(string $iban, float $amount, string $vs, string $message = '', string $bic = 'NTSBDEB1XXX', string $recipient = 'MyScalea'): string {
    $formattedAmount = number_format($amount, 2, '.', '');
    $msg = $message ?: "Reservation $vs";

    $qrText = implode("\n", [
        'BCD', '002', '1', 'SCT', $bic, $recipient, $iban, \"EUR$formattedAmount\", $vs, '', $msg
    ]);

    try {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrText)
            ->size(300)
            ->margin(10)
            ->build();

        $dataUri = $result->getDataUri();
        return \"<img src='\$dataUri' alt='QR Payment' style='max-width:200px'>\";
    } catch (Exception $e) {
        error_log(\"QR code generation failed: \" . $e->getMessage());
        return \"<p style='color:red'>QR code generation failed</p>\";
    }
}
