<?php
session_start();
include("../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Colectie_Haine'])) {
    $id_colectie = $_GET['ID_Colectie_Haine'];

    $query = "SELECT * FROM Colectie_haine WHERE ID_Colectie_Haine = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_colectie);
    $stmt->execute();
    $result = $stmt->get_result();
    $colectie = $result->fetch_assoc();

   
    $query_dresscode = "SELECT * FROM DressCode";
    $result_dresscode = mysqli_query($conn, $query_dresscode);

 
    $query_designeri = "SELECT * FROM Designer";
    $result_designeri = mysqli_query($conn, $query_designeri);
} else {
    header("Location: ../colectie_haine.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $denumire = $_POST['denumire'];
    $descriere = $_POST['descriere'];
    $an_creatie = $_POST['an_creatie'];
    $id_dresscode = $_POST['id_dresscode'];
    $id_designer = $_POST['id_designer'];

  
    $query = "UPDATE Colectie_haine SET Denumire = ?, Descriere = ?, An_creatie = ?, ID_DressCode = ?, ID_Designer = ? WHERE ID_Colectie_Haine = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiiii", $denumire, $descriere, $an_creatie, $id_dresscode, $id_designer, $id_colectie);

    if ($stmt->execute()) {
        header("Location: ../colectie_haine.php");
        exit;
    } else {
        echo "Eroare la actualizarea Colectiei: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Colectie Haine</title>
</head>
<body>
    <h1>Edit Colectie Haine</h1>
    <form method="POST">
        <label for="denumire">Denumire:</label>
        <input type="text" name="denumire" value="<?php echo $colectie['Denumire']; ?>" required><br>

        <label for="descriere">Descriere:</label>
        <input type="text" name="descriere" value="<?php echo $colectie['Descriere']; ?>" required><br>

        <label for="an_creatie">An creație:</label>
        <input type="number" name="an_creatie" value="<?php echo $colectie['An_creatie']; ?>" required><br>

        <label for="id_dresscode">DressCode:</label>
        <select name="id_dresscode" required>
            <?php while ($row = mysqli_fetch_assoc($result_dresscode)) { ?>
                <option value="<?php echo $row['ID_DressCode']; ?>" <?php echo $colectie['ID_DressCode'] == $row['ID_DressCode'] ? 'selected' : ''; ?>>
                    <?php echo $row['Denumire']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="id_designer">Designer:</label>
        <select name="id_designer" required>
            <?php while ($row = mysqli_fetch_assoc($result_designeri)) { ?>
                <option value="<?php echo $row['ID_Designer']; ?>" <?php echo $colectie['ID_Designer'] == $row['ID_Designer'] ? 'selected' : ''; ?>>
                    <?php echo $row['Nume'] . " " . $row['Prenume']; ?>
                </option>
            <?php } ?>
        </select><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
