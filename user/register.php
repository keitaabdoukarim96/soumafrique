<?php
session_start();
include('../admin/config/db.php');

$message = ""; // Message d'erreur ou de succès

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_confirm = trim($_POST["password_confirm"]);

    // Vérification des champs obligatoires
    if (empty($nom) || empty($email) || empty($password) || empty($password_confirm)) {
        $message = "Tous les champs sont obligatoires !";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'email est invalide.";
    } elseif ($password !== $password_confirm) {
        $message = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $message = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Cet email est déjà utilisé.";
        } else {
            // Hasher le mot de passe
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur
            $stmt = $conn->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nom, $email, $password_hash);

            if ($stmt->execute()) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $message = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Inscription</h2>

        <?php if ($message) : ?>
            <div class="mb-4 text-red-500 text-sm text-center"><?= $message ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-4">
            <input type="text" name="nom" placeholder="Nom" class="w-full p-2 border rounded-lg">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded-lg">
            <input type="password" name="password" placeholder="Mot de passe" class="w-full p-2 border rounded-lg">
            <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" class="w-full p-2 border rounded-lg">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">S'inscrire</button>
        </form>
        <p class="mt-4 text-center text-sm">Déjà inscrit ? <a href="login.php" class="text-blue-500">Se connecter</a></p>
    </div>
</body>
</html>
