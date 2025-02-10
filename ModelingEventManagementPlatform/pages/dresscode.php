<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM DressCode";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dress Code</title>
    <link rel="stylesheet" href="../styles/styleTabele.css">
</head>
<body>
     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="CRUD/add_dresscode.php">Add new Dresscode</a></li>
                <li><a href="homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="title">DressCode</h1>
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2 class="dresscode-title">
                        <?php echo $row['Denumire'] . " ." . $row['ID_DressCode']; ?>
                    </h2>
                    <p><strong>Descriere:</strong> <?php echo $row['Descriere']; ?></p>
                    <p><strong>Culori Predominante:</strong> <?php echo $row['Culori_Predominante']; ?></p>
                    <a href="CRUD/edit_dresscode.php?ID_DressCode=<?php echo $row['ID_DressCode']; ?>" class="details-button">Edit</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
