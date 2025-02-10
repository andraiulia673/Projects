<?php 

include 'connect.php';

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkEmail = "SELECT * FROM manager_evenimente WHERE email='$email'";
    $resultEmail = $conn->query($checkEmail);

    $checkPassword = "SELECT * FROM manager_evenimente WHERE password='$password'";
    $resultPassword = $conn->query($checkPassword);

    if ($resultEmail->num_rows > 0 && $resultPassword->num_rows > 0) {
        session_start();
        $row = $resultEmail->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: ../pages/homepage.php");
        exit();
    } else if ($resultEmail->num_rows == 0){
        header("Location: ../pages/login.php?error=Emailul%20nu%20exista");
        exit();
    }
    if ($resultPassword->num_rows == 0){
        header("Location: ../pages/login.php?error=Parola%20nu%20exista");
        exit();
    }
}
?>
