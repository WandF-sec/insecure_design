<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Kullanıcıyı sil
    $sql = "DELETE FROM users WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        // Silme başarılı
        echo "User deleted successfully";
    } else {
        // Silme başarısız
        echo "Error deleting user: " . $conn->error;
    }
} else {
    // Geçersiz istek
    echo "Invalid request";
}

// Kullanıcı kontrol sayfasına geri yönlendir
header("Location: user_control.php");
exit();
?>
