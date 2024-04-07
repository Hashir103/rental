<?php
include 'connectdb.php';

if (isset($_GET['code'])) {
    $rentalGroupCode = $_GET['code'];

    // Perform SQL query to fetch renters based on the selected rental group code
    $query = "SELECT * FROM renter WHERE rentalGroup = :rentalGroupCode";
    $statement = $connection->prepare($query);
    $statement->bindParam(':rentalGroupCode', $rentalGroupCode, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');

    // Return JSON response
    echo json_encode($result);
} else {
    // Handle invalid or missing parameters
    echo "Invalid rental group code.";
}
?>
