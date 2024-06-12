<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<style>
    /* Genel stiller */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px;
    }

    /* Başlık stilleri */
    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    /* Tablo stilleri */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }

    /* Düğme stilleri */
    .btn {
        display: inline-block;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn-view {
        background-color: #4caf50;
        color: #fff;
    }

    .btn-edit {
        background-color: #2196F3;
        color: #fff;
    }

    .btn-delete {
        background-color: #f44336;
        color: #fff;
    }

    .btn:hover {
        opacity: 0.8;
    }

    /* Üst menü stilleri */
    .top-menu {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .top-menu a {
        margin-right: 20px;
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }

    .top-menu a:hover {
        color: #666;
    }

    .logout-btn {
        padding: 8px 16px;
        background-color: #f44336;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .logout-btn:hover {
        background-color: #d32f2f;
    }
</style>

<div class="container">
    <div class="top-menu">
        <div>
            <a href="user_control.php" class="btn">User Control</a>
            <a href="add_post.php" class="btn">Add Post</a>
        </div>
        <button class="logout-btn" onclick="location.href='logout.php'">Logout</button>
    </div>

    <h1>Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT posts.*, users.username AS author_username 
                    FROM posts 
                    INNER JOIN users ON posts.author_id = users.id";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()): 
            ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author_username']; ?></td>
                    <td>
                        <a class="btn btn-view" href="view_post.php?id=<?php echo $row['id']; ?>">View</a>
                        <a class="btn btn-edit" href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="btn btn-delete" href="delete_post.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
