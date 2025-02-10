<?php
session_start();
include '../../logic/connect.php';

if (!isset($_GET['id_designer'])) {
    die("Nu a fost selectat niciun designer!");
}
$id_designer = intval($_GET['id_designer']);

$an_minim = isset($_GET['an_minim']) ? intval($_GET['an_minim']) : 0;

$sql = "
    SELECT 
        c.Denumire AS nume_colectie, 
        c.Descriere AS descriere_colectie, 
        c.An_creatie, 
        m.Nume AS nume_model, 
        m.Prenume AS prenume_model
    FROM Colectie_haine c
    LEFT JOIN Model_Colectie_haine mc ON c.ID_Colectie_Haine = mc.ID_Colectie_haine
    LEFT JOIN Model m ON mc.ID_Model = m.ID_Model
    WHERE c.ID_Designer = ?
    " . ($an_minim > 0 ? "AND c.An_creatie >= ?" : "") . "
    ORDER BY c.An_creatie DESC, c.Denumire ASC
";

$stmt = $conn->prepare($sql);
if ($an_minim > 0) {
    $stmt->bind_param("ii", $id_designer, $an_minim);
} else {
    $stmt->bind_param("i", $id_designer);
}
$stmt->execute();
$result = $stmt->get_result();

$collections = [];
while ($row = $result->fetch_assoc()) {
    $collections[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Collections</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare4.css">
</head>
<body>
     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../designer.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Colectii de haine ale designerului</h1>
        <form method="GET" action="interogare4.php">
            <input type="hidden" name="id_designer" value="<?php echo $id_designer; ?>">
            <label for="an_minim">Filtrează colecțiile de la anul:</label>
            <input type="number" name="an_minim" id="an_minim" value="<?php echo $an_minim; ?>" min="0">
            <button type="submit">Filtrează</button>
        </form>

        <div class="collections">
            <?php if (!empty($collections)): ?>
                <?php foreach ($collections as $collection): ?>
                    <div class="collection-card">
                        <h2><?php echo htmlspecialchars($collection['nume_colectie']); ?></h2>
                        <p><strong>Descriere:</strong> <?php echo htmlspecialchars($collection['descriere_colectie']); ?></p>
                        <p><strong>An creație:</strong> <?php echo htmlspecialchars($collection['An_creatie']); ?></p>
                        <?php if (!empty($collection['nume_model']) && !empty($collection['prenume_model'])): ?>
                            <p><strong>Model:</strong> 
                                <?php echo htmlspecialchars($collection['prenume_model']) . ' ' . htmlspecialchars($collection['nume_model']); ?>
                            </p>
                        <?php else: ?>
                            <p><em>Nicio defilare înregistrată cu această colecție.</em></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p><em>Nu există colecții disponibile pentru acest designer.</em></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
