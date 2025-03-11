<?php
header('Content-Type: text/html; charset=utf-8');
include('../admin/config/db.php');
mysqli_set_charset($conn, "utf8mb4");
include('./templates/header.php');

$message = "";
$message_type = "text-red-500";
$edit_mode = false;
$id = "";
$name = "";
$email = "";
$role = "";

// Vérifier si on est en mode modification
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT nom, email, role FROM admin WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $name = $row['nom'];
        $email = $row['email'];
        $role = $row['role'];
        $edit_mode = true;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $date_creation = date("Y-m-d H:i:s");

    if (empty($name) || empty($email) || empty($role)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email est invalide.";
    } else {
        if ($edit_mode) {
            $stmt = $conn->prepare("UPDATE admin SET nom = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $role, $id);
            if ($stmt->execute()) {
                header("Location: edit-sous-admin.php?success=1");
                exit();
            } else {
                $message = "Erreur lors de la mise à jour.";
            }
        }
        $stmt->close();
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = "Utilisateur modifié avec succès.";
    $message_type = "text-green-500";
}
?>

<div class="flex min-h-screen">
    <?php include('sidebar2.php'); ?>
    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-lg font-bold mb-4 text-center">Modifier un sous-admin</h2>
            <?php if (!empty($message)) { echo "<p id='message' class='$message_type text-center'>$message</p>"; } ?>
            <form method="POST" id="edit-form">
                <input type='hidden' name='id' value='<?php echo $id; ?>'>
                <div class="mb-4">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="w-full border rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="w-full border rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="role">Rôle :</label>
                    <select id="role" name="role" class="w-full border rounded-lg p-2">
                        <option value="admin" <?php echo $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="utilisateur" <?php echo $role == 'utilisateur' ? 'selected' : ''; ?>>Utilisateur</option>
                        <option value="moderateur" <?php echo $role == 'moderateur' ? 'selected' : ''; ?>>Propriétaire</option>
                        <option value="sous-admin" <?php echo $role == 'sous-admin' ? 'selected' : ''; ?>>Sous Admin</option>
                    </select>
                </div>
                <div class="flex justify-center">
                    <button type="submit" id="submit-button" class="text-white py-2 px-4 rounded-lg btn-gradient" disabled>Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById("edit-form");
    const submitButton = document.getElementById("submit-button");
    const inputs = form.querySelectorAll("input, select");
    
    let initialData = {
        name: "<?php echo addslashes($name); ?>",
        email: "<?php echo addslashes($email); ?>",
        role: "<?php echo addslashes($role); ?>"
    };
    
    form.addEventListener("input", function() {
        let hasChanges = false;
        inputs.forEach(input => {
            if (input.type === "text" || input.type === "email" || input.tagName === "SELECT") {
                if (input.value !== initialData[input.name]) {
                    hasChanges = true;
                }
            }
        });
        submitButton.disabled = !hasChanges;
    });
</script>

<?php include('./templates/footer.php'); ?>
