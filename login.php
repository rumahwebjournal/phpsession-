<?php
//periksa apakah file ini tidak dipanggil secara langsung, jika dipanggil secara langsung
//maka user akan di kembalikan ke login.thml
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: http://localhost/login.html");
    exit;
}

//melihat apakah form telah diisi semua atau tidak. Jika tidak, user akan dikembalikan ke
//halaman login.html
elseif (empty($_POST['username']) || empty($_POST['password'])) {
    header("Location: http://localhost/login.html");
    exit;
} else {
    //mengubah username dan password yang telah dimasukkan menjadi sebuah variabel dan meng-enkripsi password ke md5
    $user = addslashes($_POST['username']);
    $pass = md5($_POST['password']);

    //variabel untuk koneksi ke database
    $dbHost = "localhost";
    $dbUser = "root"; //user yang akan digunakan pada database.
    $dbPass = ""; //password dari username untuk database.
    $dbDatabase = "coba"; //dari database yang dibuat tadi

    //Melakukan koneksi ke database menggunakan PDO (PHP Data Objects)
    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbDatabase", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("koneksi gagal nih, cek apakah variabel sudah benar apa belum: " . $e->getMessage());
    }

    //Query untuk memeriksa username dan password
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':password', $pass);

    //Eksekusi query
    $stmt->execute();

    //melihat apakah username dan password yang dimasukkan benar
    $rowCheck = $stmt->rowCount();

    //jika benar maka
    if ($rowCheck > 0) {
        //mulai session dan register variabelnya
        session_start();
        $_SESSION['username'] = $user;

        //Memberitahu jika login sukses
        echo 'login berhasil..!!';

        //redirect ke halaman lain untuk lebih memastikan
        echo '<meta http-equiv="refresh" content="3;url=loginok.php">';
        exit;
    } else {
        //jika $rowCheck = 0, berarti username atau password salah, atau tidak terdaftar di database
        echo 'Invalid username or password, coba lagi deh.. ';
    }
}
?>
