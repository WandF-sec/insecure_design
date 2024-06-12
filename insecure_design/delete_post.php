<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Postu sil
    $sql = "DELETE FROM posts WHERE id = $postId";

    if ($conn->query($sql) === TRUE) {
        // Silme başarılı
        echo "Post deleted successfully";
    } else {
        // Silme başarısız
        echo "Error deleting post: " . $conn->error;
    }
} else {
    // Geçersiz istek
    echo "Invalid request";
}

// Anasayfaya geri yönlendir
header("Location: dashboard.php");
exit();
?>