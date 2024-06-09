<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT price FROM products WHERE id = '$product_id'";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    $total_price = $product['price'] * $quantity;

    $sql = "INSERT INTO transactions (user_id, product_id, quantity, total_price) VALUES ('$user_id', '$product_id', '$quantity', '$total_price')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Transaction successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
