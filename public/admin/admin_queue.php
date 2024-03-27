<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin queue</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script>
        function removePatient(code) {
            var formId = 'deleteForm-' + code;
            var rowId = 'row-' + code;
            var form = document.getElementById(formId);

            // Create a FormData object from the form
            var formData = new FormData(form);

            // Send the AJAX request
            fetch('delete_patient.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove the row from the table
                    var row = document.getElementById(rowId);
                    row.parentNode.removeChild(row);
                } else {
                    alert('Failed to remove patient.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        }
    </script>
</head>
<body>
    <h1>Queue</h1><hr>
    <p>Top 5 patients in the queue</p>
    <table id="patientQueue">
        <thead>
            <tr>
                <th>Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Severity</th>
                <th>Arrival</th>
                <th>Served</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include your database connection script
            require_once '../../database/db_connection.php';

            // Fetch the first 5 records from the patients table
            $sql = "SELECT code, firstName, lastName, severity, arrivalTime FROM patient ORDER BY arrivalTime ASC LIMIT 5";
            $result = $conn->query($sql);

            // Check if there are any records
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<tr id="row-' . $row["code"] . '">';
                    echo '<td>' . $row["code"] . '</td>';
                    echo '<td>' . $row["firstName"] . '</td>';
                    echo '<td>' . $row["lastName"] . '</td>';
                    echo '<td>' . $row["severity"] . '</td>';
                    echo '<td>' . $row["arrivalTime"] . '</td>';
                    // Assuming 'served' is a boolean, you might want to display it differently
                    echo '<td>' . ($row["served"] ? 'Yes' : 'No') . '</td>';
                    echo '<td>';
                    echo '<form action="delete_patient.php" method="post" id="deleteForm-' . $row["code"] . '">';
                    echo '<input type="hidden" name="code" value="' . $row["code"] . '">';
                    echo '<input type="button" value="Remove" onclick="removePatient(\'' . $row["code"] . '\')">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7">No records found.</td></tr>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>