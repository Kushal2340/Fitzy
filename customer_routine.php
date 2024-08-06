<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fitzy Dietfood Routine">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Dietfood Routine</title>

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

    if(isset($_POST['customer_id'])){
        $customer_id = $_POST['customer_id'];
        include("header.php");

        $name = $conn->query("SELECT Name FROM `customer` WHERE `Customer_Id` = '$customer_id'")->fetch_row()[0];
    ?>
    
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/food-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2><?php if(empty($name)){echo "Customer Routine";}else{echo $name;} ?></h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <a>Other</a>
                            <span>Customer Routine</span>
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
                                <b>Breakfast Routine</b>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-bordered table-condensed table-hover">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="70%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="">Dietfood Name</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        $routine = $conn->query("SELECT * FROM `dietfood_routine` WHERE Customer_Id='$customer_id' && Type='breakfast'");
                                        while($row=$routine->fetch_assoc()):
                                            $food =  $conn->query("SELECT * FROM `dietfood` where Dietfood_Id='".$row['Dietfood_Id']."' order by Food_Name asc");
                                            $row1 = $food->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <p><b><?php echo ucwords($row1['Food_Name']) ?></b></p>
                                            </td>
                                            <td class="text-center">
                                                <p><b><?php echo date("h:i A",DateTime::createFromFormat('H:i:s', $row['Time'])->getTimestamp()) ?></b></p>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($routine->num_rows < 1): ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No data available in Routine</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </section>

    <section class="services-section spad" style="padding-top: 0px;">
        <div class="container">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Pre-workout Routine</b>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-bordered table-condensed table-hover">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="70%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="">Dietfood Name</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        $routine = $conn->query("SELECT * FROM `dietfood_routine` WHERE Customer_Id='$customer_id' && Type='preworkout'");
                                        while($row=$routine->fetch_assoc()):
                                            $food =  $conn->query("SELECT * FROM `dietfood` where Dietfood_Id='".$row['Dietfood_Id']."' order by Food_Name asc");
                                            $row1 = $food->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <p><b><?php echo ucwords($row1['Food_Name']) ?></b></p>
                                            </td>
                                            <td class="text-center">
                                                <p><b><?php echo date("h:i A",DateTime::createFromFormat('H:i:s', $row['Time'])->getTimestamp()) ?></b></p>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($routine->num_rows < 1): ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No data available in Routine</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </section>

    <section class="services-section spad" style="padding-top: 0px;">
        <div class="container">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Post-workout Routine</b>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-bordered table-condensed table-hover">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="70%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="">Dietfood Name</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        $routine = $conn->query("SELECT * FROM `dietfood_routine` WHERE Customer_Id='$customer_id' && Type='postworkout'");
                                        while($row=$routine->fetch_assoc()):
                                            $food =  $conn->query("SELECT * FROM `dietfood` where Dietfood_Id='".$row['Dietfood_Id']."' order by Food_Name asc");
                                            $row1 = $food->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <p><b><?php echo ucwords($row1['Food_Name']) ?></b></p>
                                            </td>
                                            <td class="text-center">
                                                <p><b><?php echo date("h:i A",DateTime::createFromFormat('H:i:s', $row['Time'])->getTimestamp()) ?></b></p>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($routine->num_rows < 1): ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No data available in Routine</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </section>

    <section class="services-section spad" style="padding-top: 0px;">
        <div class="container">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Lunch Routine</b>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-bordered table-condensed table-hover">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="70%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="">Dietfood Name</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        $routine = $conn->query("SELECT * FROM `dietfood_routine` WHERE Customer_Id='$customer_id' && Type='lunch'");
                                        while($row=$routine->fetch_assoc()):
                                            $food =  $conn->query("SELECT * FROM `dietfood` where Dietfood_Id='".$row['Dietfood_Id']."' order by Food_Name asc");
                                            $row1 = $food->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <p><b><?php echo ucwords($row1['Food_Name']) ?></b></p>
                                            </td>
                                            <td class="text-center">
                                                <p><b><?php echo date("h:i A",DateTime::createFromFormat('H:i:s', $row['Time'])->getTimestamp()) ?></b></p>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($routine->num_rows < 1): ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No data available in Routine</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </section>

    <section class="services-section spad" style="padding-top: 0px;">
        <div class="container">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Dinner Routine</b>
                            </div>
                            <div class="card-body">
                                
                                <table class="table table-bordered table-condensed table-hover">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="70%">
                                        <col width="20%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="">Dietfood Name</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                        $routine = $conn->query("SELECT * FROM `dietfood_routine` WHERE Customer_Id='$customer_id' && Type='dinner'");
                                        while($row=$routine->fetch_assoc()):
                                            $food =  $conn->query("SELECT * FROM `dietfood` where Dietfood_Id='".$row['Dietfood_Id']."' order by Food_Name asc");
                                            $row1 = $food->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <p><b><?php echo ucwords($row1['Food_Name']) ?></b></p>
                                            </td>
                                            <td class="text-center">
                                                <p><b><?php echo date("h:i A",DateTime::createFromFormat('H:i:s', $row['Time'])->getTimestamp()) ?></b></p>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php if($routine->num_rows < 1): ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No data available in Routine</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </section>


    <?php
    include("footer.php");
    } else {
        header("Location: ./index.php");
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