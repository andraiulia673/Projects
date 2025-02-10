<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Eveniment'])) {
    $id_eveniment = $_GET['ID_Eveniment'];
    $query = "SELECT * FROM Eveniment WHERE ID_Eveniment = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_eveniment);
    $stmt->execute();
    $result = $stmt->get_result();
    $eveniment = $result->fetch_assoc();
    
    $query_dresscode = "SELECT * FROM DressCode";
    $result_dresscode = mysqli_query($conn, $query_dresscode);

  
    $query_manager = "SELECT * FROM Manager_evenimente";
    $result_manager = mysqli_query($conn, $query_manager);

} else {
    header("Location: ../eveniment.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $denumire = $_POST['denumire'];
    $locatie = $_POST['locatie'];
    $data_si_ora = $_POST['data_si_ora'];
    $nume_organizator = $_POST['nume_organizator'];
    $id_dresscode = $_POST['id_dresscode'];
    $id_manager = $_POST['id_manager'];


    $query = "UPDATE Eveniment SET Denumire = ?, Locatie = ?, Data_si_ora = ?, Nume_organizator = ?, ID_DressCode = ?, ID_Manager = ? WHERE ID_Eveniment = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssiii", $denumire, $locatie, $data_si_ora, $nume_organizator, $id_dresscode, $id_manager, $id_eveniment);

    if ($stmt->execute()) {
        header("Location: ../eveniment.php");
        exit;
    } else {
        echo "Eroare la actualizarea Evenimentului: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../styles/styleEdit.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Eveniment</title>
</head>
<body>
    <h1>Edit Eveniment</h1>
    <form method="POST">
        <label for="denumire">Denumire:</label>
        <input type="text" name="denumire" value="<?php echo $eveniment['Denumire']; ?>" required><br>

        <label for="locatie">Locație:</label>
        <input type="text" name="locatie" value="<?php echo $eveniment['Locatie']; ?>" required><br>

        <label for="data_si_ora">Data și ora:</label>
        <input type="datetime-local" name="data_si_ora" value="<?php echo $eveniment['Data_si_ora']; ?>" required><br>

        <label for="nume_organizator">Organizator:</label>
        <input type="text" name="nume_organizator" value="<?php echo $eveniment['Nume_organizator']; ?>" required><br>

        <label for="id_dresscode">DressCode:</label>
        <select name="id_dresscode" required>
            <?php while ($row = mysqli_fetch_assoc($result_dresscode)) { ?>
                <option value="<?php echo $row['ID_DressCode']; ?>" <?php echo $eveniment['ID_DressCode'] == $row['ID_DressCode'] ? 'selected' : ''; ?>>
                    <?php echo $row['Denumire']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="id_manager">Manager:</label>
        <select name="id_manager" required>
            <?php while ($row = mysqli_fetch_assoc($result_manager)) { ?>
                <option value="<?php echo $row['ID_manager']; ?>" <?php echo $eveniment['ID_manager'] == $row['ID_manager'] ? 'selected' : ''; ?>>
                    <?php echo $row['firstName'] . " " . $row['lastName']; ?>
                </option>
            <?php } ?>
        </select><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
