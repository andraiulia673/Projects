<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = mysqli_real_escape_string($conn, $_POST['nume']);
    $prenume = mysqli_real_escape_string($conn, $_POST['prenume']);
    $varsta = intval($_POST['varsta']);
    $inaltime = intval($_POST['inaltime']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $id_designer = intval($_POST['id_designer']);


    $query = "INSERT INTO Model (Nume, Prenume, Varsta, Inaltime, Sex, ID_Designer) 
              VALUES ('$nume', '$prenume', $varsta, $inaltime, '$sex', $id_designer)";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../model.php"); 
        exit;
    } else {
        echo "Eroare la adăugarea modelului: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Model</title>
    <link rel="stylesheet" href="../../styles/styleAdd.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Adaugă Model</h1>

        <form method="POST" action="add_model.php">
            <label for="nume">Nume:</label>
            <input type="text" name="nume" required>

            <label for="prenume">Prenume:</label>
            <input type="text" name="prenume" required>

            <label for="varsta">Vârstă:</label>
            <input type="number" name="varsta" required>

            <label for="inaltime">Înălțime (cm):</label>
            <input type="number" name="inaltime" required>

            <label for="sex">Sex:</label>
            <select name="sex" required>
                <option value="Masculin">Masculin</option>
                <option value="Feminin">Feminin</option>
            </select>

            <label for="id_designer">ID Designer:</label>
            <input type="number" name="id_designer" required>

            <button type="submit">Adaugă Model</button>
        </form>

        <a href="../model.php" class="back-button">Înapoi</a>
    </div>
</body>
</html>
