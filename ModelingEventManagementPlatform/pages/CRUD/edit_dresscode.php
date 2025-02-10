<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_DressCode'])) {
    $id_dresscode = $_GET['ID_DressCode'];

    $query = "SELECT * FROM DressCode WHERE ID_DressCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_dresscode);
    $stmt->execute();
    $result = $stmt->get_result();
    $dresscode = $result->fetch_assoc();
} else {
    header("Location: ../dresscode.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $denumire = $_POST['denumire'];
    $descriere = $_POST['descriere'];
    $culori_predominante = $_POST['culori_predominante'];

    $query = "UPDATE DressCode SET Denumire = ?, Descriere = ?, Culori_Predominante = ? WHERE ID_DressCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $denumire, $descriere, $culori_predominante, $id_dresscode);

    if ($stmt->execute()) {
        header("Location: ../dresscode.php");
        exit;
    } else {
        echo "Eroare la actualizarea DressCode: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../styles/styleEdit.css">    

    <title>Edit DressCode</title>
</head>
<body>
    <h1>Edit DressCode</h1>
    <form method="POST">
        <label for="denumire">Denumire:</label>
        <input type="text" name="denumire" value="<?php echo $dresscode['Denumire']; ?>" required><br>

        <label for="descriere">Descriere:</label>
        <input type="text" name="descriere" value="<?php echo $dresscode['Descriere']; ?>" required><br>

        <label for="culori_predominante">Culori Predominante:</label>
        <input type="text" name="culori_predominante" value="<?php echo $dresscode['Culori_Predominante']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
