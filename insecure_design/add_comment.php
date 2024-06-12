<?php
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['userid'])) {
    $comment = $_POST['comment']; // XSS saldırısı için kullanıcı girdisi
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['userid'];

    // XSS saldırısını gerçekleştirmek için kullanıcı girdilerini doğrudan SQL sorgusuna ekliyoruz
    // Ancak bu sefer mysqli_real_escape_string fonksiyonunu kullanarak özel karakterlerin işlenmesini engelliyoruz.
    $comment = mysqli_real_escape_string($conn, $comment);
    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_post.php?id=$post_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "You must be logged in to comment.";
}
?>
