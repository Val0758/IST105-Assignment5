<?php  
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $number = $_POST["number"];
    $text = $_POST["text"];

    // Execute Python script and capture output
    $cmd = "python3 process.py " . escapeshellarg($number) . " " . escapeshellarg($text);
    $output = shell_exec($cmd);

    // Check if output exists and decode JSON
    $result = json_decode($output, true);

    // Debugging: If JSON decoding fails, show the error
    if ($result === null) {
        echo "<h2>Error:</h2>";
        echo "<p>Invalid response from Python script.</p>";
        echo "<p>Raw Output: <pre>$output</pre></p>";
        exit; // Stop further execution
    }

    echo "<h2>Results</h2>";

    // Handle cases where expected keys are missing
    echo "<p><strong>Number Puzzle:</strong> " . ($result["number_result"] ?? "N/A") . "</p>";
    echo "<p><strong>Text Puzzle:</strong> Binary: " . ($result["binary_text"] ?? "N/A") . " | Vowel Count: " . ($result["vowel_count"] ?? "N/A") . "</p>";
    echo "<p><strong>Treasure Hunt:</strong> " . ($result["treasure_result"] ?? "N/A") . "</p>";

    // Handle attempts safely
    if (isset($result["attempts"]) && is_array($result["attempts"])) {
        echo "<p><strong>Attempts:</strong> " . implode(", ", array_map('htmlspecialchars', $result["attempts"])) . "</p>";
    } else {
        echo "<p><strong>Attempts:</strong> No attempts recorded.</p>";
    }
}
?>


