<?php
ob_start(); // Çıktı tamponlamasını başlat

include 'includes/db.php';
include 'includes/header.php';

$error_message = ''; // Hata mesajını tanımla

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Güvenli şekilde SQL sorgusu oluştur
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Kullanıcı rolüne göre yönlendirme yap
        if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'editor') {
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <?php if(!empty($error_message)) echo "<p class='error'>$error_message</p>"; ?>
    </form>
</body>
</html>
