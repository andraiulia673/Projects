<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

$query = "SELECT * FROM Eveniment";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenimente</title>
    <link rel="stylesheet" href="../styles/styleTabele.css">
</head>
<body>

     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="interogari/interogare10.php">Program</a></li>
                <li><a href="interogari/interogare9.php">Find us</a></li>
                <li><a href="homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="title">Evenimente</h1>
        <div class="card-container">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <h2><?php echo $row['Denumire']; ?></h2>
                    <p><strong>Locație:</strong> <?php echo $row['Locatie']; ?></p>
                    <p><strong>Data și ora:</strong> <?php echo $row['Data_si_ora']; ?></p>
                    <p><strong>Organizator:</strong> <?php echo $row['Nume_organizator']; ?></p>
                    <a href="details/manager_detalii.php?ID_manager=<?php echo $row['ID_manager']; ?>" class="details-button">View Manager</a>
                    <a href="interogari/interogare6.php?ID_Eveniment=<?php echo $row['ID_Eveniment']; ?>" class="details-button">See Timeline</a>
                    <a href="CRUD/edit_eveniment.php?ID_Eveniment=<?php echo $row['ID_Eveniment']; ?>" class="details-button">Edit</a>
                    <a href="CRUD/delete_eveniment.php?ID_Eveniment=<?php echo $row['ID_Eveniment']; ?>" class="details-button" onclick="return confirm('Ești sigur că vrei să ștergi acest eveniment?')">Delete</a>
                </div>
            <?php } ?>
</body>
</html>
