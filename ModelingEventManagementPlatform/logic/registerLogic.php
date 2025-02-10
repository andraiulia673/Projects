<?php 

include 'connect.php';

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkEmail = "SELECT * FROM manager_evenimente WHERE email='$email'";
    $resultEmail = $conn->query($checkEmail);
    $checkPassword = "SELECT * FROM manager_evenimente WHERE password='$password'";
    $resultPassword = $conn->query($checkPassword);

    if ($resultEmail->num_rows > 0) {
        header("Location: ../pages/register.php?error=Emailul%20exista%20deja");
        exit();
    } 
    else if($resultPassword->num_rows > 0){
        header("Location: ../pages/register.php?error=Parola%20exista%20deja");
        exit();
    }
    else {
        $insertQuery = "INSERT INTO manager_evenimente (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: ../pages/login.php");
            exit();
        } else {
            header("Location: ../pages/register.php?error=Database%20Error");
            exit();
        }
    }
}
?>
