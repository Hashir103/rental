<?php
    $result = $connection->query("select * from rentalGroup");
    // Output each row as an option in the styled select dropdown
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $optionText = "";

        // Iterate over each key-value pair in the row
        foreach ($row as $columnName => $value) {
            if (!in_array($columnName, ['parking', 'access', 'laundry'])) {
                // Append key-value pair to $optionText only if value is not empty
                if (!empty($value)) {
                    if ($columnName == 'code') {
                        $optionText .= "Group" . ": $value ";
                    }
                    else {
                    $optionText .= ucfirst($columnName) . ": $value, ";
                    }
                }
            }
        }

        // Append 'parking', 'access', 'laundry' to $optionText if they have values
        $additionalInfo = [];
        foreach (['parking', 'access', 'laundry'] as $key) {
            if (!empty($row[$key])) {
                $additionalInfo[] = ucfirst($key) . ": " . $row[$key];
            }
        }
        if (!empty($additionalInfo)) {
            $optionText .= implode(", ", $additionalInfo);
        }

        // Remove the trailing ', ' from the end of the string
        $optionText = rtrim($optionText, ", ");

        // Output option tag with row data as text and value
        echo "<option value='" . $row['code'] . "'>$optionText</option>";
    }
    ?>