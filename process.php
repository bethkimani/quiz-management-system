<?php 
include 'database.php'; 
session_start(); 

// Check to see if score is set
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

if ($_POST) {
    $number = $_POST['number'];
    $selected_choice = $_POST['Choice'];
    $next = $number + 1;  // Properly increment the question number

    // Get total questions
    $query = "SELECT * FROM `questions`";
    $results = $mysqli->query($query) or die($mysqli->error . ' on line ' . __LINE__);
    $total = $results->num_rows;

    // Get the correct choice for the current question
    $query = "SELECT * FROM `Choices` WHERE question_number = $number AND is_correct = 1";
    $result = $mysqli->query($query) or die($mysqli->error . ' on line ' . __LINE__);
    $row = $result->fetch_assoc();
    $correct_choice = $row['id'];

    // Compare selected choice with the correct answer
    if ($correct_choice == $selected_choice) {
        $_SESSION['score']++;  // Increment score if the answer is correct
    }

    // If all questions are answered, redirect to the final page
    if ($number == $total) {
        header("Location: final.php");
        exit();
    } else {
        // Redirect to the next question
        header("Location: question.php?n=" . $next);
        exit();
    }
}
?>
