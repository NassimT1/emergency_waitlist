<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient page</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Patient page</h1> <hr>
    <form action="patient.php" method="post">
        <label for="Code">Code:</label>
        <input type="text" id="code" name="code" required><br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>