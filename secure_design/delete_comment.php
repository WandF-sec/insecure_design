<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $commentId = $_GET['id'];

    // Yorumu sil
    $sql = "DELETE FROM comments WHERE id = $commentId";

    if ($conn->query($sql) === TRUE) {
        // Silme başarılı
        echo "Comment deleted successfully";
    } else {
        // Silme başarısız
        echo "Error deleting comment: " . $conn->error;
    }
} else {
    // Geçersiz istek
    echo "Invalid request";
    
}
?>