<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<style>
    /* CSS kodu */
    .user-control-container {
        margin: 20px;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .user-table th,
    .user-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .user-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .action-buttons .btn {
        margin-right: 5px;
        padding: 8px 16px;
        text-decoration: none;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn-edit {
        background-color: #2196F3;
    }

    .btn-delete {
        background-color: #f44336;
    }

    .btn:hover {
        opacity: 0.8;
    }
</style>

<div class="user-control-container">
    <h1>User Control</h1>
    <table class="user-table">
        <thead>
            <tr>
                <th>Username</th>
                
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()): 
            ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                  
                    <td><?php echo $row['role']; ?></td>
                    <td class="action-buttons">
                        <a class="btn btn-edit" href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="btn btn-delete" href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
