<?php

include('../../logic/connect.php');


$collections_query = "SELECT DISTINCT Denumire FROM Colectie_haine";
$collections_result = $conn->query($collections_query);


$locations_query = "SELECT DISTINCT Locatie FROM Eveniment";
$locations_result = $conn->query($locations_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Events</title>
    <link rel="stylesheet" href="../../styles/stylesInterogari/styleInterogare.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../colectie_haine.php">Back</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Search Events by Collection</h1>
        <form method="GET" action="interogare1.php">
        
            <label for="collection">Select a Collection:</label>
            <select name="collection_name" id="collection" required>
                <option value="" disabled selected>Choose a collection</option>
                <?php
                if ($collections_result->num_rows > 0) {
                    while ($row = $collections_result->fetch_assoc()) {
                        echo "<option value='" . $row['Denumire'] . "'>" . $row['Denumire'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="location">Select Location:</label>
            <select name="location" id="location">
                <option value="" disabled selected>Choose a location (optional)</option>
                <?php
                if ($locations_result->num_rows > 0) {
                    while ($row = $locations_result->fetch_assoc()) {
                        echo "<option value='" . $row['Locatie'] . "'>" . $row['Locatie'] . "</option>";
                    }
                }
                ?>
            </select>

        
            <label for="start_date">Start Date and Time:</label>
            <input type="datetime-local" name="start_date" id="start_date">

            <label for="end_date">End Date and Time:</label>
            <input type="datetime-local" name="end_date" id="end_date">

            <button type="submit">Search</button>
        </form>

        <?php
        if (isset($_GET['collection_name'])) {
            $collection_name = $_GET['collection_name'];
            $location = isset($_GET['location']) ? $_GET['location'] : '';
            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

            $query = "
                SELECT 
                    E.Denumire AS Eveniment, 
                    E.Locatie, 
                    E.Data_si_ora, 
                    E.Nume_organizator, 
                    D.Denumire AS Dresscode
                FROM 
                    Colectie_haine CH
                INNER JOIN 
                    DressCode D ON CH.ID_Dresscode = D.ID_DressCode
                INNER JOIN 
                    Eveniment E ON D.ID_DressCode = E.ID_Dresscode
                WHERE 
                    CH.Denumire = ?";
            if (!empty($location)) {
                $query .= " AND E.Locatie = ?";
            }
            if (!empty($start_date) && !empty($end_date)) {
                $query .= " AND E.Data_si_ora BETWEEN ? AND ?";
            }

            $stmt = $conn->prepare($query);
            if (!empty($location) && !empty($start_date) && !empty($end_date)) {
                $stmt->bind_param("ssss", $collection_name, $location, $start_date, $end_date);
            } elseif (!empty($location)) {
                $stmt->bind_param("ss", $collection_name, $location);
            } elseif (!empty($start_date) && !empty($end_date)) {
                $stmt->bind_param("sss", $collection_name, $start_date, $end_date);
            } else {
                $stmt->bind_param("s", $collection_name);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2>Matching Events:</h2>";
                echo "<table>
                        <tr>
                            <th>Event Name</th>
                            <th>Location</th>
                            <th>Date & Time</th>
                            <th>Organizer</th>
                            <th>Dresscode</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Eveniment'] . "</td>
                            <td>" . $row['Locatie'] . "</td>
                            <td>" . $row['Data_si_ora'] . "</td>
                            <td>" . $row['Nume_organizator'] . "</td>
                            <td>" . $row['Dresscode'] . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No events found matching your criteria.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
