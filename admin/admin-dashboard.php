<?php
include('./templates/header.php');
session_start(); // Démarrer la session pour récupérer les données
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

include('sidebar2.php')
?>



<?php
include('./templates/footer.php');
?>