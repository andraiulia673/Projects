<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../pages/login.php");
    exit;
}

$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM manager_evenimente WHERE email='$email'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Cont</title>
    <link rel="stylesheet" href="../styles/styleHomepage.css">
</head>
<body>
    <div class="account-details">
        <h1>Account Details</h1>
        <p><strong>ID Manager:</strong> <?php echo $user['ID_manager']; ?></p>
        <p><strong>Name</strong> <?php echo $user['firstName'] . ' ' . $user['lastName']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Password:</strong> <span class="hidden-password">••••••••</span></p>
        
        <div class="account-options">
            <a href="editAccount.php" class="edit-button">Edit</a>
            <a href="../logic/deleteAccountLogic.php" class="delete-button" onclick="return confirm('Are you sure?');">Delete</a>
        </div>
        <a href="homepage.php" class="back-button">Back</a>
    </div>
</body>
</html>
