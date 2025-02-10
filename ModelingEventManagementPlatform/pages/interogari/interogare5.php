<?php
session_start();
include '../../logic/connect.php';

if (!isset($_GET['id_colectie']) || !isset($_GET['id_model'])) {
    die("ID-ul colecției sau al modelului lipsește!");
}

$id_colectie = intval($_GET['id_colectie']);
$id_model = intval($_GET['id_model']);

$sql = "
    SELECT 
        c.Denumire AS nume_colectie,
        m.Nume AS nume_model,
        m.Prenume AS prenume_model,
        mc.Dimensiuni AS dimensiune_initiala
    FROM Model_Colectie_haine mc
    INNER JOIN Colectie_haine c ON mc.ID_Colectie_haine = c.ID_Colectie_Haine
    INNER JOIN Model m ON mc.ID_Model = m.ID_Model
    WHERE mc.ID_Colectie_haine = ? AND mc.ID_Model = ? AND mc.Ajustari = 'DA'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_colectie, $id_model);
$stmt->execute();
$result = $stmt->get_result();

$adjustments = [];
while ($row = $result->fetch_assoc()) {
    $adjustments[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dimensiune_noua = $_POST['dimensiune'];

    $update_sql = "
        UPDATE Model_Colectie_haine
        SET Ajustari = 'NU', Dimensiuni = ?
        WHERE ID_Model = ? AND ID_Colectie_haine = ?
    ";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $dimensiune_noua, $id_model, $id_colectie);
    $update_stmt->execute();

    header("Location: interogare5.php?id_colectie=$id_colectie&id_model=$id_model");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjustments</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare5.css">
</head>
<body>
     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../model_colectie_haine.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Adjustments for Collection</h1>
        <div class="adjustments-list">
            <?php if (!empty($adjustments)): ?>
                <?php foreach ($adjustments as $adjustment): ?>
                    <div class="adjustment-card">
                        <p><strong>Collection:</strong> <?php echo htmlspecialchars($adjustment['nume_colectie']); ?></p>
                        <p><strong>Model:</strong> 
                            <?php echo htmlspecialchars($adjustment['prenume_model']) . ' ' . htmlspecialchars($adjustment['nume_model']); ?>
                        </p>
                        <p><strong>Initial Size:</strong> <?php echo htmlspecialchars($adjustment['dimensiune_initiala']); ?></p>
                        <form method="POST" action="interogare5.php?id_colectie=<?php echo $id_colectie; ?>&id_model=<?php echo $id_model; ?>">
                            <label for="dimensiune">New Size:</label>
                            <select name="dimensiune" required>
                                <option value="">Select Size</option>
                                <option value="XXS">XXS</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p><em>No adjustments needed for this collection and model.</em></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
