<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET role='$role' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "User role updated successfully";
    } else {
        echo "Error updating user role: " . $conn->error;
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<style>
    /* CSS kodu */
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
</style>

<div class="dashboard-container">
    <h1>User Control</h1>
    <table class="user-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <form action="edit_user.php" method="POST">
                                <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                <select name="role">
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                    <option value="user">User</option>
                                </select>
                                <button type="submit">Update Role</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
