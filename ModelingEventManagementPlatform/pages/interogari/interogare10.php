<?php
session_start();
include "../../logic/connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

$durata_minima = isset($_GET['durata_minima']) ? intval($_GET['durata_minima']) : 0;
$durata_maxima = isset($_GET['durata_maxima']) ? intval($_GET['durata_maxima']) : 1000;

$query = "
    SELECT 
        e.Denumire AS Nume_Eveniment,
        e.Locatie AS Oras,
        TIME(e.Data_si_ora) AS Ora_Inceperii,
        (
            SELECT COUNT(em.ID_Model) 
            FROM Eveniment_Model em 
            WHERE em.ID_Eveniment = e.ID_Eveniment
        ) * 2 AS Durata_Minute
    FROM Eveniment e
    HAVING Durata_Minute BETWEEN ? AND ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $durata_minima, $durata_maxima);
$stmt->execute();
$result = $stmt->get_result();
$evenimente = [];
while ($row = $result->fetch_assoc()) {
    $evenimente[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Evenimente</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare10.css">
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
        <h1 class="title">Program Evenimente</h1>
        <form method="GET" action="">
            <div>
                <label for="durata_minima">Durata minimă (minute):</label>
                <input type="number" id="durata_minima" name="durata_minima" value="<?php echo htmlspecialchars($durata_minima); ?>">
            </div>
            <div>
                <label for="durata_maxima">Durata maximă (minute):</label>
                <input type="number" id="durata_maxima" name="durata_maxima" value="<?php echo htmlspecialchars($durata_maxima) ; ?>">
            </div>
            <div>
                <button type="submit">Filtrează</button>
            </div>
        </form>

        <div class="program-list">
            <?php if (!empty($evenimente)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Eveniment</th>
                            <th>Ora Începerii</th>
                            <th>Oraș</th>
                            <th>Durata (minute)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evenimente as $eveniment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($eveniment['Nume_Eveniment']); ?></td>
                                <td><?php echo htmlspecialchars($eveniment['Ora_Inceperii']); ?></td>
                                <td><?php echo htmlspecialchars($eveniment['Oras']); ?></td>
                                <td><?php echo htmlspecialchars($eveniment['Durata_Minute']) .' '. 'min'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><em>Nu există evenimente care să corespundă filtrării.</em></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
