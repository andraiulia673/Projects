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
    <title>Edit Account</title>
    <link rel="stylesheet" href="../styles/styleHomepage.css">
</head>
<body>
    <div class="account-edit">
        <h1>Edit Account Details</h1>
        <div id="error-message" class="error-message" style="display: none;"></div>

        <form method="POST" action="../logic/editAccountLogic.php">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" value="<?php echo $user['firstName']; ?>" required>
            
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" value="<?php echo $user['lastName']; ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
            
            <button type="submit" class="save-button">Save Changes</button>
        </form>
        <a href="../pages/accountDetails.php" class="back-button">Back</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
                if (error) {
                const errorMessageDiv = document.getElementById('error-message');
                errorMessageDiv.innerText = decodeURIComponent(error);
                errorMessageDiv.style.display = 'block';
                errorMessageDiv.style.color = 'red';
                errorMessageDiv.style.textAlign = 'center';
                errorMessageDiv.style.marginTop = '20px';
                errorMessageDiv.style.border = '1px solid red';
                errorMessageDiv.style.padding = '10px';
                errorMessageDiv.style.borderRadius = '5px';
                errorMessageDiv.style.backgroundColor = '#ffe6e6';
            }
        });
    </script>
</body>
</html>
