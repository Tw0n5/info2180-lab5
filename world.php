<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? htmlspecialchars($_GET['country']) : '';
$lookup = isset($_GET['lookup']) ? htmlspecialchars($_GET['lookup']) : ''; // Get the lookup parameter

// Check if lookup is 'cities'
if ($lookup === 'cities') {
    if (!empty($country)) {
        // SQL query to join cities and countries
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
        ");
        $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the cities in an HTML table
        if (!empty($results)) {
            echo '<table border="1">
                    <thead>
                        <tr>
                            <th>City Name</th>
                            <th>District</th>
                            <th>Population</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($results as $row) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['city_name']) . '</td>
                        <td>' . htmlspecialchars($row['district']) . '</td>
                        <td>' . htmlspecialchars($row['population']) . '</td>
                      </tr>';
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No cities found for '$country'.</p>";
        }
    } else {
        echo "<p>Please reenter a country name.</p>";
    }
    exit; // Stop further execution if cities are being looked up
}

// If lookup is 'country' or not set, return country info
if ($lookup === 'country' || empty($lookup)) {
    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
        $stmt->execute();
    } else {
        $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the country information in an HTML table
    if (!empty($results)) {
        echo '<table border="1">
                <thead>
                    <tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['continent']) . '</td>
                    <td>' . htmlspecialchars($row['independence_year'] ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($row['head_of_state'] ?? 'N/A') . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p>Error, no countries found.</p>";
    }
    exit; // Stop further execution if country info is being looked up
}

echo "<p>Invalid request. Please specify a valid lookup type.</p>";
?>
