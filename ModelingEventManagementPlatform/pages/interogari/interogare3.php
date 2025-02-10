<?php
session_start();
include '../../logic/connect.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    die("Nu sunteti autentificat!");
}
$email = $_SESSION['email'];

$sql = "
    SELECT DISTINCT
        e.Denumire AS nume_eveniment, 
        e.Data_si_ora, 
        e.Nume_organizator
    FROM Eveniment e
    WHERE e.ID_Manager = (SELECT ID_manager FROM Manager_evenimente WHERE email = ?)

    UNION ALL
    
    SELECT DISTINCT
        e.Denumire AS nume_eveniment, 
        e.Data_si_ora, 
        CONCAT(m.Prenume, ' ', m.Nume) AS Nume_organizator
    FROM Eveniment e
    LEFT JOIN Eveniment_Model em ON e.ID_Eveniment = em.ID_Eveniment
    LEFT JOIN Model m ON em.ID_Model = m.ID_Model
    WHERE e.ID_Manager = (SELECT ID_manager FROM Manager_evenimente WHERE email = ?)
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Eroare la pregătirea interogării: " . $conn->error);
}

$stmt->bind_param("ss", $email, $email);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleToDoList.css">
</head>
<body>
     <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../homepage.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="todo-container">
        <h1>To-Do List</h1>
        <ul class="todo-list">
            <?php foreach ($tasks as $task): ?>
                <li>
                    <input type="checkbox" id="task-<?php echo $task['nume_eveniment']; ?>">
                    <label for="task-<?php echo $task['nume_eveniment']; ?>">
                        De contactat <strong><?php echo $task['Nume_organizator']; ?></strong> pentru evenimentul 
                        <strong><?php echo $task['nume_eveniment']; ?></strong> din data 
                        <strong><?php echo $task['Data_si_ora']; ?></strong>.
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
