<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM Model";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model</title>
    <link rel="stylesheet" href="../styles/styleTabele.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-icon">
                <a href="interogari/interogare2.php" title="Cele mai bune modele">
                    <i class="fa-solid fa-crown"> TOP</i>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="CRUD/add_model.php">Add new Model</a></li>
                <li><a href="homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="title">Model</h1>
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2 class="model-title">
                        <?php echo $row['Nume'] . " " . $row['Prenume'] . " ." . $row['ID_Model']; ?>
                    </h2>
                    <p><strong>Vârstă:</strong> <?php echo $row['Varsta']; ?></p>
                    <p><strong>Înălțime:</strong> <?php echo $row['Inaltime']; ?> cm</p>
                    <p><strong>Sex:</strong> <?php echo $row['Sex']; ?></p>
                    <a href="CRUD/delete_model.php?ID_Model=<?php echo $row['ID_Model']; ?>" class="details-button" onclick="return confirm('Ești sigur că vrei să ștergi acest model?')">Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
