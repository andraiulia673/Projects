<?php
session_start();
include("connect.php");

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $deleteQuery = "DELETE FROM manager_evenimente WHERE email='$email'";
    if (mysqli_query($conn, $deleteQuery)) {
        session_destroy();
        header("Location: ../pages/login.php");
    } else {
        echo "Eroare la ștergerea contului.";
    }
} else {
    header("Location: ../pages/login.php");
}
?>
