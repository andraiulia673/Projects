<?php

include('../../logic/connect.php');

$top = isset($_POST['top']) ? intval($_POST['top']) : 1; 
$an = isset($_POST['an']) ? intval($_POST['an']) : null;
$luna = isset($_POST['luna']) ? intval($_POST['luna']) : null;

$query = "SELECT 
            CONCAT(M.Nume, ' ', M.Prenume) AS Model, 
            COUNT(EM.ID_Eveniment) AS Nr_Participari
        FROM 
            Model M
        INNER JOIN 
            Eveniment_Model EM ON M.ID_Model = EM.ID_Model
        INNER JOIN 
            Eveniment E ON EM.ID_Eveniment = E.ID_Eveniment";

$conditions = [];

if ($an) {
    $conditions[] = "YEAR(E.Data_si_ora) = $an";
}

if ($luna && $an) {
    $conditions[] = "MONTH(E.Data_si_ora) = $luna";
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " GROUP BY M.ID_Model 
            ORDER BY Nr_Participari DESC 
            LIMIT $top";


$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Modele</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare2.css">
</head>
<body>
  
     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../model.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="filter-container">
        <h1>Top Modele</h1>
        <form method="POST" action="">
            <label for="top">Selectează top:</label>
            <select name="top" id="top">
                <option value="1" <?= $top === 1 ? 'selected' : '' ?>>Top 1</option>
                <option value="3" <?= $top === 3 ? 'selected' : '' ?>>Top 3</option>
                <option value="5" <?= $top === 5 ? 'selected' : '' ?>>Top 5</option>
            </select>

            <label for="an">An:</label>
            <input type="number" name="an" id="an" value="<?= $an ?>" placeholder="Ex: 2025">

            <label for="luna">Lună:</label>
            <input type="number" name="luna" id="luna" value="<?= $luna ?>" placeholder="Ex: 1 pentru Ianuarie">

            <button type="submit">Caută</button>
        </form>

        <div class="results">
            <h2>Rezultate:</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Număr Participări</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['Model']) ?></td>
                                <td><?= $row['Nr_Participari'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nu s-au găsit rezultate pentru criteriile selectate.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
