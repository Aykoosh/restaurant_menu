<?php  
session_start();  
include "connectDB.php";  

// Initialize total_items
$total_items = 0;

// Check if 'id' is passed in the URL and fetch its value
if (isset($_GET['id'])) {  
    $b_id = $_GET['id'];  
} else {  
    echo "No ID found in the URL.";  
    exit;  
}  

// Query to get the total items in the cart
$undaa_query = "SELECT SUM(dtoo) as total_items FROM d_zah"; // Adjust based on your table
$undaa_run = mysqli_query($conn, $undaa_query);

if ($undaa_run && $row = mysqli_fetch_assoc($undaa_run)) {
    $total_items = $row['total_items'];  // Get total items if the query runs successfully
} else {
    $total_items = 0; // Ensure it's defined in case of failure
}
?>

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>All Data View</title>  
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>  
        .content {
            margin-top: 10px;
            z-index: 20;
            padding: 50px;
            background-image: url('image/img1.jpg'); 
            /* background-size: cover; 
            background-position: center;  */
        }

        .box {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            margin-top: 20px; 
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            display: inline-block;
        }

        .item-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; 
        }
        
        .item {
            flex: 1 1 calc(33.33% - 20px); 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .item img {
            max-width: 200px;
            height: 200px;
            margin-bottom: 15px;
        }
        
        .item:hover {
            transform: scale(1.05); 
        }
        
        h2 {
            
            font-size: 18px;
            margin-bottom: 10px;
        }
        h1 {
            font-family: 'Segoe Script', cursive; /* Change to any desired font */
    font-size: 30px; /* Adjust font size */
    color: #f8520f; /* Change the font color */
    text-align: center; /* Center the text */
    text-transform: uppercase; /* Make the text uppercase */
    letter-spacing: 2px; /* Add spacing between letters */
    font-weight: bold; /* Make the text bold */
    margin-top: 8px; /* Adjust the margin at the top */
    margin-bottom: 15px;
    padding: 10px ; 
    
    background-color: #f0f0f0; /* Add a background color */
    border-radius: 10px; /* Slight rounding of the corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    width: 100%; /* Full width for the header */
}

        p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .navbar {  
            background-color: #5d6d7e;  
        }  
        
        .navbar-brand {  
            font-size: 1.5rem;  
            color: #ffffff;  
        }  
        
        .navbar-nav .nav-link {  
            color: #ffffff;  
            padding: 15px 20px;  
            transition: background-color 0.3s;  
        }  
        
        .navbar-nav .nav-link:hover {  
            background-color: rgba(255, 255, 255, 0.2);  
            color: #ffffff;  
        }  
        
        .navbar-nav .nav-link.active {  
            background-color: rgba(255, 255, 255, 0.3);  
            border-radius: 5px;  
        }  
        
        .navbar-nav .nav-link.disabled {  
            color: rgba(255, 255, 255, 0.5);  
        }  

        
        .navbar-brand.navactive {
    font-family: 'Segoe Script', cursive; /* Apply the desired font */
    font-size: 28px; /* Adjust font size as needed */
    color: #f8520f; /* Font color */
    text-transform: uppercase; /* Uppercase the text if desired */
    letter-spacing: 2px; /* Spacing between letters */
    font-weight: bold; /* Make the text bold */
}

        .basket-container {
            position: fixed;
            bottom: 20px; 
            right: 20px;  
            z-index: 1000; 
        }

        .basket-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #8B0000; 
            color: white;
            border: none;
            border-radius: 50%;
            padding: 15px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
            transition: background-color 0.3s ease;
            width: 60px;
            height: 60px;
        }

        .basket-btn i {
            font-size: 24px;
        }

        .basket-btn:hover {
            background-color: #A52A2A; 
        }

        .badge {
    position: absolute; /* Positioning relative to the basket button */
    top: 0; /* Aligns to the top */
    left: 0; /* Aligns to the right */
    background-color: #fff; /* White background for contrast */
    color: #8B0000; /* Same as basket button color for consistency */
    border-radius: 90%; /* Circular shape */
    padding: 5px 6px; /* Padding for size */
    font-weight: bold; /* Bold text */
    font-size: 8px; /* Adjust font size */
    border: 2px solid #8B0000; /* Border matching the button color */
}

.add { 
    text-align: center; 
    background-color: #f8520f; /* Orange background for contrast */
    color: #fff; /* White text for readability */
    border-radius: 20px; /* Rounded corners */
    padding: 5px 10px; /* Vertical and horizontal padding for size */
    font-weight: bold; /* Bold text */
    font-size: 15px; /* Adjust font size */
    border: 2px solid transparent; /* Use 'transparent' instead of '#0000' for clarity */
    cursor: pointer; /* Changes cursor to pointer on hover */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

/* Optional: Add hover effect */
.add:hover {
    background-color: #d84100; /* Darker shade on hover */
}


    </style>  
</head>  
<body>  

<!-- Navigation Bar -->  
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">  
    <a class="navbar-brand navactive" href="#">Амтат ХООЛ</a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">  
        <span class="navbar-toggler-icon"></span>  
    </button>  
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">  
        <ul class="navbar-nav">  
            <li class="nav-item active">  
                <a class="nav-link" href="#coffe">Хоол <span class="sr-only">(current)</span></a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="#undaa">Ус-Ундаа</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="#salat">Салат</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link " href="#busad">Бусад</a>  
            </li>  
        </ul>  
    </div>  
</nav> 

<div class="content"> 
<div> 
    <section id="coffe" class="dh_id_content box">
        <div class="text-content container">
            <h1>Хоол</h1>
            <div class="item-container">
                <?php
             
                $undaa_query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'hool'";
                $undaa_run = mysqli_query($conn, $undaa_query);

               
                if ($undaa_run && mysqli_num_rows($undaa_run) > 0):
                    while ($row = mysqli_fetch_assoc($undaa_run)):
                ?>
                        <div class="item" onclick="add_product('<?php echo $row['h_id']; ?>', '<?php echo $row['h_vne']; ?>');">
                            <?php if (!empty($row['h_zurag'])): ?>
                                <?php 
                            
                                $imageData = base64_encode($row['h_zurag']); 
                                echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Coffe Image" />';
                                ?>
                            <?php else: ?>
                                <p>No image found.</p>
                            <?php endif; ?>

                            <h2><?php echo htmlspecialchars($row['h_ner']); ?></h2>
                            <p><?php echo "Танилцуулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
                            <p><?php echo "Тоо: " . (int)$row['h_too']; ?></p>
                            <p><?php echo "Үнэ: " . htmlspecialchars($row['h_vne']); ?></p>
                        </div>
                <?php
                    endwhile;
                else:
                    echo "<p>Уух зүйлс </p>";
                endif;
                ?>
            </div>
        </div>
    </section>
    </div>
    <script>
  function add_product(h_id, h_vne) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);  // Assuming you return JSON from PHP
            
            if (response.status === 'success') {
                showMessage(response.message); // Show success message
                document.querySelector('.badge').innerHTML = response.total_items; // Update total items
            } else {
                showMessage(response.message, true); // Show error message
            }
        }
    };

    xhr.send("h_id=" + encodeURIComponent(h_id) + "&h_vne=" + encodeURIComponent(h_vne));
}

function showMessage(message, isError = false) {
    // Create a div to display the message
    var messageDiv = document.createElement('div');
    messageDiv.className = 'response-message ' + (isError ? 'error' : 'success');
    messageDiv.innerHTML = message;

    // Append the message to the body (or any specific container)
    document.body.appendChild(messageDiv);

    // Remove the message after 3 seconds
    setTimeout(function() {
        messageDiv.remove();
    }, 3000);
}
function delete_product(h_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true); // Adjust your script path
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                alert(response.message);
                document.querySelector('.badge').innerHTML = response.total_items; // Update total item count
            } else {
                alert(response.message);
            }
        }
    };
    xhr.send("action=delete&h_id=" + encodeURIComponent(h_id));
}


    </script>
<div>
    <section id="undaa" class="dh_id_content box">
        <div class="text-content container">
            <h1>Уух зүйлс</h1>
            <div class="item-container">
                <?php
            
                $undaa_query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'undaa'";
                $undaa_run = mysqli_query($conn, $undaa_query);

             
                if ($undaa_run && mysqli_num_rows($undaa_run) > 0):
                    while ($row = mysqli_fetch_assoc($undaa_run)):
                ?>
                        <div class="item" onclick="add_product('<?php echo $row['h_id']; ?>', '<?php echo $row['h_vne']; ?>');">
                            <?php if (!empty($row['h_zurag'])): ?>
                                <?php 
                              
                                $imageData = base64_encode($row['h_zurag']); 
                                echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Undaa Image" />';
                                ?>
                            <?php else: ?>
                                <p>No image found.</p>
                            <?php endif; ?>

                            <h2><?php echo htmlspecialchars($row['h_ner']); ?></h2>
                            <p><?php echo "Танилцуулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
                            <p><?php echo "Тоо: " . (int)$row['h_too']; ?></p>
                            <p><?php echo "Үнэ: " . htmlspecialchars($row['h_vne']); ?></p>
                        </div>
                <?php
                    endwhile;
                else:
                    echo "<p>Уух зүйлс олдсонгүй</p>";
                endif;
                ?>
            </div>
        </div>
    </section>
    </div>
    <div>
    <section id="salat" class="dh_id_content box">
        <div class="text-content container">
            <h1>Салат</h1>
            <div class="item-container">
                <?php
             
                $undaa_query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'salat'";
                $undaa_run = mysqli_query($conn, $undaa_query);

             
                if ($undaa_run && mysqli_num_rows($undaa_run) > 0):
                    while ($row = mysqli_fetch_assoc($undaa_run)):
                ?>
                        <div class="item" onclick="add_product('<?php echo $row['h_id']; ?>', '<?php echo $row['h_vne']; ?>');">
                            <?php if (!empty($row['h_zurag'])): ?>
                                <?php 
                               
                                $imageData = base64_encode($row['h_zurag']); 
                                echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Undaa Image" />';
                                ?>
                            <?php else: ?>
                                <p>No image found.</p>
                            <?php endif; ?>

                            <h2><?php echo htmlspecialchars($row['h_ner']); ?></h2>
                            <p><?php echo "Танилцуулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
                            <p><?php echo "Тоо: " . (int)$row['h_too']; ?></p>
                            <p><?php echo "Үнэ: " . htmlspecialchars($row['h_vne']); ?></p>
                        </div>
                <?php
                    endwhile;
                else:
                    echo "<p>Салат олдсонгүй.</p>";
                endif;
                ?>
            </div>
        </div>
    </section>
    </div>
    <div>
    <section id="busad" class="dh_id_content box">
        <div class="text-content container">
            <h1>Бусад</h1>
            <div class="item-container">
                <?php
           
                $undaa_query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'busad'";
                $undaa_run = mysqli_query($conn, $undaa_query);

               
                if ($undaa_run && mysqli_num_rows($undaa_run) > 0):
                    while ($row = mysqli_fetch_assoc($undaa_run)):
                ?>
                        <div class="item" onclick="add_product('<?php echo $row['h_id']; ?>', '<?php echo $row['h_vne']; ?>');">
                            <?php if (!empty($row['h_zurag'])): ?>
                                <?php 
                             
                                $imageData = base64_encode($row['h_zurag']); 
                                echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Undaa Image" />';
                                ?>
                            <?php else: ?>
                                <p>No image found.</p>
                            <?php endif; ?>

                            <h2><?php echo htmlspecialchars($row['h_ner']); ?></h2>
                            <p><?php echo "Танилцуулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
                            <p><?php echo "Тоо: " . (int)$row['h_too']; ?></p>
                            <p><?php echo "Үнэ: " . htmlspecialchars($row['h_vne']); ?></p>
                        </div>
                <?php
                    endwhile;
                else:
                    echo "<p>Бусад зүйл олдсонгүй.</p>";
                endif;
                ?>
            </div>
        </div>
    </section>
</div>
</div>
<!-- Basket Button -->
<div class="basket-container">
    <button type="button" class="basket-btn" data-toggle="modal" data-target="#cartModal" name="basket">  
        <i class="fas fa-shopping-basket"></i>
      
        <span class="badge badge-light" >
            <?php echo $total_items; ?> 
        </span>
    </button>
</div>
<?php

include 'connectDB.php'; 
$undaa_query = "SELECT h.h_id, h.h_ner, h.h_vne, d.dtoo, d.dvne 
                FROM d_zah d INNER JOIN hool h 
                ON d.dh_id = h.h_id";
$undaa_run = mysqli_query($conn, $undaa_query);
$cart_items = []; 
$total = 0;
if ($undaa_run) {
    while ($row = mysqli_fetch_assoc($undaa_run)) {
        $cart_items[$row['h_id']] = $row; 
        $total += $row['h_vne'] * $row['dtoo']; 
    }
} else {
    error_log("Error fetching items: " . mysqli_error($conn));
}
 
?><div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="cartModalLabel">Таны сонгосон бүтэгдэхүүн </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <?php if (!empty($cart_items)): ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Бүтээгдэхүүн</th>
                        <th>Үнэ</th>
                        <th>Тоо ширхэг</th>
                        <th>Нийт үнэ</th>
                        <th>Үйлдэл</th>
                    </tr>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
    <td><?php echo $item['h_ner']; ?></td>
    <td><?php echo number_format($item['h_vne'], 2); ?></td>
    <td>
       
        <?php echo $item['dtoo']; ?>
       
    </td>
    <td><?php echo number_format($item['dvne'], 2); ?></td>
<td>
    <button class="btn add" onclick="updateQuantity('<?php echo $item['h_id']; ?>', -1)">-</button>
    <button class="btn add" onclick="updateQuantity('<?php echo $item['h_id']; ?>', 1)">+</button>
    <button class="btn btn-danger add" name="delete" >
        <i class="fas fa-trash"></i> 
    </button>
</td>
<?php 
if (isset($_POST['delete'])) {
    // Get the ID to delete
    $D_zahid = $_POST['D_zahid'];

    // SQL query to delete the record
    $delete_query = "DELETE FROM d_zah WHERE D_zahid = '$D_zahid'";

    // Database connection
    // Assuming you have already established a $conn connection (e.g., using MySQLi or PDO)
    $result_delete = $conn->query($delete_query);

    // Check if the query was successful
    if ($result_delete) {
        // Redirect to another page after successful deletion
        echo '<script>window.location.href = "shalgaltor.php";</script>';
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}?>

                    </tr>

                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Нийт дүн</strong></td>
                        <td colspan="2"><strong><?php echo number_format($total, 2); ?></strong></td>
                    </tr>
                </table>
            <?php else: ?>
                <p>Таны сагс хоосон байна.</p>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Сонголт өөрчлөх</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Төлбөр Төлөх</button>
            
        </div>
    </div>
</div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
</body>  
</html>

<?php

$conn->close();
?>
