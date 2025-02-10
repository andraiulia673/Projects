<?php
session_start();
include("../logic/connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../styles/styleHomepage.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <a href="homepage.php">RM Agency</a>
            </div>
            <ul class="nav-links">
                <li><a href="interogari/interogare3.php">To do list</a></li>
                <li><a href="interogari/interogare11.php">Contact Us</a></li>
                <li><a href="accountDetails.php">Account</a></li>
                <li><a href="../logic/logoutLogic.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <header>
        <h1>Welcome, 
            <?php 
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT * FROM manager_evenimente WHERE email='$email'");
                while ($row = mysqli_fetch_array($query)) {
                    echo $row['firstName'] . ' ' . $row['lastName'];
                }
            }
            ?>
        </h1>
    </header>

    <div class="container">
        <div class="card">
            <img src="https://media.lanecrawford.com/feature/MW-PARTY-STORY-191114-img4.jpg" alt="DressCode">
            <h2>Dress Code</h2>
            <a href="dresscode.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://i.pinimg.com/736x/8d/eb/2f/8deb2f0c0fbd744072913e13b06d7301.jpg" alt="Designer">
            <h2>Designer</h2>
            <a href="designer.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://dxcmodels.com/wp-content/uploads/2024/04/black-model789.jpg" alt="Model">
            <h2>Model</h2>
            <a href="model.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://i.pinimg.com/originals/72/b2/df/72b2dfbe37c2fce59db17e31b2693627.jpg" alt="Colectie Haine">
            <h2>Colectie Haine</h2>
            <a href="colectie_haine.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://imgcdn.stablediffusionweb.com/2024/9/18/9ad76916-43e5-4088-89a6-190a14b6e762.jpg" alt="Eveniment">
            <h2>Eveniment</h2>
            <a href="eveniment.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://i.pinimg.com/736x/01/48/d3/0148d30ff1d9a0680a798b288e25d22e.jpg" alt="Eveniment Model">
            <h2>Eveniment Model</h2>
            <a href="eveniment_model.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://assets.vogue.com/photos/59c53da95c439417d61705d3/master/w_1280%2Cc_limit/_VER0037.jpg" alt="Model Colectie Haine">
            <h2>Model Colectie Haine</h2>
            <a href="model_colectie_haine.php" class="btn">View</a>
        </div>
        <div class="card">
            <img src="https://i.etsystatic.com/48309664/r/il/7b903c/6395409634/il_fullxfull.6395409634_h6j0.jpg" alt="Culorile Anului">
            <h2>Culorile Anului</h2>
            <a href="interogari/interogare7_8.php" class="btn">View</a>
        </div>
    </div>
</body>
</html>
