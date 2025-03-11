<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

$message = "";
$message_type = "text-red-500"; // Par défaut, erreur en rouge

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = trim($_POST['role']);
    $date_creation = date("Y-m-d H:i:s");

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email est invalide.";
    } elseif ($password !== $confirm_password) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Cet email est déjà utilisé.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO admin (nom, email, mot_de_passe, date_creation, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $date_creation, $role);

            if ($stmt->execute()) {
                // Redirection après succès pour éviter les réinsertions
                header("Location: add-sous-admin.php?success=1");
                exit();
            } else {
                $message = "Erreur lors de l'ajout de l'utilisateur.";
            }
        }
        $stmt->close();
    }
}

// Vérifier si une redirection après succès a eu lieu
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Utilisateur ajouté avec succès.";
    $message_type = "text-green-500";
}
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center">Ajouter un sous admin</h2>
            <?php if (!empty($message)) { echo "<p id='message' class='$message_type text-center'>$message</p>"; } ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" required class="w-full border rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required class="w-full border rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="role">Rôle :</label>
                    <select id="role" name="role" class="w-full border rounded-lg p-2">
                        <option value="admin">Admin</option>
                        <option value="utilisateur">Utilisateur</option>
                        <option value="moderateur">Propriétaire</option>
                        <option value="sous-admin">Sous Admin</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required class="w-full border rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="confirm_password">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password" required class="w-full border rounded-lg p-2">
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="text-white py-2 px-4 rounded-lg btn-gradient">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Faire disparaître le message après 3 secondes
    setTimeout(function() {
        let messageElement = document.getElementById('message');
        if (messageElement) {
            messageElement.style.display = 'none';
        }
    }, 3000);
</script>

<?php include('./templates/footer.php'); ?>
