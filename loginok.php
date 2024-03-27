<?php
// Mulai session
session_start();

// Periksa apakah session telah terdaftar untuk username tersebut
if(isset($_SESSION['username'])) {
    // Dan jika terdaftar
    echo 'Selamat Datang, ' . $_SESSION['username'] . '! Session anda telah terdaftar. Session hanya akan terhapus jika anda melakukan <a href="http://localhost/logout.php">logout</a>.';
} else {
    // Jika tidak terdaftar, kembalikan user ke login.html
    echo '<meta http-equiv="refresh" content="0;url=http://localhost/login.html">';
    exit; // Pastikan tidak ada kode yang dieksekusi setelah melakukan redirect
}
?>
