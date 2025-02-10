<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM Colectie_haine";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colectie Haine</title>
    <link rel="stylesheet" href="../styles/styleTabele.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="interogari/interogare1.php">See Compatibility</a></li>
                <li><a href="homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="title">Colecții Haine</h1>
        
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2 class="colectie-title">
                        <?php echo $row['Denumire'] . " ." . $row['ID_Colectie_Haine']; ; ?>
                    </h2>
                    <p><strong>Descriere:</strong> <?php echo $row['Descriere']; ?></p>
                    <p><strong>An Creație:</strong> <?php echo $row['An_creatie']; ?></p>
                    <a href="details/dresscode_detalii.php?id_dresscode=<?php echo $row['ID_DressCode']; ?>" class="details-button">View DressCode</a>
                    <a href="details/designer_detalii.php?id_designer=<?php echo $row['ID_Designer']; ?>" class="details-button">View Designer</a>
                </div>
            <?php } ?>
</body>
</html>
