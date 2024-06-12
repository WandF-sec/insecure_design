<?php
include 'includes/db.php';
include 'includes/header.php';


$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['userid'];

    // Dosya yükleme işlemi
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Dosyanın türünü kontrol et
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } else {
        // Dosya boyutunu kontrol et (örneğin maksimum 2MB)
        if ($_FILES["image"]["size"] > 2000000) {
            $error_message = "Sorry, your file is too large. Max file size is 2MB.";
        } else {
            // Dosyayı taşı
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Dosya yükleme başarılıysa veritabanına ekle
                $image_path = $target_file;
                $sql = "INSERT INTO posts (title, content, author_id, image) VALUES ('$title', '$content', '$author_id', '$image_path')";

                if ($conn->query($sql) === TRUE) {
                    echo "New post created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Post</h1>
        <?php if (!empty($error_message)): ?>
            <p><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="add_post.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="content" placeholder="Content" required></textarea>
            <input type="file" name="image">
            <button type="submit">Add Post</button>
        </form>
    </div>
</body>
</html>
