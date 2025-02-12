<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Treasure Hunt</title>
    <style>
      
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,rgb(175, 76, 112),rgb(250, 138, 217));
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            background: white;
            color: #333;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color:rgb(125, 46, 101);
            font-size: 24px;
        }

        label {
            font-size: 18px;
            display: block;
            margin-top: 15px;
        }

        input[type="number"],
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background:rgb(249, 173, 234);
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #2E7D32;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome to the Interactive Treasure Hunt! 🏆</h2>
        <p>Enter a number and a secret word to start your adventure.</p>

        <form action="process.php" method="post">
            <label for="number">Enter a number  (e.g., their birth year):</label>
            <input type="number" name="number" required min="1">

            <label for="text">Enter a secret word (e.g., their name or a secret word): </label>
            <input type="text" name="text" required>

            <input type="submit" value="Solve the Puzzle">
        </form>
    </div>

</body>
</html>

