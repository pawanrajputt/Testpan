<?php
session_start();
// Your SendGrid config
$sendgridApiKey = "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";
$fromEmail       = "noreply@em4431.bookmytestcenter.com";
$fromName        = "Testpan India";
$toEmail         = "info@bookmytestcenter.com";

// Collect form data safely
$name     = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email    = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$phone    = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
$category = isset($_POST['category']) ? implode(", ", $_POST['category']) : 'Not Selected';

// Email subject & content
$subject = "New Contact Form Submission";
$content = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Phone:</strong> {$phone}</p>
    <p><strong>Category:</strong> {$category}</p>
";

// Build JSON payload for SendGrid API
$emailData = [
    "personalizations" => [[
        "to" => [["email" => $toEmail]],
        "subject" => $subject
    ]],
    "from" => ["email" => $fromEmail, "name" => $fromName],
    "content" => [[
        "type" => "text/html",
        "value" => $content
    ]]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $sendgridApiKey,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error    = curl_error($ch);
curl_close($ch);


if ($httpCode == 202) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Message sent successfully!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Failed to send message. Please try again.'];
}

// Redirect back to form
header("Location: index.php#contactSection");
exit;

