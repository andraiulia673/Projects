<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Colectie_Haine'])) {
    $id_colectie = $_GET['ID_Colectie_Haine'];

    $query = "DELETE FROM Colectie_haine WHERE ID_Colectie_Haine = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_colectie);

    if ($stmt->execute()) {
        header("Location: ../colectie_haine.php");
        exit;
    } else {
        echo "Eroare la ștergerea Colecției de haine: " . $stmt->error;
    }
} else {
    header("Location: ../colectie_haine.php");
    exit;
}
?>
