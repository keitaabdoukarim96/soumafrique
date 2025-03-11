<?php
session_start();
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session

header("Location: login.php?logout=1"); // Redirection avec message de déconnexion
exit();
