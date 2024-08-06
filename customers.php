<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fitzy Dietfood Routine">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | My Customers</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    session_start();
    include("connect.php");
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    
    $user_id = $_SESSION['userid'];
    $role = $_SESSION['role'];

    if ($role == 'trainer' || $role == "dietician") {

    $sql = "SELECT * FROM $role WHERE `User_Id` = '$user_id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $result = mysqli_fetch_array($query);
        if($role == 'trainer'){
            $table_id = $result['Trainer_Id'];
        }else{
            $table_id = $result['Dietician_Id'];
        }
    }
    include("header.php");

    ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>My Customers</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <a>Other</a>
                            <span>My Customers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="services-section spad">
        <div class="container">
            <style>
                p {
                    color: #000;
                    margin: 0 0 0 0;
                }
                .table td {
                    vertical-align: middle;
                }
            </style>
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>My Customers</b>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-bordered table-condensed table-hover">
                                    <colgroup>
                                    <?php
                                    if($role == 'trainer'){
                                        ?><col width="5%">
                                        <col width="50%">
                                        <col width="15%">
                                        <col width="20%">
                                        <col width="10%"><?php
                                    }else{
                                        ?><col width="5%">
                                        <col width="50%">
                                        <col width="15%">
                                        <col width="10%">
                                        <col width="20%"><?php
                                    }
                                    ?>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                        <?php
                                        if($role == 'trainer'){
                                            ?><th class="text-center">#</th>
                                            <th class="">Customer Name</th>
                                            <th class="text-center">Gender</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Age</th><?php
                                        }else{
                                            ?><th class="text-center">#</th>
                                            <th class="">Customer Name</th>
                                            <th class="text-center">Contact</th>
                                            <th class="text-center">Age</th>
                                            <th class="text-center">Action</th><?php
                                        }
                                        ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        if($role == 'trainer'){
                                            $customers = $conn->query("SELECT * FROM `membership` WHERE Trainer_Id = '$table_id' ");
                                        }else{
                                            $customers = $conn->query("SELECT * FROM `membership` WHERE Dietician_Id = '$table_id' ");
                                        }
                                        
                                        while($row=$customers->fetch_assoc()):
                                            $customer =  $conn->query("SELECT * FROM `customer` where Customer_Id='".$row['Customer_Id']."' order by Name asc");
                                            $row1 = $customer->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <p><b><?php echo ucwords($row1['Name']) ?></b></p>
                                            </td>
                                            <?php
                                            if($role == 'trainer'){
                                                ?><td class="text-center">
                                                    <p><b><?php echo $row1['Gender'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <p><b><?php echo $row1['Contact_No'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <p><b><?php echo $row1['Age'] ?></b></p>
                                                </td><?php
                                            }else{
                                                ?><td class="text-center">
                                                    <p><b><?php echo $row1['Contact_No'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <p><b><?php echo $row1['Age'] ?></b></p>
                                                </td>
                                                <td class="text-center">
                                                    <form action="customer_routine.php" method="post">
                                                        <input type="hidden" name="customer_id" value="<?php echo $row['Customer_Id'] ?>">
                                                        <button class="btn btn-sm btn-outline-primary" type="submit">Check-out routine</button>
                                                    </form>
                                                </td><?php
                                            }
                                            ?>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($customers->num_rows < 1): ?>
                                            <tr>
                                                <td class="text-center" colspan="5">No Customers Assigned To You</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Table Panel -->
                </div>
            </div>	
        </div>
    </section>
    
    <?php
    include("footer.php");
    } else {
        header("Location: ./index.php");
    }
    } else {
        header("Location: ./login.php");
    }
    ?>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>