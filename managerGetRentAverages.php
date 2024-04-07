<?php
// Query to calculate average rent per property type
$query = "SELECT type, AVG(cost) AS avg_rent FROM property GROUP BY type";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    echo "<tr>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>$" . number_format($row['avg_rent'], 2) . "</td>";
    echo "</tr>";
}
?>