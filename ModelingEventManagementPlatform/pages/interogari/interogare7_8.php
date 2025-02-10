<?php
session_start();
include "../../logic/connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}


$culoare_selectata = isset($_POST['culoare']) ? $_POST['culoare'] : '';

$query = "
    SELECT d.Nume AS nume_designer, d.Prenume AS prenume_designer, c.Denumire AS nume_colectie, c.An_creatie, dc.Culori_Predominante
    FROM Designer d
    JOIN Colectie_haine c ON d.ID_Designer = c.ID_Designer
    JOIN DressCode dc ON c.ID_Dresscode = dc.ID_DressCode
    WHERE dc.ID_DressCode IN (
        SELECT dc.ID_DressCode
        FROM DressCode dc
        WHERE dc.Culori_Predominante LIKE ?
    )
";


$stmt = $conn->prepare($query);


if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

$stmt->bind_param("s", $culoare_selectata);

$stmt->execute();
$result = $stmt->get_result();
$query_an_creatie = "
    SELECT c.An_creatie, COUNT(c.An_creatie) AS numar_aparitii
    FROM Colectie_haine c
    JOIN DressCode dc ON c.ID_Dresscode = dc.ID_DressCode
    WHERE dc.ID_DressCode IN (
        SELECT dc.ID_DressCode
        FROM DressCode dc
        WHERE dc.Culori_Predominante LIKE ?
    )
    GROUP BY c.An_creatie
    ORDER BY numar_aparitii DESC
    LIMIT 1
";

$stmt_an_creatie = $conn->prepare($query_an_creatie);


if ($stmt_an_creatie === false) {
    die('Error preparing the query: ' . $conn->error);
}


$stmt_an_creatie->bind_param("s", $culoare_selectata);

$stmt_an_creatie->execute();
$result_an_creatie = $stmt_an_creatie->get_result();


$an_creatie_frecvent = null;
if ($row_an_creatie = $result_an_creatie->fetch_assoc()) {
    $an_creatie_frecvent = $row_an_creatie['An_creatie'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designerii și Colectiile lor</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare7_8.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Designerii și Colecțiile lor</h1>
        <form method="POST" action="interogare7_8.php">
            <label for="culoare">Alege o culoare predominantă:</label>
            <select name="culoare" id="culoare">
                <option value="">Selectează o culoare</option>
                <option value="%alb%" <?php echo ($culoare_selectata == '%alb%') ? 'selected' : ''; ?>>Alb</option>
                <option value="%negru%" <?php echo ($culoare_selectata == '%negru%') ? 'selected' : ''; ?>>Negru</option>
                <option value="%rosu%" <?php echo ($culoare_selectata == '%rosu%') ? 'selected' : ''; ?>>Roșu</option>
                <option value="%portocaliu%" <?php echo ($culoare_selectata == '%portocaliu%') ? 'selected' : ''; ?>>Portocaliu</option>
                <option value="%galben%" <?php echo ($culoare_selectata == '%galben%') ? 'selected' : ''; ?>>Galben</option>
                <option value="%verde%" <?php echo ($culoare_selectata == '%verde%') ? 'selected' : ''; ?>>Verde</option>
                <option value="%albastru%" <?php echo ($culoare_selectata == '%albastru%') ? 'selected' : ''; ?>>Albastru</option>
                <option value="%mov%" <?php echo ($culoare_selectata == '%mov%') ? 'selected' : ''; ?>>Mov</option>
                <option value="%roz%" <?php echo ($culoare_selectata == '%roz%') ? 'selected' : ''; ?>>Roz</option>
                <option value="%maro%" <?php echo ($culoare_selectata == '%maro%') ? 'selected' : ''; ?>>Maro</option>
            </select>
            <button type="submit">Căutare</button>
        </form>
        <div class="results">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nume Designer</th>
                            <th>Prenume Designer</th>
                            <th>Nume Colecție</th>
                            <th>An Creare</th>
                            <th>Culori Predominante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nume_designer']); ?></td>
                                <td><?php echo htmlspecialchars($row['prenume_designer']); ?></td>
                                <td><?php echo htmlspecialchars($row['nume_colectie']); ?></td>
                                <td><?php echo htmlspecialchars($row['An_creatie']); ?></td>
                                <td><?php echo htmlspecialchars($row['Culori_Predominante']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><em>Nu au fost găsite colecții pentru culoarea selectată.</em></p>
            <?php endif; ?>
            <?php if ($an_creatie_frecvent): ?>
                <p><strong>Anul de creație care apare cel mai des este: <?php echo htmlspecialchars($an_creatie_frecvent); ?></strong></p>
            <?php else: ?>
                <p><em>Nu s-a putut determina anul de creație cel mai frecvent.</em></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
