    <?php
    include "connectDB.php";

    // Initialize variables for search and filter
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    $hvQuery = isset($_GET['hv']) ? $_GET['hv'] : '';


    $sql = "SELECT * FROM bai INNER JOIN hool ON bai.b_id = hool.bai_id";


    
    $conditions = [];       
    $types = ""; 
    $params = []; 
    if (!empty($searchQuery)) {
        $conditions[] = "(b_ner LIKE ? OR b_tanil LIKE ? OR b_hayag LIKE ? OR h_ner LIKE ?)";
        $types .= "ssss"; 
        $searchWildcard = "%$searchQuery%";
        $params[] = &$searchWildcard;
        $params[] = &$searchWildcard;
        $params[] = &$searchWildcard;
        $params[] = &$searchWildcard;
    }

    if ($hvQuery === 'yes') {
        $conditions[] = "b_hurgelt = 'yes'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
        
   
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

   
    $stmt->execute();
    $result = $stmt->get_result();


    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <style>
        .btnn {
            width: 240px;
            height: 40px;
            background: #ff7200;
            border: none;
            margin-top: 30px;
            margin-left: 8px;
            font-size: 18px;
            border-radius: 10px;        
            cursor: pointer;
            color: #fff;
            transition: 0.4s ease;
        }
        .btnn:hover {
            background: #fff;
            color: #ff7200;
        }
        .mmain {
        width: 100%;
        
        background-color: #b2babb ;
        background-position: center;
        /* background-size: cover;   */
        height: 100%;
    }   
        .btnn a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        .srch {
            font-family: 'Times New Roman';
            width: 250px;
            height: 40px;
            background: transparent;
            border: 3px solid #ff7200;
            margin-top: 30px;
            color: #000;
            border-right: none;
            font-size: 16px;
            float: left;
            padding: 10px;
        }
        .srch:focus {
            outline: none;
        }

        .my {
            color: #ef5a19;
            background-color: rgba(247, 246, 246, 0.616);
            padding: 20px;
            text-align: center;
            width: 550px;
            margin: 20px auto;
            margin-top: 100px;
        }



        /* .progress-container {
                width: 100%;
                height: 10px;
                background: #f3f3f3;
            }
            .progress-bar {
                height: 10px;
                background: #4caf50;
                width: 0%;
            } */
            .news-progress-txt {
                position: fixed;
                top: 20px;
                right: 20px;
                font-size: 18px;
                color: #fff;        
                background: #ff7200;
                padding: 5px 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                z-index: 999;
            }
        </style>
    </head>
    <body>
    <div class="col-12 background-section">
        <div class="row">
            <div class="col align-self-start logo ">
            Тавтай морилон уу    
            </div>
        </div>

        <div class="my"> 
            <div class="row justify-content-center align-items-center">
                <form action="" method="GET" class="search">
                    <input class="srch" type="search" name="search" placeholder="Type to search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit" class="btnn">Хайх</button>
                </form>
            </div>

            <div class="row justify-content-center align-items-center">
                <button class="btnn" onclick="location.href='?hv=yes';">Хүргэлтээр</button>
                <button class="btnn" onclick="location.href='?hv=no';">Бусад    </button>
            </div>
        </div>
    </div>

    <div class="mmain">
    <div class="container">
        <table class="table table-striped mt-3">
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="circle" onclick="window.location.href='jj.php?id=<?php echo $row['b_id']; ?>';">
                            <td>
                                <?php if (!empty($row['b_img'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['b_img']); ?>" alt="Image" style="width: 200px; height: auto;" />
                                <?php else: ?>
                                    Зураг оруулаагүй байна  
                                <?php endif; ?>
                            </td>
                            <td class="circle">
                                <strong><?php echo $row['b_ner']; ?></strong><br>
                                <p>Танилцуулга: <?php echo $row['b_tanil']; ?></p>
                                <p>Утас: <?php echo $row['b_utas']; ?></p>
                                <p>Хаяг: <?php echo $row['b_hayag']; ?></p>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">өгөгдөл олдсонгүй</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <div class="news-progress-txt uk-animation-scale-up" id="progressText">0%</div>

    </div>
    <script>
        window.onscroll = function() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
            document.getElementById("progressText").innerText = Math.round(scrolled) + "%";
        };
    </script>
    <?php
    include "foother.html";
    $conn->close();
    ?>
    </body>
    </html>
