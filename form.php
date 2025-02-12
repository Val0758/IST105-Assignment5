<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Treasure Hunt</title>
</head>
<body>
    <h2>Welcome to the Interactive Treasure Hunt!</h2>
    <form action="process.php" method="post">
        <label for="number">Enter a number (e.g., birth year):</label>
        <input type="number" name="number" required><br><br>

        <label for="text">Enter a text (e.g., your name or a secret word):</label>
        <input type="text" name="text" required><br><br>

        <input type="submit" value="Solve the Puzzle">
    </form>
</body>
</html>
