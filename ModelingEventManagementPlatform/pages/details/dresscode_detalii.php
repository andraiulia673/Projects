<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id_dresscode'])) {
    $id_dresscode = intval($_GET['id_dresscode']);
    $query = "SELECT * FROM DressCode WHERE id_dresscode = $id_dresscode";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        $dresscode = null;
    } else {
        $dresscode = mysqli_fetch_assoc($result);
    }
} else {
    header("Location: ../colectie_haine.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii DressCode</title>
    <link rel="stylesheet" href="../../styles/styleDetalii.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Detalii DressCode</h1>
        
        <?php if ($dresscode) { ?>
            <div class="card">
                <h2 class="dresscode-title">
                    <?php echo $dresscode['Denumire'] . " - ID: " . $dresscode['ID_DressCode']; ?>
                </h2>
                <p><strong>Descriere:</strong> <?php echo $dresscode['Descriere']; ?></p>
                <p><strong>Culori Predominante:</strong> <?php echo $dresscode['Culori_Predominante']; ?></p>
            </div>
        <?php } else { ?>
            <p>DressCode-ul nu a fost găsit.</p>
        <?php } ?>
        
        <a href="../colectie_haine.php" class="back-button">Înapoi</a>
    </div>
</body>
</html>
