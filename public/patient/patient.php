<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient page</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <script>
        // Clear forms once submitted 
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.querySelector("form");
            form.addEventListener("submit", function() {
                setTimeout(function() { 
                    form.reset();
                }, 0);
            });
        });
    </script>
    <h1>Patient page</h1> <hr>
    <h2>Please input your Code and Last Name</h2>
    <form action="patient_waitlist.php" method="post">
        <label for="Code">Code:</label>
        <input type="text" id="code" name="code" required><br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>