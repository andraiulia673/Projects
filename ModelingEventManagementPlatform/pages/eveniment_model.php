<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM Eveniment_Model";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eveniment Model</title>
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
        <h1 class="title">Eveniment - Model</h1>
        
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2 class="eveniment-model-title">
                        Eveniment: <?php echo $row['ID_Eveniment']; ?> | Model: <?php echo $row['ID_Model']; ?>
                    </h2>
                    <p><strong>Număr Intrare:</strong> <?php echo $row['Nr_intrare']; ?></p>
                    <p><strong>Melodie Defilare:</strong> <?php echo $row['Melodie_defilare']; ?></p>
                    <a href="CRUD/edit_eveniment_model.php?ID_Eveniment=<?php echo $row['ID_Eveniment']; ?>&ID_Model=<?php echo $row['ID_Model']; ?>" class="action-button">Edit</a>
                    <a href="CRUD/delete_eveniment_model.php?ID_Eveniment=<?php echo $row['ID_Eveniment']; ?>&ID_Model=<?php echo $row['ID_Model']; ?>" class="action-button"  onclick="return confirm('Are you sure you want to delete this entry?');">Delete</a>
                </div>
            <?php } ?>
</body>
</html>
