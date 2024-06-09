<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <form action="register.php" method="POST">
        <h2>Register</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <label for="role">Role:</label>
        <select name="role">
            <option value="seller">Seller</option>
            <option value="customer">Customer</option>
        </select>
        <label for="sponsor_id">Sponsor ID (optional):</label>
        <input type="number" name="sponsor_id">
        <button type="submit">Register</button>
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $sponsor_id = isset($_POST['sponsor_id']) ? $_POST['sponsor_id'] : NULL;

    $sql = "INSERT INTO users (username, password, role, sponsor_id, join_date) VALUES ('$username', '$password', '$role', '$sponsor_id', CURDATE())";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
