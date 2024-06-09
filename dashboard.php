<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Get user details
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Get transaction details
$sql = "SELECT COUNT(*) as transaction_count, SUM(total_price) as total_sales FROM transactions WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$transaction_data = $result->fetch_assoc();

// Get number of customers and sellers
$sql = "SELECT COUNT(*) as customer_count FROM users WHERE role = 'customer'";
$customer_count = $conn->query($sql)->fetch_assoc()['customer_count'];

$sql = "SELECT COUNT(*) as seller_count FROM users WHERE role = 'seller'";
$seller_count = $conn->query($sql)->fetch_assoc()['seller_count'];

// Get commissions
$sql = "SELECT SUM(amount) as total_commissions FROM commissions WHERE user_id = '$user_id'";
$total_commissions = $conn->query($sql)->fetch_assoc()['total_commissions'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <div class="dashboard">
        <div class="card">
            <h2>Transactions</h2>
            <p>Number of Transactions: <?php echo $transaction_data['transaction_count']; ?></p>
            <p>Total Sales: $<?php echo $transaction_data['total_sales']; ?></p>
        </div>
        <div class="card">
            <h2>Users</h2>
            <p>Number of Customers: <?php echo $customer_count; ?></p>
            <p>Number of Sellers: <?php echo $seller_count; ?></p>
        </div>
        <div class="card">
            <h2>Commissions</h2>
            <p>Total Commissions Earned: $<?php echo $total_commissions; ?></p>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
