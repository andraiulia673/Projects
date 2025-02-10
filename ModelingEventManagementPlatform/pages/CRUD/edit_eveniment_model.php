<?php
session_start();
include("../../logic/connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['ID_Eveniment']) && isset($_GET['ID_Model'])) {
    $id_eveniment = $_GET['ID_Eveniment'];
    $id_model = $_GET['ID_Model'];

  
    $query = "SELECT * FROM Eveniment_Model WHERE ID_Eveniment = ? AND ID_Model = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_eveniment, $id_model);
    $stmt->execute();
    $result = $stmt->get_result();
    $eveniment_model = $result->fetch_assoc();

    $query_evenimente = "SELECT * FROM Eveniment";
    $result_evenimente = mysqli_query($conn, $query_evenimente);

   
    $query_modele = "SELECT * FROM Model";
    $result_modele = mysqli_query($conn, $query_modele);
} else {
    header("Location: ../eveniment_model.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_eveniment = $_POST['id_eveniment'];
    $id_model = $_POST['id_model'];
    $nr_intrare = $_POST['nr_intrare'];
    $melodie_defilare = $_POST['melodie_defilare'];
    $query = "UPDATE Eveniment_Model SET Nr_intrare = ?, Melodie_defilare = ? WHERE ID_Eveniment = ? AND ID_Model = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isii", $nr_intrare, $melodie_defilare, $id_eveniment, $id_model);

    if ($stmt->execute()) {
        header("Location: ../eveniment_model.php");
        exit;
    } else {
        echo "Eroare la actualizarea Eveniment_Model: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../styles/styleEdit.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Eveniment Model</title>
</head>
<body>
    <h1>Edit Eveniment Model</h1>
    <form method="POST">
        <label for="id_eveniment">Eveniment:</label>
        <select name="id_eveniment" required>
            <?php while ($row = mysqli_fetch_assoc($result_evenimente)) { ?>
                <option value="<?php echo $row['ID_Eveniment']; ?>" <?php echo $eveniment_model['ID_Eveniment'] == $row['ID_Eveniment'] ? 'selected' : ''; ?>>
                    <?php echo $row['Denumire']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="id_model">Model:</label>
        <select name="id_model" required>
            <?php while ($row = mysqli_fetch_assoc($result_modele)) { ?>
                <option value="<?php echo $row['ID_Model']; ?>" <?php echo $eveniment_model['ID_Model'] == $row['ID_Model'] ? 'selected' : ''; ?>>
                    <?php echo $row['Nume'] . " " . $row['Prenume']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="nr_intrare">Număr Intrare:</label>
        <input type="number" name="nr_intrare" value="<?php echo $eveniment_model['Nr_intrare']; ?>" required><br>

        <label for="melodie_defilare">Melodie Defilare:</label>
        <input type="text" name="melodie_defilare" value="<?php echo $eveniment_model['Melodie_defilare']; ?>" required><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
