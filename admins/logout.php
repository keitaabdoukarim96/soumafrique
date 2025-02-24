<?php
session_start(); // Démarrer la session

// Détruire toutes les sessions
$_SESSION = array();
session_destroy();

// Rediriger vers la page de connexion
header("Location: index.php");
exit;
?>
