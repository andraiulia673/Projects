<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $denumire = mysqli_real_escape_string($conn, $_POST['denumire']);
    $descriere = mysqli_real_escape_string($conn, $_POST['descriere']);
    $culori_predominante = mysqli_real_escape_string($conn, $_POST['culori_predominante']);
    $query = "INSERT INTO DressCode (Denumire, Descriere, Culori_Predominante) 
              VALUES ('$denumire', '$descriere', '$culori_predominante')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../dresscode.php"); 
        exit;
    } else {
        echo "Eroare la adăugarea dresscode-ului: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă dresscode</title>
    <link rel="stylesheet" href="../../styles/styleAdd.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Add new DressCode</h1>

        <form method="POST" action="add_dresscode.php">
            <label for="denumire">Denumire:</label>
            <input type="text" name="denumire" required>

            <label for="descriere">Descriere:</label>
            <input type="text" name="descriere" required>

            <label for="culori_predominante">Culori predominante:</label>
            <input type="text" name="culori_predominante" required>
            
            <button type="submit">Add</button>
        </form>
        <a href="../dresscode.php" class="back-button">Back</a>
    </div>
</body>
</html>
