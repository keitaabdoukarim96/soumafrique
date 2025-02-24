<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../admin/config/db.php');

header('Content-Type: application/json'); // Important pour s'assurer qu'on envoie du JSON

$errors = [];
$response = ["success" => false, "errors" => []];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_complet = trim($_POST['nom_complet'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_repeat = trim($_POST['password_repeat'] ?? '');

    // Validation
    if (empty($nom_complet)) {
        $errors['nom_complet'] = "Le nom complet est requis.";
    }
    if (empty($email)) {
        $errors['email'] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    } else {
        // Vérifie si l'email existe déjà
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }
        $stmt->close();
    }
    if (empty($password)) {
        $errors['password'] = "Le mot de passe est requis.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if ($password !== $password_repeat) {
        $errors['password_repeat'] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur, insérer dans la base de données
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (nom_complet, email, mot_de_passe) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom_complet, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_name'] = $nom_complet;
            $response['success'] = true;
        } else {
            $response['errors']['general'] = "Erreur lors de l'inscription.";
        }

        $stmt->close();
    } else {
        $response['errors'] = $errors;
    }
} else {
    $response['errors']['general'] = "Requête invalide.";
}

echo json_encode($response);
?>
