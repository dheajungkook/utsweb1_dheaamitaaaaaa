<?php
session_start();

// hapus semu session 
session_unset();
session_destroy();

// kembali ke halaman login
header("location: login.php");
exit;