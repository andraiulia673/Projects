<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../styles/styleLoginRegister.css">
</head>
<body>
    <video autoplay muted loop id="video-background">
        <source src="../styles/fundal_proiect.mp4" type="video/mp4">
    </video>
    <div class="container" id="signIn">
        <h1 class="form-title">Login</h1>
        <form method="post" action="../logic/loginLogic.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <div id="error-message" class="error-message" style="display: none;"></div>

        <div class="links">
            <p>Don't have an account yet?</p>
            <a href="register.php"><button id="signUpButton">Sign Up</button></a>
        </div>
    </div>

    <script src="../scripts/scriptLogin.js"></script>
</body>
</html>
