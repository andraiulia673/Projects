<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Eveniment']) && isset($_GET['ID_Model'])) {
    $id_eveniment = $_GET['ID_Eveniment'];
    $id_model = $_GET['ID_Model'];

    $query = "DELETE FROM Eveniment_Model WHERE ID_Eveniment = ? AND ID_Model = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_eveniment, $id_model);

    if ($stmt->execute()) {
        header("Location: ../eveniment_model.php");
        exit;
    } else {
        echo "Eroare la ștergerea asocierii Eveniment-Model: " . $stmt->error;
    }
} else {
    header("Location: ../eveniment_model.php");
    exit;
}
?>
