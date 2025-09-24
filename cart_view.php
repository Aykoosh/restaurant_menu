<?php
session_start();
include 'connectDB.php'; // Ensure you have a connection to your database

// Use a JOIN query to fetch product details
$undaa_query = "SELECT h.h_id, h.h_ner, h.h_vne, d.dtoo, d.dvne 
                FROM d_zah d INNER JOIN hool h 
                ON d.dh_id = h.h_id"; // Correct JOIN syntax
$undaa_run = mysqli_query($conn, $undaa_query);

$cart_items = []; // Initialize cart items
$total = 0; // Initialize total

if ($undaa_run) {
    while ($row = mysqli_fetch_assoc($undaa_run)) {
        $cart_items[$row['h_id']] = $row; // Map the product details by their ID
        $total += $row['h_vne'] * $row['dtoo']; // Calculate total
    }
} else {
    // Log the error instead of echoing it directly
    error_log("Error fetching items: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Your Cart</h1>

    <?php if (!empty($cart_items)): ?> <!-- Check if cart is not empty -->
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo $item['h_ner']; ?></td>
                    <td><?php echo number_format($item['h_vne'], 2); ?></td>
                    <td><?php echo $item['dtoo']; ?></td>
                    <td><?php echo number_format($item['dvne'], 2); ?></td>
                    <td><a href="remove.php?id=<?php echo $item['h_id']; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
            
            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td colspan="2"><strong><?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
