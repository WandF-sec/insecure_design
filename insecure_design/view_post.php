<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .post-title {
            font-size: 2rem;
            color: #007bff;
        }
        .post-meta {
            color: #6c757d;
            margin-bottom: 20px;
        }
        .post-content {
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .post img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            border-radius: 5px;
        }
        .comments-section {
            margin-top: 40px;
        }
        .comment-form {
            margin-top: 20px;
        }
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #0056b3;
        }
        .comment {
            margin-bottom: 10px;
        }
        .delete-comment-btn {
            color: red;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo "<div style='color: red; font-weight: bold;'>Invalid post ID</div>";
        } else {
            $post_id = intval($_GET['id']);
            $sql = "SELECT posts.*, users.username AS author_username FROM posts INNER JOIN users ON posts.author_id = users.id WHERE posts.id = $post_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $created_at = isset($row['created_at']) ? date('F j, Y', strtotime($row['created_at'])) : 'Unknown';
        ?>
                <h2 class="post-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                <p class="post-meta">By <?php echo htmlspecialchars($row['author_username']); ?> on <?php echo $created_at; ?></p>
                <div class="post-content">
                    <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                </div>
                <?php if ($row['image']): ?>
    <?php
    // Görüntüyü yeniden boyutlandırmak için gereken kod
    $image = $row['image'];
    list($width, $height) = getimagesize($image);
    $newWidth = 300;
    $newHeight = 300;
    $imageResized = imagecreatetruecolor($newWidth, $newHeight);
    $imageSource = imagecreatefromjpeg($image);
    imagecopyresized($imageResized, $imageSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    ob_start();
    imagejpeg($imageResized);
    $imageData = ob_get_clean();
    $imageEncoded = 'data:image/jpeg;base64,' . base64_encode($imageData);
    ?>
    <img src="<?php echo $imageEncoded; ?>" alt="Post Image">
<?php endif; ?>

                <!-- Comment Section -->
<div class="comments-section">
    <h3>Comments</h3>
    <?php
    // Yorumları getir
    $sql_comments = "SELECT comments.*, users.username AS commenter_username FROM comments INNER JOIN users ON comments.user_id = users.id WHERE post_id = $post_id ORDER BY created_at DESC";
    $result_comments = $conn->query($sql_comments);

    if ($result_comments && $result_comments->num_rows > 0) {
        while ($comment = $result_comments->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<strong>" . htmlspecialchars($comment['commenter_username']) . "</strong>: " . $comment['comment']; // Kullanıcı girdileri doğrudan ekrana yazılıyor
            // Yorumu sadece adminler silebilir
            if ($_SESSION['role'] === 'admin') {
                echo " <span class='delete-comment-btn' onclick='deleteComment(" . $comment['id'] . ")'>Delete</span>";
            }
            echo "</div>";
        }
    } else {
        echo "No comments yet.";
    }
    ?>
</div>

                <!-- Comment Form -->
                <div class="comment-form">
                    <h3>Add a Comment</h3>
                    <form id="comment-form" action="add_comment.php" method="POST">
                        <textarea name="comment" placeholder="Write your comment here..." required></textarea>
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <button type="submit">Submit</button>
                    </form>
                </div>
        <?php
            } else {
                echo "<div style='color: red; font-weight: bold;'>Post not found</div>";
            }
        }
        ?>
        
    </div>

    <script>
    function deleteComment(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            // AJAX ile yorumu sil
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Silme işlemi başarılıysa sayfayı yenile
                    if (this.responseText.trim() === "Comment deleted successfully") {
                        location.reload();
                    } else {
                        alert("Error deleting comment!");
                    }
                }
            };
            xhttp.open("GET", "delete_comment.php?id=" + commentId, true);
            xhttp.send();
        }
    }
</script>
</body>
</html>

<?php include 'includes/footer.php'; ?>
