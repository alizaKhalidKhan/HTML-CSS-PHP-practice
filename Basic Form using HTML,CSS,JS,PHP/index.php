<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "crud_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $conn->query("INSERT INTO users (name, email, age) VALUES ('$name', '$email', '$age')");
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $conn->query("UPDATE users SET name='$name', email='$email', age='$age' WHERE id=$id");
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM users WHERE id=$id");
    }
}

// Fetch all records
$users = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>CRUD Application</h2>

    <!-- Form to Add or Update Data -->
    <form method="POST" action="index.php">
        <input type="hidden" name="id" id="user_id">
        <label>Name:</label>
        <input type="text" name="name" id="name" required>
        <label>Email:</label>
        <input type="email" name="email" id="email" required>
        <label>Age:</label>
        <input type="number" name="age" id="age" required>
        <button type="submit" name="add" id="add_button">Add User</button>
        <button type="submit" name="update" id="update_button" style="display:none;">Update User</button>
    </form>

    <!-- Table to Display Data -->
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td>
                <button onclick="editUser(<?php echo $row['id'] ?>, '<?php echo $row['name'] ?>', '<?php echo $row['email'] ?>', <?php echo $row['age'] ?>)">Edit</button>
                <form method="POST" action="index.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <script src="script.js"></script>
</body>
</html>
