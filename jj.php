            <?php  
            session_start();  
            include "connectDB.php";  

            
            $total_items = 0;

            if (isset($_GET['id'])) {  
                $b_id = $_GET['id'];  
            } else {  
                echo "No ID found in the URL.";  
                exit;  
            }  

            
            $undaa_query = "SELECT SUM(dtoo) as total_items FROM d_zah"; 
            $undaa_run = mysqli_query($conn, $undaa_query);

            if ($undaa_run && $row = mysqli_fetch_assoc($undaa_run)) {
                $total_items = $row['total_items'];  
            } else {
                $total_items = 0; 
            }
            ?>

            <!DOCTYPE html>  
            <html lang="en">  
            <head>  
                <meta charset="UTF-8">  
                <meta name="viewport" content="width=device-width, initial-scale=1.0">  
               
                    
                    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">  
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="css/jj.css">
               
            </head>  
            <body>  

            <!-- Navigation Bar -->  
            <nav class="navbar navbar-expand-lg navbar-dark fixed-top">  
                <a  class="navbar-brand navactive" href="#">Амтат ХООЛ</a>  
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
                <section id="coffe" class="dh_id_content box1">     
                    <div class="text-content container ">
                        <h1>Хоол</h1>
                        <div class="item-container box">
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
                                        <p><?php echo "Орц, найруулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
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
            
                var messageDiv = document.createElement('div');
                messageDiv.className = 'response-message ' + (isError ? 'error' : 'success');
                messageDiv.innerHTML = message;

              
                document.body.appendChild(messageDiv);

                setTimeout(function() {
                    messageDiv.remove();
                }, 3000);
            }
            function delete_product(h_id) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "cart.php", true); 
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
                <section id="undaa" class="dh_id_content box1">
                    <div class="text-content container">
                        <h1>Уух зүйлс</h1>
                        <div class="item-container box">
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
                                        <p><?php echo "Орц, найруулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
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
                <section id="salat" class="dh_id_content box1">
                    <div class="text-content container">
                        <h1>Салат</h1>
                        <div class="item-container box">
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
                                        <p><?php echo "Орц, найруулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
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
                <section id="busad" class="dh_id_content box1">
                    <div class="text-content container">
                        <h1>Бусад</h1>
                        <div class="item-container box">
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
                                        <p><?php echo "Орц, найруулга: " . htmlspecialchars($row['h_tailbar']); ?></p>
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
               
                $D_zahid = $_POST['D_zahid'];

              
                $delete_query = "DELETE FROM d_zah WHERE D_zahid = '$D_zahid'";

        
                $result_delete = $conn->query($delete_query);

        
                if ($result_delete) {
                    
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
                        <!-- <button type="button" class="btn btn-secondary" id="nextButton"  data-dismiss="modal">next</button> -->
                        <!-- Next button without data-dismiss -->
        <button type="button" class="btn btn-secondary" id="nextButton">Дараах   </button>

                    </div>
                </div>
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

            <div class="container1 ">

<footer class="bg-dark text-center text-white">
<div class="container1     p-4 pb-0">
  <section class="mb-4">
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fab fa-facebook-f"></i
    ></a>
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fab fa-twitter"></i
    ></a>

    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fab fa-google"></i
    ></a>

    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fab fa-instagram"></i
    ></a>

    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fab fa-linkedin-in"></i
    ></a>

    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fab fa-github"></i
    ></a>
  </section>

</div>

<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
   2024 Дадлагын ажил:
  <a class="text-white" href="https://msue.edu.mn/">МОНГОЛ УЛСЫН БОЛОВСРОЛЫН ИХ СУРГУУЛЬ</a>
</div>

</footer>

</div>   
               

         
            <script>
            $('#nextButton').on('click', function() {
    
        $('#cartModal').modal('hide');
        setTimeout(function() {
            $('#addressModal').modal('show');
        }, 300); // Adjust the delay if needed
    });




                </script>
           
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>  
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
            </body>  
            </html>

            <?php
// include "foother.html";
            $conn->close();
            ?>
