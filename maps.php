<?php
include('admin/config/db.php');
header('Content-Type: application/json');

$query = "SELECT id, nom_epice, adresse, latitude, longitude FROM epicerie WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($query);
$epiceries = [];

while ($row = $result->fetch_assoc()) {
    $epiceries[] = $row;
}

echo json_encode($epiceries);
?>
