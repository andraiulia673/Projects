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
    $cod_cv = intval($_POST['cod_cv']);
    $ani_experienta = intval($_POST['ani_experienta']);

    $query = "INSERT INTO Designer (Nume, Prenume, Cod_CV, Ani_experienta) 
              VALUES ('$nume', '$prenume', $cod_cv, $ani_experienta)";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../designer.php"); 
        exit;
    } else {
        echo "Eroare la adăugarea designerului: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Designer</title>
    <link rel="stylesheet" href="../../styles/styleAdd.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Add new Designer</h1>

        <form method="POST" action="add_designer.php">
            <label for="nume">Nume:</label>
            <input type="text" name="nume" required>

            <label for="prenume">Prenume:</label>
            <input type="text" name="prenume" required>

            <label for="cod_cv">Cod CV:</label>
            <input type="number" name="cod_cv" required>

            <label for="ani_experienta">Ani experiență:</label>
            <input type="number" name="ani_experienta" required>
            
            <button type="submit">Add</button>
        </form>

        <a href="../designer.php" class="back-button">Back</a>
    </div>
</body>
</html>
