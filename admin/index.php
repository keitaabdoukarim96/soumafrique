<?php
session_start();
include('./templates/header.php');
include('./config/db.php'); // Fichier de connexion à la base de données

// Initialisation des variables pour les erreurs et valeurs
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'email est vide
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez entrer votre adresse email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Vérifier si le mot de passe est vide
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer votre mot de passe.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Si aucun champ n'est vide, vérifier les informations dans la base de données
    if (empty($email_err) && empty($password_err)) {
        // Vérifier d'abord si l'utilisateur est un admin
        $sql = "SELECT id, nom, email, mot_de_passe FROM admin WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $nom, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (hash('sha256', $password) === $hashed_password) {
                            // Mot de passe correct pour l'admin
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nom"] = $nom;
                            $_SESSION["role"] = "admin_role";
                            header("location: admin-dashboard.php");
                            exit;
                        } else {
                            $login_err = "Email ou mot de passe incorrect.";
                        }
                    }
                } else {
                    // Si pas admin, vérifier dans la table des propriétaires
                    $sql_proprietaire = "SELECT id, nom_complet, email, password_temporaire FROM proprietaire WHERE email = ?";
                    if ($stmt_proprietaire = mysqli_prepare($conn, $sql_proprietaire)) {
                        mysqli_stmt_bind_param($stmt_proprietaire, "s", $param_email);

                        if (mysqli_stmt_execute($stmt_proprietaire)) {
                            mysqli_stmt_store_result($stmt_proprietaire);

                            if (mysqli_stmt_num_rows($stmt_proprietaire) == 1) {
                                mysqli_stmt_bind_result($stmt_proprietaire, $id, $nom_complet, $email, $hashed_password_temp);
                                if (mysqli_stmt_fetch($stmt_proprietaire)) {
                                    if (password_verify($password, $hashed_password_temp)) {
                                        $_SESSION["loggedin"] = true;
                                        $_SESSION["id"] = $id;
                                        $_SESSION["nom"] = $nom_complet;
                                        $_SESSION["role"] = "propriétaire";
                                        header("location: admin-dashboard.php");
                                        exit;
                                    } else {
                                        $login_err = "Email ou mot de passe incorrect.";
                                    }
                                }
                            } else {
                                $login_err = "Aucun compte trouvé avec cet email.";
                            }
                        }
                        mysqli_stmt_close($stmt_proprietaire);
                    }
                }
            } else {
                $login_err = "Erreur de connexion. Veuillez réessayer.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>

<main class="flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>

    <!-- Affichage des erreurs -->
    <?php if (!empty($login_err)): ?>
      <p class="text-red-500 text-center mb-4"><?php echo $login_err; ?></p>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <!-- Email -->
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Adresse Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" 
               class="w-full py-2 px-4 border rounded-lg <?php echo (!empty($email_err)) ? 'border-red-500' : ''; ?>">
        <p class="text-red-500 text-sm"><?php echo $email_err; ?></p>
      </div>

      <!-- Mot de passe -->
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Mot de passe</label>
        <input type="password" name="password" class="w-full py-2 px-4 border rounded-lg <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>">
        <p class="text-red-500 text-sm"><?php echo $password_err; ?></p>
      </div>

      <!-- Bouton -->
      <button type="submit" class="btn-gradient text-white w-full py-2 px-4 rounded-lg font-bold">
        Se connecter
      </button>
    </form>
  </div>
</main>

<?php include('./templates/footer.php'); ?>
