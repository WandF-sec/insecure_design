<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; // MySQL kurulumunda belirlediğiniz root kullanıcı adı
$password = "1234"; // MySQL kurulumunda belirlediğiniz root şifresi
$dbname = "blog_db";

// Veritabanı bağlantısı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


