<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Validate input data
    if (!isset($_POST["number"]) || !isset($_POST["text"]) || 
        !isset($_POST["guess1"]) || !isset($_POST["guess2"]) ||
        !isset($_POST["guess3"]) || !isset($_POST["guess4"]) ||
        !isset($_POST["guess5"])) {
        die("<p style='color: red;'>Error: Missing number, text, or guesses.</p>");
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
        die("<p style='color: red;'>Error: Invalid response from Python. Debug Output: <pre>$output</pre></p>");
    }

    $result = json_decode($json_output, true);

    if ($result === null) {
        die("<p style='color: red;'>Error: Invalid JSON response. Debug Output: <pre>$output</pre></p>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results of Your Adventure</title>
    <script>
        function showPopup(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <h2>Your Adventure Results</h2>

    <?php if (isset($result['error'])): ?>
        <p style="color: red;">Error: <?php echo htmlspecialchars($result['error']); ?></p>
    <?php else: ?>
        <p><strong>Number Puzzle:</strong> <?php echo htmlspecialchars($result["number_result"]); ?></p>
        <p><strong>Binary Text:</strong> <?php echo htmlspecialchars($result["binary_text"]); ?></p>
        <p><strong>Vowel Count:</strong> <?php echo htmlspecialchars($result["vowel_count"]); ?></p>
        <p><strong>Treasure Hunt:</strong> <?php echo htmlspecialchars($result["treasure_result"]); ?></p>
        <p><strong>Attempts:</strong> <?php echo implode(", ", array_map('htmlspecialchars', $result["attempts"])); ?></p>

        <?php if (strpos($result["treasure_result"], "You found the treasure") !== false): ?>
            <script>
                showPopup("🎉 YOU WIN! 🎉");
            </script>
        <?php else: ?>
            <script>
                setTimeout(() => {
                    alert("❌ Try Again! Redirecting...");
                    window.location.href = "form.php";
                }, 1000);
            </script>
        <?php endif; ?>

    <?php endif; ?>
</body>
</html>




