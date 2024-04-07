<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .flip-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 5px 5px 5px #8c8b8b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Add margin to top of the table */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Add border bottom to table cells */
        }

        th {
            background-color: #C0D7BB; /* Add a grey background color to headers */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row background color */
        }

    </style>
</head>
<body>
<div class="flip-card">
        <?php
        include 'connectdb.php';
        ?>
        <h1>Manager Page</h1>

        <h3>Property List</h4>
    <table>
            <tr>
                <th>Code</th>
                <th>Street</th>
                <th>City</th>
                <th>Province</th>
                <th>Postal Code</th>
                <th>Apartment #</th>
                <th>Parking</th>
                <th>Access</th>
                <th>Laundry</th>
                <th>Type</th>
                <th>Beds</th>
                <th>Bath</th>
                <th>Cost</th>
                <th>Manager</th>
                <th>Owner</th>
            </tr>
            <?php
            include 'managerGetPropertyInfo.php';
            ?>
    </table>
        <h3>Rent Averages</h4>
        <table>
            <tr>
                <th>Property Type</th>
                <th>Average Rent</th>
            </tr>
            <?php
            // Include the PHP script to calculate rent averages
            include 'managerGetRentAverages.php';
            ?>
        </table>
        <a href="" class="login-button">Add a Property</a> <a href="/rental.html" class="login-button">Back to Home</a>
    </div>
</body>
</html>