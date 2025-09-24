<?php
include "connectDB.php";

// Initialize variables
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$hvQuery = isset($_GET['hv']) ? $_GET['hv'] : '';

// Base SQL query
$sql = "SELECT * FROM bai";

// If either a search term or 'hv' filter is applied, modify the query
$conditions = [];

if (!empty($searchQuery)) {
    $conditions[] = "(b_ner LIKE '%$searchQuery%' 
                     OR b_tanil LIKE '%$searchQuery%' 
                     OR b_hayag LIKE '%$searchQuery%' 
                     OR h_ner LIKE '%$searchQuery%')";
}

if ($hvQuery === 'yes') {
    $conditions[] = "b_hurgelt = 'yes'";
}

// Combine the conditions into the SQL query
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Fetch data from the database
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <style>
  .btnn{
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
    .btnn:hover{
        background: #fff;
        color: #ff7200;
    }
    .btnn a{
        text-decoration: none;
        color: #000;
        font-weight: bold;
    }

/* .search{
    width: 330px;
    float: left;
    margin-left: 270px;
} */

.srch{
    font-family: 'Times New Roman';
    width: 250px;
    height: 40px;
    background: transparent;
    border: 3px solid #ff7200;
    margin-top: 30px;
    color:  #000;
    border-right: none;
    font-size: 16px;
    float: left;
    padding: 10px;
    /* border-bottom-left-radius: 5px;
    border-top-left-radius: 5px; */
}
.srch:focus{
    outline: none;
}

.my {
    color: #ef5a19 ; 
    background-color: rgba(247, 246, 246, 0.616);
    padding: 20px; /* Add some padding */
    text-align: center; /* Center align text */
    width: 550px; /* Set width */
  
    margin: 20px auto; /* Add margin at the top (20px) and auto for horizontal centering */
    margin-top: 100px;
}

  </style>
</head>
<body>
<div class="col-12 background-section" >
<div class="row">
    
    <div class="col align-self-start logo">
    
    One of three columns
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
        <button class="btnn" onclick="location.href='?hv=no';">Очиж авах</button>
    </div>
</div>
</div>
<div class="main">
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
                                No image found.
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
                    <td colspan="4" class="text-center">No results found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
            </div>

<?php
// Close connection
$conn->close();
?>
</body>
</html>
