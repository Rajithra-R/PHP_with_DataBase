<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$score = 0;

// Fetch questions from the database
$query = "SELECT * FROM questions";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $question_id = $row['id'];
    $correct_option = $row['correct_option'];

    // Check user's response
    if (isset($_POST["question_$question_id"]) && $_POST["question_$question_id"] === $correct_option) {
        $score++;
    }
}

// Insert score into the database
$stmt = $conn->prepare("INSERT INTO scores (username, score) VALUES (?, ?)");
$stmt->bind_param("si", $username, $score);
$stmt->execute();

// Display results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS -->
</head>
<body>
    <div class="container">
        <h1>Quiz Submitted Successfully!</h1>
        <p>Name: <?php echo htmlspecialchars($username); ?></p>
        <p>Your Score: <?php echo $score; ?></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
