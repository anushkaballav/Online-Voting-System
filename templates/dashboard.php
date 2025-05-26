<?php
session_start();
include 'connection.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['voter_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Get voter details
$voter_id = $_SESSION['voter_id'];
$sql = "SELECT * FROM voters WHERE voter_id = '$voter_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $voter = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css"> <!-- Add your styles here -->
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($voter['fname']); ?>! 🗳️</h1>
        <p>Your Voter ID: <strong><?php echo htmlspecialchars($voter_id); ?></strong></p>
        
        <h2>🗳️ Cast Your Vote</h2>
        <form action="vote.php" method="POST">
            <input type="hidden" name="voter_id" value="<?php echo $voter_id; ?>">
            
            <label>
                <input type="radio" name="candidate" value="Candidate 1" required>
                Candidate 1
            </label><br>

            <label>
                <input type="radio" name="candidate" value="Candidate 2">
                Candidate 2
            </label><br>

            <label>
                <input type="radio" name="candidate" value="Candidate 3">
                Candidate 3
            </label><br>

            <button type="submit">Submit Vote</button>
        </form>

        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>