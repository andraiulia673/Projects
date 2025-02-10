<?php
session_start();
include "../../logic/connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

$oras = '';
$excludere = false;

if (isset($_POST['oras'])) {
    $oras = $_POST['oras'];
}

if (isset($_POST['excludere']) && $_POST['excludere'] == 'on') {
    $excludere = true;
}

$query = "
    SELECT m.firstName, m.lastName, m.email, e.Denumire AS eveniment, e.Locatie
    FROM Manager_evenimente m
    JOIN Eveniment e ON m.ID_manager = e.ID_manager
    WHERE e.Locatie " . ($excludere ? "NOT IN" : "IN") . " (
        SELECT Locatie
        FROM Eveniment
        WHERE Locatie = ?
    )
";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

$stmt->bind_param("s", $oras);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Căutare Evenimente</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare9.css">
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
        <h1 class="title">Căutare Evenimente</h1>

        <form method="post">
            <label for="oras">Oraș:</label>
            <input type="text" id="oras" name="oras" value="<?php echo htmlspecialchars($oras); ?>" required>

            <label for="excludere">Excludere Evenimente în acest Oraș</label>
            <input type="checkbox" name="excludere" id="excludere" <?php echo $excludere ? 'checked' : ''; ?>>

            <button type="submit">Căutare</button>
        </form>

        <h2>Rezultate</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nume Manager</th>
                        <th>Email Manager</th>
                        <th>Eveniment</th>
                        <th>Locație Eveniment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['firstName']) . ' ' . htmlspecialchars($row['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['eveniment']); ?></td>
                            <td><?php echo htmlspecialchars($row['Locatie']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nu au fost găsite evenimente în acest oraș.</p>
        <?php endif; ?>
    </div>
</body>
</html>
