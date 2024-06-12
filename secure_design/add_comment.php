<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userid'])) {
    // XSS saldırılarına karşı kullanıcı girdilerini güvenli hale getir
    $comment = htmlspecialchars($_POST['comment']); // htmlspecialchars kullanarak özel karakterleri kaçırmak için
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['userid'];

    // Veritabanına veri eklemek için güvenli bir şekilde hazırla
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $user_id, $comment);

    if ($stmt->execute()) {
        header("Location: view_post.php?id=$post_id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "You must be logged in to comment.";
}
?>
