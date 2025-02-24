<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
include('./templates/header.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Si installé via Composer
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

// Traitement de la validation/rejet
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action == "valider") {
        // Marquer comme validé
        $status = "validé";
        $_SESSION['message'] = "✅ Boutique validée avec succès !";

        // Générer un mot de passe temporaire sécurisé
        $temporary_password = bin2hex(random_bytes(8));
        $hashed_password = password_hash($temporary_password, PASSWORD_DEFAULT);

        // Mettre à jour le statut et le mot de passe temporaire dans la base
        $query = "UPDATE proprietaire SET status = ?, password_temporaire = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $status, $hashed_password, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['status-update'] = true;

            // Récupérer les données du propriétaire pour l'email
            $query_proprietaire = "SELECT nom_complet, email FROM proprietaire WHERE id = ?";
            $stmt_proprietaire = mysqli_prepare($conn, $query_proprietaire);
            mysqli_stmt_bind_param($stmt_proprietaire, "i", $id);
            mysqli_stmt_execute($stmt_proprietaire);
            $result_proprietaire = mysqli_stmt_get_result($stmt_proprietaire);

            if ($row = mysqli_fetch_assoc($result_proprietaire)) {
                // Préparer l'email
                $email_subject = "Accès à votre tableau de bord SoumAfrique";
                $email_body = "Bonjour {$row['nom_complet']},\n\n";
                $email_body .= "Votre boutique a été validée avec succès. Vous pouvez maintenant accéder à votre tableau de bord.\n\n";
                $email_body .= "Lien de connexion : <a href='http://localhost/soumafrique/admin/admin-dashboard.php'>Connexion</a><br>";
                $email_body .= "Identifiant : {$row['email']}\n";
                $email_body .= "Mot de passe temporaire : {$temporary_password}\n\n";
                $email_body .= "Merci de changer votre mot de passe dès votre première connexion.\n\n";
                $email_body .= "Cordialement,\n";
                $email_body .= "L'équipe SoumAfrique";

                // Ajout des en-têtes pour UTF-8
                $headers = "From: SoumAfrique <no-reply@soumafrique.com>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $headers .= "Content-Transfer-Encoding: 8bit\r\n";

                // Envoyer l'email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->CharSet    = 'UTF-8';
                    $mail->Host       = 'smtp.gmail.com'; // Remplacez par le serveur SMTP que vous utilisez
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'keitaabdoukarim2025@gmail.com'; // Remplacez par votre email
                    $mail->Password   = 'agft wxgr dcrl zrtq'; // Remplacez par votre mot de passe ou mot de passe d’application
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('keitaabdoukarim2025@gmail.com', 'SoumAfrique');
                    $mail->addAddress($row['email'], $row['nom_complet']);

                    $mail->isHTML(true);
                    $mail->Subject = $email_subject;
                    $mail->Body    = nl2br($email_body);

                    $mail->send();
                    $_SESSION['message'] = "✅ Boutique validée avec succès et email envoyé.";
                } catch (Exception $e) {
                    $_SESSION['message'] = "⚠️ La validation a été effectuée, mais l'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
                }
            }
            mysqli_stmt_close($stmt_proprietaire);
        } else {
            $_SESSION['message'] = "⚠️ Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } elseif ($action == "rejeter") {
        // Marquer comme rejeté
        $status = "rejeté";
        $_SESSION['message'] = "❌ Boutique rejetée avec succès !";

        // Mettre à jour la base
        $query = "UPDATE proprietaire SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: validate-shop.php");
    exit();
}

// Récupérer les boutiques
$query = "SELECT * FROM proprietaire";
$result = mysqli_query($conn, $query);

?>

 <!-- Sidebar -->
 <div class="flex min-h-screen">
 <?php include('sidebar2.php'); ?>
<div class="flex">
    <!-- Contenu principal -->
    <main class="flex-1 p-6 flex flex-col items-center justify-center">
        <h1 class="text-2xl font-bold mb-6 text-center">Validation des Boutiques</h1>

        <!-- Message dynamique -->
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="mb-4 p-4 bg-yellow-100 text-yellow-700 rounded">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- Tableau -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full max-w-5xl mx-auto">
            <table class="w-full bg-white border border-gray-300">
                <thead class="bg-black text-white text-sm">
                    <tr>
                        <th class="py-2 px-2">Id</th>
                        <th class="py-2 px-2">Nom Complet</th>
                        <th class="py-2 px-2">Email</th>
                        <th class="py-2 px-2">Nom Boutique</th>
                        <th class="py-2 px-2">Adresse</th>
                        <th class="py-2 px-2">Ville</th>
                        <th class="py-2 px-2">Pays</th>
                        <th class="py-2 px-2">Horaires</th>
                        <th class="py-2 px-2">Contact</th>
                        <th class="py-2 px-2">Statut</th>
                        <th class="py-2 px-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="border-b">
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['nom_complet'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['nom_boutique'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['adresse_boutique'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['ville'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['pays'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['horaires_ouverture'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2"><?php echo htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-2 px-2">
                                <?php
                                    if ($row['status'] == "en_attente") {
                                        echo "<span class='bg-yellow-500 text-white px-2 py-1 rounded'>Attente</span>";
                                    } elseif ($row['status'] == "validé") {
                                        echo "<span class='bg-green-500 text-white px-2 py-1 rounded'>Validé</span>";
                                    } else {
                                        echo "<span class='bg-red-500 text-white px-2 py-1 rounded'>Rejeté</span>";
                                    }
                                ?>
                            </td>
                            <td class="py-2 px-2 flex justify-center gap-1">
                                <form method="POST" action="validate-shop.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="valider">
                                    <button type="submit" class="bg-green-500 text-white text-xs px-2 py-1 rounded hover:bg-green-600">✔</button>
                                </form>
                                <form method="POST" action="validate-shop.php">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="rejeter">
                                    <button type="submit" class="bg-red-500 text-white text-xs px-2 py-1 rounded hover:bg-red-600">✖</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</div>
<?php
// Fermer la connexion
mysqli_close($conn);
include('./templates/footer.php');
?>
