<?php 
include 'database.php';

/* 
* Get Total Questions
*/
$query = "SELECT * FROM questions";

// Get results
$result = $mysqli->query($query) or die($mysqli->error . ' on line ' . __LINE__);
$total = $result->num_rows;

// Calculate the total estimated time (1.5 seconds per question)
$estimated_time = $total * 1.5; // Time in seconds
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Quizzer</title>

    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>

<header>
    <div class="container">
        <h1>PHP Quizzer</h1>
    </div>
</header>

<main>
    <div class="container">
        <h2>Test Your PHP Knowledge in Programming</h2>
        <p>This is a multiple choice test to test your knowledge of PHP.</p>

        <ul>
            <li><strong>Number of questions:</strong> <?php echo $total; ?> </li>
            <li><strong>Type:</strong> Multiple Choice</li>
            <li><strong>Estimated Time:</strong> <?php echo $estimated_time; ?> seconds</li>
        </ul>

        <a href="question.php?n=1" class="start">Start Quiz</a>
    </div>
</main>

<footer>
    <div class="container">
        &copy; 2025, PHP smart coding Learning System
    </div>
</footer>

</body>
</html>
