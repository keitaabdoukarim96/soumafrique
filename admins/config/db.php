<?php
// Informations de connexion à la base de données
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Remplacez par votre utilisateur MySQL
define('DB_PASSWORD', ''); // Remplacez par votre mot de passe MySQL
define('DB_NAME', 'soumafrique');

// Connexion à la base de données
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}
?>
