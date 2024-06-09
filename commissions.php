<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];

// Get commission details
$sql = "SELECT * FROM commissions WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$commissions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $commissions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commissions</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <h1>Your Commissions</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commissions as $commission): ?>
                <tr>
                    <td><?php echo $commission['date']; ?></td>
                    <td>$<?php echo $commission['amount']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
