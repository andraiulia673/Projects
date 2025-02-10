<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $newEmail = $_POST['email'];
    $password = $_POST['password'];
    $emailCheckQuery = "SELECT * FROM manager_evenimente WHERE email='$newEmail' AND email != '$email'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        header("Location: ../pages/editAccount.php?error=Email-ul este deja folosit!");
        exit;
    }
    $passwordCheckQuery = "SELECT * FROM manager_evenimente WHERE password='$password' AND email != '$email'";
    $passwordCheckResult = mysqli_query($conn, $passwordCheckQuery);

    if (mysqli_num_rows($passwordCheckResult) > 0) {
        header("Location: ../pages/editAccount.php?error=Parola este deja folosită!");
        exit;
    }

    $updateQuery = "UPDATE manager_evenimente SET firstName='$firstName', lastName='$lastName', email='$newEmail', password='$password' WHERE email='$email'";
    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['email'] = $newEmail;
        header("Location: ../pages/accountDetails.php");
        exit;
    } else {
        header("Location: ../pages/editAccount.php?error=Eroare la actualizarea contului!");
        exit;
    }
}
