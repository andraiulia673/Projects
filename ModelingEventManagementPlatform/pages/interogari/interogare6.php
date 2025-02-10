<?php
session_start();
include "../../logic/connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['ID_Eveniment'])) {
    die("ID-ul evenimentului lipsește!");
}

$id_eveniment = intval($_GET['ID_Eveniment']);


$query = "
    SELECT 
        em.Nr_intrare AS numar_intrare,
        em.Melodie_defilare AS melodie,
        m.Nume AS nume_model,
        m.Prenume AS prenume_model
    FROM Eveniment_Model em
    INNER JOIN Model m ON em.ID_Model = m.ID_Model
    WHERE em.ID_Eveniment = ?
    ORDER BY em.Nr_intrare ASC
";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

$stmt->bind_param("i", $id_eveniment);

$stmt->execute();


if ($stmt->error) {
    die('Error executing the query: ' . $stmt->error);
}

$result = $stmt->get_result();


$program = [];
while ($row = $result->fetch_assoc()) {
    $program[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Eveniment</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare6.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../eveniment.php">Back</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="title">Programul Evenimentului</h1>
        <div class="program-list">
            <?php if (!empty($program)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Număr Intrare</th>
                            <th>Model</th>
                            <th>Melodie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($program as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['numar_intrare']); ?></td>
                                <td><?php echo htmlspecialchars($item['prenume_model']) . ' ' . htmlspecialchars($item['nume_model']); ?></td>
                                <td><?php echo htmlspecialchars($item['melodie']); ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><em>Nu există program disponibil pentru acest eveniment.</em></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
