<?php  
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $number = $_POST["number"];
    $text = $_POST["text"];

    $cmd = "python3 process.py " . escapeshellarg($number) . " " . escapeshellarg($text);
    $output = shell_exec($cmd);
    $result = json_decode($output, true);

    echo "<h2>Results</h2>";
    echo "<p><strong>Number Puzzle:</strong> " . $result["number_result"] . "</p>";
    echo "<p><strong>Text Puzzle:</strong> Binary: " . $result["binary_text"] . " | Vowel Count: " . $result["vowel_count"] . "</p>";
    echo "<p><strong>Treasure Hunt:</strong> " . $result["treasure_result"] . "</p>";
    echo "<p><strong>Attempts:</strong> " . implode(", ", $result["attempts"]) . "</p>";
}
?>
