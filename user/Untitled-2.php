<?php
include 'db.php';

$message = ""; // Variable pour stocker les messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
    $date_naissance = $_POST['date_naissance'];

    // Vérifier si l'email existe déjà
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        // Message d'erreur pour l'email déjà utilisé
        $message = "<div class='message-box error'>Email déjà utilisé. Veuillez en choisir un autre.</div>";
    } else {
        // Insertion dans la base de données
        $sql = "INSERT INTO users (nom_complet, email, mot_de_passe) 
                VALUES ('$username', '$firstname', '$email', '$password', '$date_naissance')";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='message-box success'>Inscription réussie ! <a href='login.php'>Cliquez ici pour vous connecter</a></div>";
        } else {
            $message = "<div class='message-box error'>Erreur lors de l'inscription : " . $conn->error . "</div>";
        }
    }
}
?>
