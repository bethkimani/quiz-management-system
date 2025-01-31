<?php
include 'database.php';

if (isset($_POST['submit'])) {
    echo 'Submit was clicked<br>';

    // Get and sanitize variables
    $question_number = mysqli_real_escape_string($mysqli, $_POST['question_number']);
    $question_text = mysqli_real_escape_string($mysqli, $_POST['question_text']);
    $correct_choice = intval($_POST['correct_choice']);

    if (empty($question_number) || empty($question_text) || $correct_choice < 1 || $correct_choice > 5) {
        echo "Please fill out all required fields and ensure correct choice is between 1 and 5.<br>";
        exit;
    }

    // Choices array
    $choices = array();
    for ($i = 1; $i <= 5; $i++) {
        $choices[$i] = mysqli_real_escape_string($mysqli, $_POST['choice' . $i]);
    }

    // Check for at least one non-empty choice
    if (count(array_filter($choices)) === 0) {
        echo "At least one choice must be filled out.<br>";
        exit;
    }

    // Question Query
    $query = "INSERT INTO `questions`(question_number, text) VALUES('$question_number', '$question_text')";
    // Removed debugging output for the question query
    // echo 'Question Query: ' . $query . '<br>'; // Debugging query

    // Run the query for the question
    if ($insert_row = $mysqli->query($query)) {
        echo 'Question Inserted Successfully!<br>';

        // Loop through choices and insert them
        foreach ($choices as $choice => $value) {
            if (!empty($value)) { // Only insert non-empty choices
                // Check if the choice is correct
                $is_correct = ($correct_choice == $choice) ? 1 : 0;

                // Choice query
                $query = "INSERT INTO `Choices`(question_number, is_correct, text) VALUES('$question_number', $is_correct, '$value')";
                // Removed debugging output for the choice query
                // echo 'Choice Query: ' . $query . '<br>'; // Debugging query

                // Run query for choices
                if ($mysqli->query($query)) {
                    echo 'Choice #' . $choice . ' Inserted Successfully!<br>';
                } else {
                    echo 'Error inserting choice #' . $choice . ': ' . $mysqli->error . '<br>';
                }
            } else {
                echo 'Choice #' . $choice . ' is empty and will not be inserted.<br>';
            }
        }

        $msg = 'Question has been added successfully!';
    } else {
        echo 'Error inserting question: ' . $mysqli->error . '<br>';
    }
}

// Get total questions
$query = "SELECT * FROM `questions`";
$questions = $mysqli->query($query) or die($mysqli->error . ' on line ' . __LINE__);
$total = $questions->num_rows;
$next = $total + 1;

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

        <h2>Add a Question</h2>

        <?php
        if (isset($msg)) {
            echo '<p>' . $msg . '</p>';
        }
        ?>

        <form method="post" action="add.php">
            <p>
                <label>Question Number:</label>
                <input type="text" value="<?php echo $next; ?>" name="question_number" required />
            </p>

            <p>
                <label>Question Text:</label>
                <input type="text" name="question_text" required />
            </p>

            <p>
                <label>Choice #1: </label>
                <input type="text" name="choice1" required />
            </p>
            <p>
                <label>Choice #2: </label>
                <input type="text" name="choice2" required />
            </p>

            <p>
                <label>Choice #3: </label>
                <input type="text" name="choice3" required />
            </p>

            <p>
                <label>Choice #4: </label>
                <input type="text" name="choice4" required />
            </p>

            <p>
                <label>Choice #5: </label>
                <input type="text" name="choice5" />
            </p>

            <p>
                <label>Correct Choice Number:</label>
                <input type="number" name="correct_choice" min="1" max="5" required />
            </p>

            <p>
                <input type="submit" name="submit" value="submit" />
            </p>
        </form>
    </div>
</main>

<footer>
    <div class="container">
        Copyright &copy;2025, PHP Quizzer
    </div>
</footer>

</body>
</html>