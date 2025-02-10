<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET['ID_Model'])) {
    $id_model = $_GET['ID_Model'];

    $query = "DELETE FROM Model WHERE ID_Model = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_model);

    if ($stmt->execute()) {
        header("Location: ../model.php");
        exit;
    } else {
        echo "Eroare la ștergerea Modelului: " . $stmt->error;
    }
} else {
    header("Location: ../model.php");
    exit;
}
?>
