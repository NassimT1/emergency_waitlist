<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<script>
    $(document).ready(function() {
        $('#patientForm').submit(function(e) {          
            let formData = {
                'firstName': $('input[name=firstName]').val(),
                'lastName': $('input[name=lastName]').val(),
                'severity': $('#severity').val()
            };

            // Check is severity is less than 1
            if (formData.severity < 1) {
                alert("Severity must be 1 or higher.");
                return false; 
            }

            // Ajax to add a patient to the database
            $.ajax({
                type: 'POST',
                url: 'add_patient.php',
                data: formData,
                success: function(response) {
                    alert("Added patient successfully." + "\n" + "Patient code: " + response); 
                    $('input[name=firstName]').val('');
                    $('input[name=lastName]').val('');
                    $('#severity').val('');
                }
            });
            return false;
        });
    });
    </script>
    <h1>Admin page</h1> <hr>
    <h2>Add patient</h2>
    <form id="patientForm" action="add_patient.php" method="post">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br><br>

        <label for="severity">Severity (1 = low, 10 = high):</label>
        <select id="severity" name="severity">
            <option value="">Select Severity</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select><br><br>

        <input type="submit" value="Submit">
    </form>
    <!-- View the queue -->
    <a href="admin_queue.php">
        <button class="button_1">View queue</button>
    </a><br>
</body>
</html>