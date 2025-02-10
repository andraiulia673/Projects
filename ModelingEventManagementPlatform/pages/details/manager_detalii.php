<?php
session_start();
include("../../logic/connect.php");


if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_manager'])) {
    $id_manager = intval($_GET['ID_manager']);
    $query = "SELECT * FROM Manager_evenimente WHERE ID_manager = $id_manager";
    $result = mysqli_query($conn, $query);
    $manager = mysqli_fetch_assoc($result);
} else {
    header("Location: ../eveniment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Manager</title>
    <link rel="stylesheet" href="../../styles/styleDetalii.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Detalii Manager</h1>
        
        <?php if ($manager) { ?>
            <div class="card">
                <h2><?php echo $manager['firstName'] . " " . $manager['lastName']; ?></h2>
                <p><strong>Email:</strong> <?php echo $manager['email']; ?></p>
            </div>
        <?php } else { ?>
            <p>Managerul nu a fost găsit.</p>
        <?php } ?>
        
        <a href="../eveniment.php" class="back-button">Înapoi</a>
    </div>
</body>
</html>
