<?php
// Database connection
include 'connectDB.php'; // Adjust the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['h_id']) && isset($_POST['h_vne'])) {
        $h_id = mysqli_real_escape_string($conn, $_POST['h_id']); // Sanitize input
        $h_vne = mysqli_real_escape_string($conn, $_POST['h_vne']); // Sanitize input

        // Check if the item already exists in the d_zah table
        $check_query = "SELECT * FROM d_zah WHERE dh_id = '$h_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Item exists, so increment the quantity
            $update_query = "UPDATE d_zah SET dtoo = dtoo + 1, dvne = dvne + '$h_vne' WHERE dh_id = '$h_id'";
            if (mysqli_query($conn, $update_query)) {
                //$message = "Item quantity updated successfully.";
            } else {
                $message = "Error updating item: " . mysqli_error($conn);
            }
        } else {
            // Item does not exist, insert new entry
            $insert_query = "INSERT INTO d_zah (dh_id, dtoo, dvne) VALUES ('$h_id', '1', '$h_vne')";
            if (mysqli_query($conn, $insert_query)) {
               // $message = "Item added to order successfully.";
            } else {
                $message = "Error adding item: " . mysqli_error($conn);
            }
        }
        

        // Fetch total items count from d_zah table
        $undaa_query = "SELECT SUM(dtoo) AS total_items FROM d_zah";
        $undaa_run = mysqli_query($conn, $undaa_query);
        $total_items = 0;

        if ($undaa_run && $row = mysqli_fetch_assoc($undaa_run)) {
            $total_items = $row['total_items'];  // Get total items
        }

        $response = array('status' => 'success', 'message' => $message, 'total_items' => $total_items);
        echo json_encode($response);

    } else {
        // If the required POST data is missing
        echo json_encode(array('status' => 'error', 'message' => 'Invalid data.'));
    }
} else {
    // If the request method is not POST
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
}



// Close the database connection
mysqli_close($conn);
?>
