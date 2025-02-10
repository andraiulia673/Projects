<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id_designer'])) {
    $id_designer = intval($_GET['id_designer']);
    $query = "SELECT * FROM Designer WHERE ID_Designer = $id_designer";
    $result = mysqli_query($conn, $query);
    $designer = mysqli_fetch_assoc($result);
} else {
    header("Location: ../model.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Designer</title>
    <link rel="stylesheet" href="../../styles/styleDetalii.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Detalii Designer</h1>
        
        <?php if ($designer) { ?>
            <div class="card">
                <h2 class="designer-title">
                    <?php echo $designer['Nume'] . " " . $designer['Prenume']; ?>
                </h2>
                <p><strong>Cod CV:</strong> <?php echo $designer['Cod_CV']; ?></p>
                <p><strong>Ani Experiență:</strong> <?php echo $designer['Ani_experienta']; ?></p>
            </div>
        <?php } else { ?>
            <p>Designerul nu a fost găsit.</p>
        <?php } ?>
        
        <a href="../colectie_haine.php" class="back-button">Înapoi</a>
    </div>
</body>
</html>
