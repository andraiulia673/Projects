<?php
session_start();
include("../../logic/connect.php");


if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Eveniment'])) {
    $id_eveniment = $_GET['ID_Eveniment'];

    $query = "DELETE FROM Eveniment WHERE ID_Eveniment = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_eveniment);

    if ($stmt->execute()) {
        header("Location: ../eveniment.php");
        exit;
    } else {
        echo "Eroare la ștergerea evenimentului: " . $stmt->error;
    }
} else {
    header("Location: ../eveniment.php");
    exit;
}
?>
