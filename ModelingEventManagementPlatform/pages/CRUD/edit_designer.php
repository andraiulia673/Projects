<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Designer'])) {
    $id_designer = $_GET['ID_Designer'];

  
    $query = "SELECT * FROM Designer WHERE ID_Designer = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_designer);
    $stmt->execute();
    $result = $stmt->get_result();
    $designer = $result->fetch_assoc();
} else {
    header("Location: ../designer.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $cod_cv = $_POST['cod_cv'];
    $ani_experienta = $_POST['ani_experienta'];

    $query = "UPDATE Designer SET Nume = ?, Prenume = ?, Cod_CV = ?, Ani_experienta = ? WHERE ID_Designer = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiii", $nume, $prenume, $cod_cv, $ani_experienta, $id_designer);

    if ($stmt->execute()) {
        header("Location: ../designer.php");
        exit;
    } else {
        echo "Eroare la actualizarea Designerului: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Designer</title>
</head>
<body>
    <h1>Edit Designer</h1>
    <form method="POST">
        <label for="nume">Nume:</label>
        <input type="text" name="nume" value="<?php echo $designer['Nume']; ?>" required><br>

        <label for="prenume">Prenume:</label>
        <input type="text" name="prenume" value="<?php echo $designer['Prenume']; ?>" required><br>

        <label for="cod_cv">Cod CV:</label>
        <input type="number" name="cod_cv" value="<?php echo $designer['Cod_CV']; ?>" required><br>

        <label for="ani_experienta">Ani Experiență:</label>
        <input type="number" name="ani_experienta" value="<?php echo $designer['Ani_experienta']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
