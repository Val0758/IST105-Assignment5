<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Validate input data
    if (!isset($_POST["number"]) || !isset($_POST["text"]) || 
        !isset($_POST["guess1"]) || !isset($_POST["guess2"]) ||
        !isset($_POST["guess3"]) || !isset($_POST["guess4"]) ||
        !isset($_POST["guess5"])) {
        die("<p class='error'>Error: Missing number, text, or guesses.</p>");
    }

    $number = escapeshellarg($_POST["number"]);
    $text = escapeshellarg($_POST["text"]);
    $guesses = [];
    for ($i = 1; $i <= 5; $i++) {
        $guesses[] = escapeshellarg($_POST["guess$i"]);
    }

    // Execute `process.py` with user guesses
    $cmd = "python3 process.py $number $text " . implode(" ", $guesses) . " 2>&1";
    $output = shell_exec($cmd);

    // Remove warnings and extract valid JSON
    $output_lines = explode("\n", trim($output));
    foreach ($output_lines as $line) {
        if (str_starts_with($line, "{")) { // Find JSON line
            $json_output = $line;
            break;
        }
    }

    if (!isset($json_output)) {
        die("<p class='error'>Error: Invalid response from Python. Debug Output: <pre>$output</pre></p>");
    }

    $result = json_decode($json_output, true);

    if ($result === null) {
        die("<p class='error'>Error: Invalid JSON response. Debug Output: <pre>$output</pre></p>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results of Your Adventure</title>
    <style>
        body {
            background-color: #f8c5e0;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 0px 10px gray;
            max-width: 500px;
        }
        .result-box {
            background: #f4f4f4;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .win {
            color: green;
            font-size: 18px;
            font-weight: bold;
        }
        .lose {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }
        button {
            background-color: pink;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #ff99cc;
        }
    </style>
    <script>
        function showPopup(message) {
            alert(message);
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>🎉 Your Adventure Results 🎉</h2>

        <?php if (isset($result['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($result['error']); ?></p>
        <?php else: ?>
            <div class="result-box"><strong>Number Puzzle:</strong> <?php echo htmlspecialchars($result["number_result"]); ?></div>
            <div class="result-box"><strong>Binary Text:</strong> <?php echo htmlspecialchars($result["binary_text"]); ?></div>
            <div class="result-box"><strong>Vowel Count:</strong> <?php echo htmlspecialchars($result["vowel_count"]); ?></div>
            <div class="result-box"><strong>Treasure Hunt:</strong> <?php echo htmlspecialchars($result["treasure_result"]); ?></div>
            <div class="result-box"><strong>Attempts:</strong> <?php echo implode(", ", array_map('htmlspecialchars', $result["attempts"])); ?></div>

            <?php if (strpos($result["treasure_result"], "You found the treasure") !== false): ?>
                <p class="win">🎉 YOU WIN! 🎉</p>
                <script> showPopup("🎉 YOU WIN! 🎉"); </script>
            <?php else: ?>
                <p class="lose">❌ You lost! Try Again.</p>
                <script>
                    setTimeout(() => {
                        alert("❌ Try Again! Redirecting...");
                        window.location.href = "form.php";
                    }, 2000);
                </script>
            <?php endif; ?>

        <?php endif; ?>

        <br>
        <button onclick="window.location.href='form.php'">🔄 Try Again</button>
    </div>

</body>
</html>
