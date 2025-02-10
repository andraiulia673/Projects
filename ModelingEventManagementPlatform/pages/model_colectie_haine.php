<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM Model_Colectie_haine";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Colectie Haine</title>
    <link rel="stylesheet" href="../styles/styleTabele.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="title">Model-Colectie Haine</h1>
        
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2 class="model-colectie-title">
                        Model: <?php echo $row['ID_Model']; ?> | Colecție: <?php echo $row['ID_Colectie_haine']; ?>
                    </h2>
                    <p><strong>Dimensiuni:</strong> <?php echo $row['Dimensiuni']; ?></p>
                    <p><strong>Ajustări:</strong> <?php echo $row['Ajustari']; ?></p>
                    <a href="interogari/interogare5.php?id_colectie=<?php echo $row['ID_Colectie_haine']; ?>&id_model=<?php echo $row['ID_Model']; ?>" class="action-button">See Adjustments</a>
                </div>
            <?php } ?>
</body>
</html>
