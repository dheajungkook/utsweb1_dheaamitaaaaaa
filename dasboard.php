<?php
session_start();

// cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("location login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <tittle>dashboard</tittle>
</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
    <p>role: <?php echo $_SESSION['role']; ?><p>
    <a  href="logout.php">logout</a>
</body>
</html>