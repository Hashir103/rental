<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renter Home</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #renterListContainer {
            display: none;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            margin: 5% auto;
            text-align: center;
        }
        .close {
            cursor: pointer;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }
        .flip-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 5px 5px 5px #8c8b8b;
        }
    </style>
</head>
<body>
    <div class="flip-card">
        <?php
        include 'connectdb.php';
        ?>
        <h1>Renter Page</h1>
        <h4>Select Rental Group:</h4>
        <select id="rentalGroupSelect" class='select-style' name='rentalGroup'>";
        <?php
        include 'renterGetGroups.php';
        ?>
        </select>
        <br>
        <a class="group-button login-button">Get Group Information</a>     <a href="/rental.html" class="login-button">Back to Home</a>
            <!-- Placeholder for displaying renter information -->
            <div id="renterListContainer">
                <h2>Group Renters:</h2>
                <ol id="renterList"></ol>

                <a class="login-button group-pref">Modify Group Preferences</a>
            </div>
    </div>
    <div class="modal" id="preferencesModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Modify Group Preferences</h2>
        <!-- Form for preferences -->
        <form id="preferencesForm">
            <label for="unitType">Unit Type:</label>
            <select id="unitType" name="unitType" required>
                <option value="House">House</option>
                <option value="Apartment">Apartment</option>
                <option value="Room">Room</option>
            </select>
            <br><br>
            <label for="parking">Parking:</label>
            <select id="parking" name="parking" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br>
            <label for="accessibility">Accessibility:</label>
            <select id="accessibility" name="accessibility" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br>
            <label for="laundry">Laundry:</label>
            <select id="laundry" name="laundry" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br>
            <label for="beds">Beds:</label>
            <input type="number" id="beds" name="beds" required>
            <br><br>
            <label for="baths">Baths:</label>
            <input type="number" id="baths" name="baths" required>
            <br><br>
            <label for="cost">Cost:</label>
            <input type="number" step="0.01" id="cost" name="cost" required>
            <br><br>
            <!-- Add more form fields as needed -->
            <button type="submit" class="login-button" id="savePreferencesBtn">Save Preferences</button>
        </form>
    </div>
</div>
    <script>
        // jQuery function to handle click event on anchor tag
        $(document).ready(function() {
            $('.group-button').click(function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                // Get selected rental group code from the <select> tag
                var selectedCode = $('#rentalGroupSelect').val();

                // Make AJAX request to fetch renters based on the selected code
                $.ajax({
                    url: 'renterGetGroupInfo.php', // URL of the server-side PHP script
                    type: 'GET',
                    data: { code: selectedCode }, // Pass selected code as a parameter
                    success: function(response) {
                         // Check if response is a string and needs to be parsed as JSON
                        if (typeof response === 'string') {
                            response = JSON.parse(response); // Parse JSON if response is a string
                        }

                        // Clear existing renter list
                        $('#renterList').empty();

                        // Create and append <li> elements for each renter
                        response.forEach(function(renter) {
                            var listItem = $('<li>'); // Create new <li> element

                            // Iterate over each property of the renter object
                            Object.keys(renter).forEach(function(key) {
                                if (key === 'rentalGroup' || key === 'ID' || key === 'studentID') {
                                    return; // Skip rentalGroup property
                                }
                                var propertyValue = renter[key];
                                var propertyLabel = key.charAt(0).toUpperCase() + key.slice(1); // Capitalize first letter

                                if (key === 'fname') {
                                    var propertyText = propertyValue + " ";
                                    listItem.append($('<span>').text(propertyText)); // Append property text to <li>
                                }
                                else if (key == 'lname') {
                                    var propertyText = propertyValue + " ";
                                    listItem.append($('<span>').text(propertyText)); // Append property text to <li>
                                }
                                else {
                                    listItem.append($('<ul>'));
                                    var propertyText = propertyLabel + ': ' + propertyValue + " ";
                                    listItem.append($('<span>').text(propertyText)); // Append property text to <li>
                                    listItem.append($('</ul>'));
                                }
                            });
                            listItem.append($('</li>'));
                            $('#renterList').append(listItem); // Append <li> to <ol>
                        });
                        $('#renterListContainer').show();
                    },
                    error: function(xhr, status, error) {
                        // Handle error (e.g., display error message)
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the modal element
            var modal = document.getElementById('preferencesModal');

            // Get the button that opens the modal
            var btn = document.querySelector('.group-pref');

            // Get the <span> element that closes the modal
            var span = document.getElementById('closeModal');

            // When the user clicks the button, open the modal 
            btn.addEventListener('click', function() {
                modal.style.display = 'block';
            });

            // When the user clicks on <span> (x), close the modal
            span.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // When the user clicks anywhere outside of the modal, close it
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });

            // Handle form submission
            var form = document.getElementById('preferencesForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Retrieve form data
                var formData = {
                    unitType: document.getElementById('unitType').value,
                    parking: document.getElementById('parking').value[0],
                    accessibility: document.getElementById('accessibility').value[0],
                    laundry: document.getElementById('laundry').value[0],
                    beds: parseInt(document.getElementById('beds').value),
                    baths: parseInt(document.getElementById('baths').value),
                    cost: parseFloat(document.getElementById('cost').value),
                    rentalGroupCode: $('#rentalGroupSelect').val() 
                };

                // Perform AJAX request to update database
                $.ajax({
                    type: 'POST',
                    url: 'rentalSetGroupInfo.php', // URL to your server-side script for handling the update
                    data: formData,
                    success: function(response) {
                        alert('Preferences saved successfully!');
                        modal.style.display = 'none'; // Hide the modal after successful update
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while saving preferences.');
                        console.error(error); // Log any errors to the console
                    }
                });
            });
        });
</script>
</body>
</html>