<?php
session_start();
include("../logic/connect.php");
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM Designer";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer</title>
    <link rel="stylesheet" href="../styles/styleTabele.css">
</head>
<body>
     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="CRUD/add_designer.php">Add new Designer</a></li>
                <li><a href="homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="title">Designer</h1>
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2 class="designer-title">
                        <?php echo $row['Nume'] . " " . $row['Prenume'] . " ." . $row['ID_Designer']; ; ?>
                    </h2>
                    <p><strong>Cod CV:</strong> <?php echo $row['Cod_CV']; ?></p>
                    <p><strong>Ani Experiență:</strong> <?php echo $row['Ani_experienta']; ?></p>
                    <a href="interogari/interogare4.php?id_designer=<?php echo $row['ID_Designer']; ?>" class="action-button">New Collections</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
