<?php
// Database connection
include('dbconnection.php');

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Delete the order from the database
    $query = "DELETE FROM orders WHERE id = $order_id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}

// Close database connection
mysqli_close($conn);
?>
