<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../admin/config/db.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // ✅ Indiquer que la réponse sera JSON

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['commande_id']) && isset($_POST['statut'])) {
    $commande_id = intval($_POST['commande_id']);
    $new_status = $_POST['statut'];

    // ✅ Mise à jour du statut de la commande
    $stmt = $conn->prepare("UPDATE commandes SET statut = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $commande_id);
    if (!$stmt->execute()) {
        $response['error'] = "Erreur SQL: " . $stmt->error;
        echo json_encode($response);
        exit();
    }
    $stmt->close();

    // ✅ Récupérer les infos de la commande et du client
    $stmt = $conn->prepare("
        SELECT commandes.total, users.email, users.nom 
        FROM commandes 
        LEFT JOIN users ON commandes.user_id = users.id 
        WHERE commandes.id = ?
    ");
    $stmt->bind_param("i", $commande_id);
    $stmt->execute();
    $stmt->bind_result($total, $email, $nom);
    $stmt->fetch();
    $stmt->close();

    if ($email) { // ✅ Vérifier si l'email existe avant d'envoyer le mail
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'keitaabdoukarim2025@gmail.com';
            $mail->Password = 'agft wxgr dcrl zrtq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('keitaabdoukarim2025@gmail.com', 'SoumAfrique');
            $mail->addAddress($email, $nom);
            $mail->isHTML(true);
            $mail->Subject = "Mise à jour de votre commande #$commande_id";

            if ($new_status == 'confirmé') {
                $mail->Body = "Bonjour $nom,<br><br>Votre commande #$commande_id a été confirmée.<br>Montant à régler : <strong>$total €</strong> à la livraison.<br><br>Merci de votre confiance.<br>L'équipe SoumAfrique";
            } elseif ($new_status == 'annulé') {
                $mail->Body = "Bonjour $nom,<br><br>Votre commande #$commande_id a été annulée.<br><br>L'équipe SoumAfrique";
            }

            $mail->send();
            $response['success'] = "Commande mise à jour et email envoyé.";
        } catch (Exception $e) {
            $response['error'] = "Erreur d'envoi d'email : " . $mail->ErrorInfo;
        }
    } else {
        $response['success'] = "Commande mise à jour mais pas d'email envoyé (client sans email).";
    }

    echo json_encode($response);
    exit();
} else {
    echo json_encode(["error" => "Requête invalide."]);
    exit();
}
?>
