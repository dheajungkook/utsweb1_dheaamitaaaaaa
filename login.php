<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dasboard.php");
    exit;
}

// Proses login sederhana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Contoh login statis (bisa kamu ubah nanti)
    if ($username === 'dhea' && $password === '123') {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'Dosen';
        header("Location: dasboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - POLGAN MART</title>
<style>
    /* Tema Pink Peach Login */
:root {
    --peach: #ffb6ab;
    --peach-soft: #ffe5e1;
    --peach-dark: #ff9689;
}

body {
    font-family: Arial;
    background: var(--peach-soft);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}

.login-box {
    background:white;
    padding:35px;
    width:350px;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    text-align:center;
}

.login-box h2 {
    color: var(--peach-dark);
    margin-bottom: 20px;
}

input {
    width:100%;
    padding:12px;
    margin:10px 0;
    border:2px solid var(--peach);
    border-radius:10px;
    background:#fff7f6;
}

input:focus {
    outline:none;
    background:white;
    border-color: var(--peach-dark);
}

button {
    width:100%;
    padding:12px;
    background: var(--peach);
    border:none;
    border-radius:10px;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

button:hover {
    background: var(--peach-dark);
}

</style>
</head>
<body>
<div class="login-card">
    <h2>POLGAN MART</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>