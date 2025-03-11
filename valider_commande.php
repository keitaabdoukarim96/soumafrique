<?php
session_start();
include('admin/config/db.php');
require 'vendor/autoload.php'; // 📌 Pour PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $adresse = trim($_POST["adresse"]);
    $telephone = trim($_POST["telephone"]);
    $disponibilite = trim($_POST["disponibilite"]);
    $total = $_POST["total"];

    // Insérer la commande dans la table `commandes`
    $stmt = $conn->prepare("INSERT INTO commandes (user_id, total, statut) VALUES (?, ?, 'en_attente')");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $commande_id = $stmt->insert_id;
    $stmt->close();

    // Récupérer les articles du panier
    $query = "SELECT produit_id, quantite, prix FROM panier WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $panier_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Enregistrer les détails de la commande
    foreach ($panier_items as $item) {
        $stmt = $conn->prepare("INSERT INTO details_commande (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $commande_id, $item["produit_id"], $item["quantite"], $item["prix"]);
        $stmt->execute();
        $stmt->close();
    }

    // Vider le panier de l'utilisateur
    $stmt = $conn->prepare("DELETE FROM panier WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Récupérer l'email de l'utilisateur
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_email);
    $stmt->fetch();
    $stmt->close();

    // 📧 Envoi de l'email de confirmation
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'keitaabdoukarim2025@gmail.com'; // 🔴 Remplace par ton email
        $mail->Password = 'agft wxgr dcrl zrtq'; // 🔴 Remplace par ton mot de passe ou un mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('keitaabdoukarim2025@gmail.com', 'SoumAfrique');
        $mail->addAddress($user_email);

        $mail->isHTML(true);
        $mail->Subject = "Confirmation de votre commande #$commande_id";
        $mail->Body = "Bonjour,<br>Votre commande a bien été enregistrée avec un total de <b>$total €</b>.<br>Adresse : $adresse<br>Téléphone : $telephone<br>Disponibilité : $disponibilite<br>Merci pour votre achat !";

        $mail->send();
    } catch (Exception $e) {}

    // Redirection vers la confirmation
    header("Location: confirmation.php?commande_id=$commande_id");
    exit();
}
?>
