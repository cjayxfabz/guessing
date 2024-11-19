<?php
session_start();

if (!isset($_SESSION['number_to_guess'])) {
    $_SESSION['number_to_guess'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
}

$number_to_guess = $_SESSION['number_to_guess'];
$attempts = $_SESSION['attempts'];
$message = "";


if (isset($_POST['guess'])) {
    $guess = (int)$_POST['guess'];
    $attempts++;
    $_SESSION['attempts'] = $attempts;

    if ($guess < $number_to_guess) {
        $message = "Too low! Try again.";
    } elseif ($guess > $number_to_guess) {
        $message = "Too high! Try again.";
    } else {
        $message = "Congratulations! You guessed the number.";
        session_destroy();
    }

    if ($attempts >= 10 && $guess != $number_to_guess) {
        $message = "You lose! The number was $number_to_guess.";
        session_destroy();
    }
}

if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guessing Game</title>
</head>
<body>
    <h1>PHP Guessing Game</h1>
    <p><?php echo $message; ?></p>

    <?php if ($attempts < 10 && $message !== "Congratulations! You guessed the number."): ?>
        <form method="post">
            <label for="guess">Enter your guess (1-100): </label>
            <input type="number" name="guess" id="guess" min="1" max="100" required>
            <button type="submit">Submit</button>
        </form>
        <p>Attempt: <?php echo $attempts; ?> / 10</p>
    <?php endif; ?>

    <form method="post">
        <button type="submit" name="reset">Restart Game</button>
    </form>
</body>
</html>
