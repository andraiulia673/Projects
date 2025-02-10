<?php
session_start();
include "../../logic/connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit;
}

$queryNonOrganizers = "
    SELECT m.firstName, m.lastName, m.email
    FROM Manager_evenimente m
    WHERE CONCAT(m.firstName, ' ', m.lastName) NOT IN (
        SELECT e.Nume_organizator
        FROM Eveniment e
    )
";
$resultNonOrganizers = $conn->query($queryNonOrganizers);


$queryOrganizers = "
    SELECT m.firstName, m.lastName, m.email
    FROM Manager_evenimente m
    WHERE CONCAT(m.firstName, ' ', m.lastName) IN (
        SELECT e.Nume_organizator
        FROM Eveniment e
    )
";
$resultOrganizers = $conn->query($queryOrganizers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacte Angajați</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare11.css">
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
        <h1 class="title">Contacte</h1>
        
        <div class="section">
            <h2>Managerii firmei</h2>
            <?php if ($resultNonOrganizers->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nume</th>
                            <th>Prenume</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultNonOrganizers->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><em>Nu există manageri care să nu fie organizatori.</em></p>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h2>Organizatorii firmei</h2>
            <?php if ($resultOrganizers->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nume</th>
                            <th>Prenume</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultOrganizers->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><em>Nu există organizatori.</em></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
