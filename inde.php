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
    <!-- MDBootstrap CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet">

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <style>

.gradient-custom {
background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}

.card-custom {
border-bottom-left-radius: 10% 50%;
border-top-left-radius: 10% 50%;
background-color: #f8f9fa ;
}


.input-custom {
background-color: white ;
}

.white-text {
color: hsl(52, 0%, 98%);
font-weight: 100 ;
font-size: 14px;
}

.back-button {
background-color: hsl(52, 0%, 98%);
font-weight: 700;
color: black ;
margin-top: 50px ;
}

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
                    <tr class="circle" onclick="adress">
                    <tr class="circle" data-toggle="modal" data-target="#addressModal">

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
            <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addressModalLabel">Хүргэлтийн мэдээлэл</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Include your delivery form here -->
        <form style="background: blue;">
        <div class="row mt-3 mx-3" style="margin-top:25px ;">
  <div class="col-md-3">
  <div style="margin-top: 50px; margin-left: 10px; " class="text-center">
  <i id="animationDemo" data-mdb-animation="slide-right" data-mdb-toggle="animation"
    data-mdb-animation-reset="true" data-mdb-animation-start="onScroll"
    data-mdb-animation-on-scroll="repeat" class="fas fa-3x fa-shipping-fast text-white"></i>
  <h5 class="mt-3 text-white">Манайхыг сонгосонд баярлалаа.</h5>
  <p class="white-text">Та утасны дугаар, хүргэх хаягаа зөв оруулан уу!</p>
</div>

    <div class="text-center">
      <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-white btn-rounded back-button">Буцах</button>
    </div>


  </div>
  <div class="col-md-9 justify-content-center">
    <div class="card card-custom pb-4">
      <div class="card-body mt-0 mx-5">
        <div class="text-center mb-3 pb-2 mt-3">
          <h4 style="color: #495057 ;">Хүргэлтийн мэдээлэл</h4>
        </div>

        <form class="mb-0">

          <div class="row mb-4">
            <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="text" id="form9Example1" class="form-control input-custom" />
                <label class="form-label" for="form9Example1">First name</label>
              </div>
            </div>
            <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="text" id="form9Example2" class="form-control input-custom" />
                <label class="form-label" for="form9Example2">Last name</label>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="text" id="form9Example3" class="form-control input-custom" />
                <label class="form-label" for="form9Example3">City</label>
              </div>
            </div>
            <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="text" id="form9Example4" class="form-control input-custom" />
                <label class="form-label" for="form9Example4">Zip</label>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="text" id="form9Example6" class="form-control input-custom" />
                <label class="form-label" for="form9Example6">Address</label>
              </div>
            </div>
            <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="email" id="typeEmail" class="form-control input-custom" />
                <label class="form-label" for="typeEmail">Email</label>
              </div>
            </div>
          </div>

          <div class="float-end ">
            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded"
              style="background-color: #0062CC ;">Захиалга өгөх</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
        </form>
      </div>
     
    </div>
  </div>
</div>
<!-- MDBootstrap JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
// Close connection
$conn->close();
?>
</body>
</html>
