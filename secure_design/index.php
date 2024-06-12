<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<div class="container">
    <form action="" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search for posts..." class="search-input">
        <button type="submit" class="search-button">Search</button>
    </form>

    <?php
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM posts";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <div class="posts">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo substr(htmlspecialchars($row['content']), 0, 100); ?>...</p>
                    <?php if ($row['image']): ?>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image">
                    <?php endif; ?>
                    <a class="read-more" href="view_post.php?id=<?php echo $row['id']; ?>">Read More</a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #333;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .posts {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        grid-gap: 20px;
    }

    .post {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .post h2 {
        margin-top: 0;
    }

    .post p {
        margin-bottom: 20px;
    }

    .post img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .read-more {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .read-more:hover {
        text-decoration: underline;
    }
    .search-form {
        display: flex;
        margin-bottom: 20px;
    }

    .search-input {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
    }

    .search-button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .search-button:hover {
        background-color: #0056b3;
    }
</style>

</body>
</html>
