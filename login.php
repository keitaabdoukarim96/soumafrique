<?php
session_start();
include('admin/config/db.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

   

    if (empty($email) || empty($password)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $conn->prepare("SELECT id, nom, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nom, $hashed_password);
        $stmt->fetch();


        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
           
            header("Location: index.php");
            exit();
        } else {
            $message = "Email ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Connexion</h2>

        <?php if ($message) : ?>
            <div class="mb-4 text-red-500 text-sm text-center"><?= $message ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
            <div class="mb-4 text-green-500 text-sm text-center bg-green-100 p-2 rounded-lg">
                ✅ Inscription réussie ! Vous pouvez maintenant vous connecter.
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 1) : ?>
            <div class="mb-4 text-blue-500 text-sm text-center bg-blue-100 p-2 rounded-lg">
                ✅ Vous avez été déconnecté avec succès.
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded-lg">
            <input type="password" name="password" placeholder="Mot de passe" class="w-full p-2 border rounded-lg">
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-lg">Se connecter</button>
        </form>
        <p class="mt-4 text-center text-sm">Pas encore inscrit ? <a href="register.php" class="text-blue-500">S'inscrire</a></p>
    </div>
</body>
</html>
