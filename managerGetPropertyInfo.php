<?php
            $query = "SELECT * FROM property";
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['code'] . "</td>";
                echo "<td>" . $row['street'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['province'] . "</td>";
                echo "<td>" . $row['postalCode'] . "</td>";
                echo "<td>" . $row['apartmentNum'] . "</td>";
                echo "<td>" . $row['parking'] . "</td>";
                echo "<td>" . $row['access'] . "</td>";
                echo "<td>" . $row['laundry'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "<td>" . $row['beds'] . "</td>";
                echo "<td>" . $row['bath'] . "</td>";
                echo "<td>$" . number_format($row['cost'], 2) . "</td>";
                // Retrieve manager's firstname and lastname based on managerID
                $managerID = $row['managerID'];
                $queryManager = "SELECT fname, lname FROM manager WHERE ID = :managerID";
                $statementManager = $connection->prepare($queryManager);
                $statementManager->bindParam(':managerID', $managerID);
                $statementManager->execute();
                $managerResult = $statementManager->fetch(PDO::FETCH_ASSOC);

                if ($managerResult) {
                    $firstname = $managerResult['fname'];
                    $lastname = $managerResult['lname'];
                    echo "<td>$firstname $lastname</td>";
                } else {
                    echo "<td></td>";
                }

                // Retrieve owner's firstname and lastname based on property code
                $propertyCode = $row['code'];
                $queryOwner = "SELECT o.fname, o.lname FROM owner AS o
                            JOIN ownsProperty AS op ON o.ID = op.ownerID
                            WHERE op.propertyID = :propertyCode";
                $statementOwner = $connection->prepare($queryOwner);
                $statementOwner->bindParam(':propertyCode', $propertyCode);
                $statementOwner->execute();
                $ownerResult = $statementOwner->fetch(PDO::FETCH_ASSOC);

                if ($ownerResult) {
                    $ownerFirstname = $ownerResult['fname'];
                    $ownerLastname = $ownerResult['lname'];
                    echo "<td>$ownerFirstname $ownerLastname</td>";
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            ?>