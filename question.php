<?php 
include 'database.php'; 

// See question number
$number = (int) $_GET['n'];

/*
* Get Question 
*/
$query = "SELECT * FROM `questions` WHERE question_number = $number";

// Get result
$result = $mysqli->query($query) or die($mysqli->error . ' on line ' . __LINE__);

// Fetch the question
$question = $result->fetch_assoc();

/* 
* Get Choices
*/
$query = "SELECT * FROM `Choices` WHERE question_number = $number";

// Get result
$Choices = $mysqli->query($query) or die($mysqli->error . ' on line ' . __LINE__);

// Get total number of questions
$total_query = "SELECT COUNT(*) AS total FROM `questions`";
$total_result = $mysqli->query($total_query) or die($mysqli->error . ' on line ' . __LINE__);
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];
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
        <div class="current">Question <?php echo $question['question_number']; ?> of <?php echo $total; ?></div>
        <p class="question">
            <?php echo $question['text']; ?>
        </p>

        <form method="post" action="process.php">
            <ul class="choices">
                <?php while($row = $Choices->fetch_assoc()): ?>
                    <li>
                        <input name="choice" type="radio" value="<?php echo $row['id']; ?>" /> 
                        <?php echo $row['text']; ?>
                    </li>
                <?php endwhile; ?>
            </ul>

            <input type="submit" value="Submit" />
            <input type="hidden" name="number" value="<?php echo $number; ?>" />
        </form>
    </div>
</main>

<footer> 
    <div class="container">
        &copy; 2025, PHP Quizzer
    </div>
</footer>

</body>
</html>
