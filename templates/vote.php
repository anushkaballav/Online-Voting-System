<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['voter_id'])) {
    header("Location: login.html");
    exit();
}

// Get voter ID and selected candidate
$voter_id = $_POST['voter_id'];
$candidate = $_POST['candidate'];

// Prevent double voting
$sql_check = "SELECT * FROM votes WHERE voter_id = '$voter_id'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "<script>alert('You have already voted!'); window.location.href='dashboard.php';</script>";
    exit();
}

// Save vote to database
$sql = "INSERT INTO votes (voter_id, candidate) VALUES ('$voter_id', '$candidate')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Vote submitted successfully!'); window.location.href='dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>