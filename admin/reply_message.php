<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Assurez-vous que PHPMailer est installé via Composer

header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

$message = '';

// Vérifier si un ID est passé
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-red-500 text-center'>Aucun message trouvé.</p>";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT name, email, subject, message, created_at FROM messages WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$message_data = mysqli_fetch_assoc($result);

if (!$message_data) {
    echo "<p class='text-red-500 text-center'>Aucun message trouvé.</p>";
    exit;
}

// Gestion de l'envoi de réponse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = $_POST['email'];
    $subject = $_POST['subject'];
    $reply_message = $_POST['reply_message'];

    // Initialisation de PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->CharSet    = 'UTF-8';
        $mail->Host       = 'smtp.gmail.com'; // Changez selon votre serveur SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'keitaabdoukarim2025@gmail.com'; // Changez par votre email
        $mail->Password   = 'agft wxgr dcrl zrtq'; // Changez par votre mot de passe d’application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('keitaabdoukarim2025@gmail.com', 'SoumAfrique');
        $mail->addAddress($to_email, $message_data['name']);

        $mail->isHTML(true);
        $mail->Subject = "Re: " . $subject;
        $mail->Body    = nl2br($reply_message);

        $mail->send();
        $message = '<p class="text-green-500 text-center" id="success-message">Réponse envoyée avec succès !</p>';
    } catch (Exception $e) {
        $message = '<p class="text-red-500 text-center">Échec de l\'envoi du message. Erreur: ' . $mail->ErrorInfo . '</p>';
    }
}

?>

<div class="flex min-h-screen">
<?php include('sidebar2.php'); ?>
<div class="flex-1 p-6">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-lg font-bold mb-4 text-center">📩 Répondre au Message</h2>

    <!-- Message de confirmation -->
    <?php if ($message): ?>
      <?= $message ?>
    <?php endif; ?>

    <!-- Détails du message reçu -->
    <div class="mb-6 border p-4 bg-gray-100 rounded-lg">
        <p><strong>Nom :</strong> <?= htmlspecialchars($message_data['name']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($message_data['email']) ?></p>
        <p><strong>Sujet :</strong> <?= htmlspecialchars($message_data['subject']) ?></p>
        <p><strong>Date :</strong> <?= htmlspecialchars($message_data['created_at']) ?></p>
        <p><strong>Message :</strong></p>
        <p class="border p-4 bg-white"><?= nl2br(htmlspecialchars($message_data['message'])) ?></p>
    </div>

    <!-- Formulaire de réponse -->
    <form action="" method="POST" class="space-y-6">
        <input type="hidden" name="email" value="<?= htmlspecialchars($message_data['email']) ?>">

        <div>
          <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
          <input type="text" id="subject" name="subject" value="Re: <?= htmlspecialchars($message_data['subject']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 py-2 px-4 focus:ring-green-600 focus:border-green-600 focus:bg-white">
        </div>

        <div>
          <label for="reply_message" class="block text-sm font-medium text-gray-700">Votre Réponse</label>
          <textarea id="reply_message" name="reply_message" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 py-2 px-4 focus:ring-green-600 focus:border-green-600 focus:bg-white"></textarea>
        </div>

        <button type="submit" class="btn-gradient text-white px-6 py-3 rounded-lg font-bold w-full">Envoyer la Réponse</button>
    </form>

    <div class="mt-4">
        <a href="admin_messages.php" class="inline-block bg-gray-500 text-white px-4 py-2 rounded">Retour</a>
    </div>
  </div>
</div>
</div>

<script>
  // Faire disparaître le message après 2 secondes
  const successMessage = document.getElementById('success-message');
  if (successMessage) {
    setTimeout(() => {
      successMessage.style.display = 'none';
    }, 2000);
  }
</script>

<?php include('./templates/footer.php'); ?>
