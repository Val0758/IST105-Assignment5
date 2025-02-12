<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Treasure Hunt</title>
    <style>
        body {
            background-color: #f8c5e0;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 0px 10px gray;
        }
        input {
            margin: 5px;
            padding: 8px;
            border: 1px solid gray;
            border-radius: 5px;
        }
        button {
            background-color: pink;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>Welcome to the Interactive Treasure Hunt! 🏆</h2>
    <p>Enter a number, a secret word, and five guesses to find the treasure.</p>

    <form action="process.php" method="post">
        <label for="number">Enter a number (e.g., birth year):</label>
        <input type="number" name="number" required><br><br>

        <label for="text">Enter a secret word:</label>
        <input type="text" name="text" required><br><br>

        <h3>Enter your five guesses for the treasure hunt (1-100):</h3>
        <input type="number" name="guess1" required min="1" max="100"><br>
        <input type="number" name="guess2" required min="1" max="100"><br>
        <input type="number" name="guess3" required min="1" max="100"><br>
        <input type="number" name="guess4" required min="1" max="100"><br>
        <input type="number" name="guess5" required min="1" max="100"><br><br>

        <button type="submit">Solve the Puzzle</button>
    </form>

</body>
</html>
