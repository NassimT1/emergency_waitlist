<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin queue</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script>
        function removePatient(code, lastName) {
            let formId = 'deleteForm-' + code;
            let rowId = 'row-' + code;
            let form = document.getElementById(formId);
            let formData = new FormData(form);

            // Ajax to remove the patient from the database
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
                    let row = document.getElementById(rowId);
                    row.parentNode.removeChild(row);

                    if (document.querySelectorAll('#patientQueue tbody tr').length === 0) {
                        let tbody = document.querySelector('#patientQueue tbody');
                        let tr = document.createElement('tr');
                        let td = document.createElement('td');
                        td.setAttribute('colspan', '7');
                        td.textContent = 'No records found.';
                        tr.appendChild(td);
                        tbody.appendChild(tr);
                    }
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
    <table id="patientQueue">
        <thead>
            <tr>
                <th>Position</th>
                <th>Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Severity</th>
                <th>Arrival</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../../database/db_connection.php';

            // Sort clients by arrival time
            $sql = "SELECT code, firstName, lastName, severity, arrivalTime FROM patient ORDER BY arrivalTime";
            $result = $conn->query($sql);
            $position = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $position++;
                    echo '<tr id="row-' . $row["code"] . '">';
                    echo '<td>' . $position . '</td>';
                    echo '<td>' . $row["code"] . '</td>';
                    echo '<td>' . $row["firstName"] . '</td>';
                    echo '<td>' . $row["lastName"] . '</td>';
                    echo '<td>' . $row["severity"] . '</td>';
                    echo '<td>' . $row["arrivalTime"] . '</td>';
                    echo '<td>';
                    // Delete the patient after clicking the remove button
                    echo '<form action="delete_patient.php" method="post" id="deleteForm-' . $row["code"] . '">';
                    echo '<input type="hidden" name="code" value="' . $row["code"] . '">';
                    echo '<input type="hidden" name="lastName" value="' . $row["lastName"] . '">'; 
                    echo '<input type="button" value="Remove" onclick="removePatient(\'' . $row["code"] . '\', \'' . $row["lastName"] . '\')">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7">No records found.</td></tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>