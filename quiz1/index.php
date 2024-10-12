<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch questions from the database
$query = "SELECT * FROM questions";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Management</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS -->
</head>
<body>
    <div class="container">
        <h1>Online Quiz</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <p><a href="logout.php">Logout</a></p> <!-- Logout Link -->
        
        <form action="submit_quiz.php" method="POST">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div>
                    <p><?php echo htmlspecialchars($row['question_text']); ?></p>
                    <input type="radio" name="question_<?php echo $row['id']; ?>" value="A" required> <?php echo htmlspecialchars($row['option_a']); ?><br>
                    <input type="radio" name="question_<?php echo $row['id']; ?>" value="B"> <?php echo htmlspecialchars($row['option_b']); ?><br>
                    <input type="radio" name="question_<?php echo $row['id']; ?>" value="C"> <?php echo htmlspecialchars($row['option_c']); ?><br>
                    <input type="radio" name="question_<?php echo $row['id']; ?>" value="D"> <?php echo htmlspecialchars($row['option_d']); ?><br>
                </div>
            <?php endwhile; ?>
            <button type="submit">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
