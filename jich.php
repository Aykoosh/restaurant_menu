<?php  
session_start();  
include "connectDB.php";  

// Check if 'id' is passed in the URL and fetch its value
if (isset($_GET['id'])) {  
    $b_id = $_GET['id'];  
} else {  
    echo "No ID found in the URL.";  
    exit;  
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
    <!-- Styling for the Navbar and Content -->
    <style>  
  .content {
    margin-top: 10px;
    z-index: 20;
    padding: 50px;
    background-image: url('image/img1.jpg'); 
    background-size: cover; 
    background-position: center; 
    /* background-repeat: no-repeat; */
}

    .box {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            margin-top: 20px; 
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: inline-block;
        }
   

     
      
.item-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Spacing between items */
    }
    /* Individual items styling */
    .item {
        flex: 1 1 calc(33.33% - 20px); /* 3 items per row, with space between */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .item img {
        max-width: 200px;
        height: 400px;
        margin-bottom: 15px;
    }
    .item:hover {
        transform: scale(1.05); /* Slight zoom on hover */
    }
    h2 {
        font-size: 18px;
        margin-bottom: 10px;
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
        .category-title {
            margin-top: 20px;
            color: #333;
        }
        .item {
            cursor: pointer;
            margin-bottom: 30px;
        }
        .item img {
            width: 300px;
            height: auto;
        }

/* Basket Container */
.basket-container {
    position: fixed;
    bottom: 20px; /* 20px from the bottom */
    right: 20px;  /* 20px from the right */
    z-index: 1000; /* Ensure it stays above other elements */
}

/* Basket Button Style */
.basket-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #8B0000; /* Deep red for the button */
    color: white;
    border: none;
    border-radius: 50%;
    padding: 15px;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow for effect */
    transition: background-color 0.3s ease;
    width: 60px;
    height: 60px;
}

/* Basket Icon Style */
.basket-btn i {
    font-size: 24px;
}

/* Hover Effect */
.basket-btn:hover {
    background-color: #A52A2A; /* Lighter red on hover */
}


    </style>  
</head>  
<body>  

<!-- Navigation Bar -->  
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">  
    <a class="navbar-brand" href="#">Brand</a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">  
        <span class="navbar-toggler-icon"></span>  
    </button>  
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">  
        <ul class="navbar-nav">  
            <li class="nav-item active">  
                <a class="nav-link" href="#coffe">Home <span class="sr-only">(current)</span></a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="#undaa">Features</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link" href="#">Pricing</a>  
            </li>  
            <li class="nav-item">  
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>  
            </li>  
        </ul>  
    </div>  
</nav> 
 
<!-- Main Content Section -->  
<div class="content" >  
<section id="coffe" class="description_content box">
    <div class="text-content container">
        <h1>coffe</h1>
        <div class="item-container">
            <?php
            // Query to fetch items for "undaa" category
            $undaa_query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'coffe'";
            $undaa_run = mysqli_query($conn, $undaa_query);

            // Loop through items for the undaa category
            if ($undaa_run && mysqli_num_rows($undaa_run) > 0):
                while ($row = mysqli_fetch_assoc($undaa_run)):
            ?>
                    <div class="item" onclick="window.location.href='sags.php?id=<?php echo $row['h_id']; ?>';">
                        <?php if (!empty($row['h_zurag'])): ?>
                            <?php 
                            // Encode the image data to base64 and display it
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
                echo "<p>No undaa items found.</p>";
            endif;
            ?>
        </div>
    </div>
</section>

    <section id="undaa" class="description_content box">
    <div class="text-content container">
        <h1>Undaa</h1>
        <div class="item-container">
            <?php
            // Query to fetch items for "undaa" category
            $undaa_query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'undaa'";
            $undaa_run = mysqli_query($conn, $undaa_query);

            // Loop through items for the undaa category
            if ($undaa_run && mysqli_num_rows($undaa_run) > 0):
                while ($row = mysqli_fetch_assoc($undaa_run)):
            ?>
                    <div class="item" onclick="window.location.href='menu.php?id=<?php echo $row['h_id']; ?>';">
                        <?php if (!empty($row['h_zurag'])): ?>
                            <?php 
                            // Encode the image data to base64 and display it
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
                echo "<p>No undaa items found.</p>";
            endif;
            ?>
        </div>
    </div>
</section>
<div class="basket-container">
        <button class="basket-btn">
            <i class="fas fa-shopping-basket"></i>
        </button>
    </div>
</div>  

<!-- Bootstrap JS and dependencies -->  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
</body>  
</html>
