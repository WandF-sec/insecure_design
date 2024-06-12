<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<style>
    /* CSS kodu */
    body {
        font-family: Arial, sans-serif;
    }

    form {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    form input[type="text"],
    form textarea {
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    form button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #0056b3;
    }
</style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$post_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Post updated successfully</p>";
    } else {
        echo "<p style='color: red;'>Error updating post: " . $conn->error . "</p>";
    }
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p style='color: red; font-weight: bold;'>Invalid post ID</p>";
} else {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <form action="edit_post.php" method="POST">
            <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
            <input type="text" name="title" value="<?php echo $row['title']; ?>" required>
            <textarea name="content" required><?php echo $row['content']; ?></textarea>
            <button type="submit">Update Post</button>
        </form>
<?php
    } else {
        echo "<p style='color: red; font-weight: bold;'>Post not found</p>";
    }
}
?>

<?php include 'includes/footer.php'; ?>
