<?php
session_start();
include "connectDB.php";

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
    <title>Webpage Design</title>
    <link rel="stylesheet" href="style.css">
    <style>*{
        margin: 0;
        padding: 0;
    }
    
    .main{
        width: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.5)50%,rgba(0,0,0,0.5)50%), url(1.jpg);
        background-position: center;
        background-size: cover;
        height: 100%;
    }
    
    .navbar{
        width: 1200px;
        height: 75px;
        margin: auto;
    }
    
    .icon{
        width: 200px;
        float: left;
        height: 70px;
    }
    
    .logo{
        color: #ff7200;
        font-size: 35px;
        font-family: Arial;
        padding-left: 20px;
        float: left;
        padding-top: 10px;
        margin-top: 5px
    }
    
    .menu{
        width: 400px;
        float: left;
        height: 70px;
    }
    
    ul{
        float: left;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    ul li{
        list-style: none;
        margin-left: 62px;
        margin-top: 27px;
        font-size: 14px;
    }
    
    ul li a{
        text-decoration: none;
        color: #fff;
        font-family: Arial;
        font-weight: bold;
        transition: 0.4s ease-in-out;
    }
    
    ul li a:hover{
        color: #ff7200;
    }
    
    .search{
        width: 330px;
        float: left;
        margin-left: 270px;
    }
    
    .srch{
        font-family: 'Times New Roman';
        width: 200px;
        height: 40px;
        background: transparent;
        border: 1px solid #ff7200;
        margin-top: 13px;
        color: #fff;
        border-right: none;
        font-size: 16px;
        float: left;
        padding: 10px;
        border-bottom-left-radius: 5px;
        border-top-left-radius: 5px;
    }
    
    .btn{
        width: 100px;
        height: 40px;
        background: #ff7200;
        border: 2px solid #ff7200;
        margin-top: 13px;
        color: #fff;
        font-size: 15px;
        border-bottom-right-radius: 5px;
        border-bottom-right-radius: 5px;
        transition: 0.2s ease;
        cursor: pointer;
    }
    .btn:hover{
        color: #000;
    }
    
    .btn:focus{
        outline: none;
    }
    
    .srch:focus{
        outline: none;
    }
    
    .content{
        width: 1200px;
        height: auto;
        margin: auto;
        color: #fff;
        position: relative;
    }
    
    .content .par{
        padding-left: 20px;
        padding-bottom: 25px;
        font-family: Arial;
        letter-spacing: 1.2px;
        line-height: 30px;
    }
    
    .content h1{
        font-family: 'Times New Roman';
        font-size: 50px;
        padding-left: 20px;
        margin-top: 9%;
        letter-spacing: 2px;
    }
    
    .content .cn{
        width: 160px;
        height: 40px;
        background: #ff7200;
        border: none;
        margin-bottom: 10px;
        margin-left: 20px;
        font-size: 18px;
        border-radius: 10px;
        cursor: pointer;
        transition: .4s ease;
        
    }
    
    .content .cn a{
        text-decoration: none;
        color: #000;
        transition: .3s ease;
    }
    
    .cn:hover{
        background-color: #fff;
    }
    
    .content span{
        color: #ff7200;
        font-size: 65px
    }
    
    .form{
        width: 250px;
        height: 380px;
        background: linear-gradient(to top, rgba(0,0,0,0.8)50%,rgba(0,0,0,0.8)50%);
        position: absolute;
        top: -20px;
        left: 870px;
        transform: translate(0%,-5%);
        border-radius: 10px;
        padding: 25px;
    }
    
    .form h2{
        width: 220px;
        font-family: sans-serif;
        text-align: center;
        color: #ff7200;
        font-size: 22px;
        background-color: #fff;
        border-radius: 10px;
        margin: 2px;
        padding: 8px;
    }
    
    .form input{
        width: 240px;
        height: 35px;
        background: transparent;
        border-bottom: 1px solid #ff7200;
        border-top: none;
        border-right: none;
        border-left: none;
        color: #fff;
        font-size: 15px;
        letter-spacing: 1px;
        margin-top: 30px;
        font-family: sans-serif;
    }
    
    .form input:focus{
        outline: none;
    }
    
    ::placeholder{
        color: #fff;
        font-family: Arial;
    }
    
    .btnn{
        width: 240px;
        height: 40px;
        background: #ff7200;
        border: none;
        margin-top: 30px;
        font-size: 18px;
        border-radius: 10px;
        cursor: pointer;
        color: #fff;
        transition: 0.4s ease;
    }
    .btnn:hover{
        background: #fff;
        color: #ff7200;
    }
    .btnn a{
        text-decoration: none;
        color: #000;
        font-weight: bold;
    }
    .form .link{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 17px;
        padding-top: 20px;
        text-align: center;
    }
    .form .link a{
        text-decoration: none;
        color: #ff7200;
    }
    .liw{
        padding-top: 15px;
        padding-bottom: 10px;
        text-align: center;
    }
    .icons a{
        text-decoration: none;
        color: #fff;
    }
    .icons ion-icon{
        color: #fff;
        font-size: 30px;
        padding-left: 14px;
        padding-top: 5px;
        transition: 0.3s ease;
    }
    .icons ion-icon:hover{
        color: #ff7200;
    }</style>
</head>
<body>

    <div class="main">
    <div class="navbar">
    <div class="icon">
        <h2 class="logo">PraRoz</h2>
    </div>

    <div class="menu">
        <ul>
            <li><a href="#story">Нүүр</a></li>
            <li><a href="#">ҮНДСЭН ХООЛ</a></li>
            <li><a href="#">ХАЧИР</a></li>
            <li><a href="#undaa">УНДАА</a></li>
            <li><a href="#">CONTACT</a></li>
        </ul>
    </div>

    <div class="search">
        <input class="srch" type="search" placeholder="Type To text">
        <a href="#"><button class="btn">Хайх</button></a>
    </div>
</div>

        <div class="content">
        <section id="story" class="description_content">
    <div class="text-content container">
        <h1>Coffee</h1>
        <div class="col-md-6">
            <!-- Display the fetched data -->
            <?php
            $query = "SELECT * FROM hool WHERE bai_id='$b_id' AND h_turul = 'coffe'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run && mysqli_num_rows($query_run) > 0):
                while ($row = mysqli_fetch_assoc($query_run)):  // Loop through each result
            ?>
                <div onclick="window.location.href='menu.php?id=<?php echo $row['h_id']; ?>';" style="cursor: pointer;">
                    <?php if (!empty($row['h_zurag'])): ?>
                        <?php 
                        $imageData = base64_encode($row['h_zurag']); 
                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Image" style="width: 300px; height: auto;" />';
                        ?>
                    <?php else: ?>
                        <p>No image found.</p>
                    <?php endif; ?>

                    <h2><?php echo $row['h_ner']; ?></h2>
                    <p><?php echo "Танилцуулга: " . $row['h_tailbar']; ?></p>
                    <p><?php echo "Тоо: " . $row['h_too']; ?></p>
                    <p><?php echo "Үнэ: " . $row['h_vne']; ?></p>
                </div>
                <hr> <!-- Add a horizontal rule to separate each item -->
            <?php
                endwhile;  // End of loop
            else:
                echo "<p>No coffee items found.</p>";
            endif;
            ?>
        </div>
    </div>
</section>



            <section id="undaa" class="description_content">
                <div class="text-content container">
                    <h1>Undaa</h1>
                    <div class="col-md-6">

                        <!-- Display the fetched data -->
                        <?php $query = "SELECT * FROM hool WHERE bai_id='$b_id' and h_turul = 'undaa' GROUP BY h_turul";
                        $query_run = mysqli_query($conn, $query);

                        if ($query_run && mysqli_num_rows($query_run) > 0) {
                            $row = mysqli_fetch_assoc($query_run);  // Fetch a single row as associative array
                        } else {
                            echo "No data found for this ID.";
                            exit;
                        }if (!empty($row)): ?>
                            <div onclick="window.location.href='menu.php?id=<?php echo $row['h_id']; ?>';">
                                <?php if (!empty($row['h_zurag'])): ?>
                                    <?php 
                                    $imageData = base64_encode($row['h_zurag']); 
                                    echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Image" style="width: 300px; height: auto;" />';
                                    ?>
                                <?php else: ?>
                                    <p>No image found.</p>
                                <?php endif; ?>

                                <h2><?php echo $row['h_ner']; ?></h2>
                                <p><?php echo "Танилцуулга: " . $row['h_tailbar']; ?></p>
                                <p><?php echo "Утас: " . $row['h_too']; ?></p>
                                <p><?php echo "Хаяг: " . $row['h_vne']; ?></p>
                            </div>
                        <?php else: ?>
                            <p>No data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

        </div>

        <div class="icons">
            <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="#"><ion-icon name="logo-google"></ion-icon></a>
            <a href="#"><ion-icon name="logo-skype"></ion-icon></a>
        </div>
    </div>

    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>
