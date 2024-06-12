<?php
ob_start(); // Çıktı tamponlamasını başlat

session_start();
include 'includes/db.php';
include 'includes/header.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete_post'])) {
        // Blog yazısını silme işlemi
        $post_id = $_POST['post_id'];
        $sql = "DELETE FROM posts WHERE id=$post_id";
        if ($conn->query($sql) === TRUE) {
            $error_message = "Post has been deleted successfully.";
        } else {
            $error_message = "Error deleting post: " . $conn->error;
        }
    }
}

// CSRF saldırısı için form
function generateCSRFToken() {
    return bin2hex(random_bytes(32));
}

$_SESSION['csrf_token'] = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>CSRF Vulnerability Example - Delete Post</h2>

    <?php
    // CSRF saldırısı için form
    if(isset($_SESSION['username']) && $_SESSION['role'] == 'user') {
        echo "<form action='' method='POST'>";
        echo "<input type='hidden' name='post_id' value='1'>"; // Silinecek blog yazısının ID'si
        echo "<input type='hidden' name='csrf_token' value='{$_SESSION['csrf_token']}'>";
        echo "<button type='submit' name='delete_post'>Delete Post</button>";
        echo "</form>";
    } else {
        echo "<p>Login as a normal user to trigger CSRF vulnerability.</p>";
    }
    ?>

    <?php if(!empty($error_message)) { ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php } ?>

</body>
</html>
