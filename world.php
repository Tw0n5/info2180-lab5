<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? htmlspecialchars($_GET['country']) : '';

if(!empty($country)){
  $stmt = $conn -> prepare("SELECT * FROM countries WHERE name LIKE :country");
  $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
  $stmt->execute();
}else{
  $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
}



$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<ul>
  <table border="1">
    <thead>
      <tr>
        <th>Country Name</th>
        <th>Continent</th>
        <th>Independence Year</th>
        <th>Head of State</th>
      </tr>
    </thead>
<tbody>
<?php foreach ($results as $row): ?>
  <tr>
    <td><?=htmlspecialchars($row['name']);?></td>
    <td><?=htmlspecialchars($row['continent']);?></td>
    <td><?=htmlspecialchars($row['independence_year']?? 'N/A');?></td>
    <td><?=htmlspecialchars($row['head_of_state']?? 'N/A');?></td>
  </tr>
  <!-- <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li> -->
<?php endforeach; ?>
</tbody>
  </table>
</ul>
