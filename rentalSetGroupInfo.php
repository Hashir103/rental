<?php
try {
    // Establish database connection using PDO
    $connection = new PDO('mysql:host=localhost;dbname=rentalDB', 'root', '');

    // Set PDO to throw exceptions on errors
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve form data from POST
    $type = $_POST['unitType'];
    $parking = $_POST['parking'];
    $access = $_POST['accessibility'];
    $laundry = $_POST['laundry'];
    $beds = $_POST['beds'];
    $bath = $_POST['baths'];
    $cost = $_POST['cost'];
    $code = $_POST['rentalGroupCode'];

    // Prepare SQL update statement with placeholders
    $sql = "UPDATE rentalGroup SET type = :type, parking = :parking, access = :access,
            laundry = :laundry, beds = :beds, bath = :bath, cost = :cost WHERE code = :code";

    // Prepare the SQL statement for execution
    $stmt = $connection->prepare($sql);

    // Bind parameters to placeholders
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':parking', $parking);
    $stmt->bindParam(':access', $access);
    $stmt->bindParam(':laundry', $laundry);
    $stmt->bindParam(':beds', $beds);
    $stmt->bindParam(':bath', $bath);
    $stmt->bindParam(':cost', $cost);
    $stmt->bindParam(':code', $code);

    // Execute the prepared statement
    $stmt->execute();

    // Output success message
    echo "Preferences updated successfully";

} catch (PDOException $e) {
    // Display error message if database operation fails
    echo "Error updating preferences: " . $e->getMessage();
}
?>
