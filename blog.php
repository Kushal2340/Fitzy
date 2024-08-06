<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fitzy Blog">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Blog</title>

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
    <link rel="shortcut icon" type="image/png" href="./favicon.png">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <style>
        .crop-text-2 {
            -webkit-line-clamp: 2;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }

        .crop-text-3 {
            -webkit-line-clamp: 3;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }

        .blog-pagination .active_page{
            background: #f36100;
        }

        .latest-item .li-pic img{
            max-width: 105px;
            height: 70px;
        }
        
        @media only screen and (max-width: 991px) {
            .blog-section .ssl {
                flex: 100%;
                max-width: 100%;
            }
            .blog-section .sidebar-option {
                margin-top: 25px;
            }
        }

    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

<?php
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    include("header.php");
    include("connect.php");

    $limit = 5;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Our Blog</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <!-- <a href="#">Pages</a> -->
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 p-0 blog-t">
                <?php
                    if(isset($_GET['search'])){
                        $search = $_GET['search'];
                        $sql = "SELECT * FROM `contributor_articles` WHERE `Title` LIKE '%$search%' ORDER BY Comment DESC";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if(mysqli_num_rows($query)>0) {
                                echo '<h5 class="title">Results For: '.$search.'</h5>';
                                while ($row = mysqli_fetch_row($query)) {
                                    $Article_Id = $row[0];
                                    $Contributor_Id = $row[1];
                                    $Img_Title = $row[2];
                                    $Title = $row[3];
                                    $Content1 = $row[4];
                                    $Date_Created = $row[9];
                                    $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                    $cmnt = $row[18];
                                    $query1 = mysqli_query($conn, "SELECT * FROM `contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
                                    if($query1) {
                                        $result1 = mysqli_fetch_array($query1);
                                        $Author_Name = $result1['Author_Name'];
                                    }
                            ?>
                            <div class="blog-item">
                                <div class="bi-pic">
                                    <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/blog/blog-1.jpg";} ?>" alt="">
                                </div>
                                <div class="bi-text">
                                    <h5><a href="<?php echo "blog-details.php?article=".$Article_Id;?>"><?php echo $Title;?></a></h5>
                                    <ul>
                                        <li>by <?php echo $Author_Name;?></li>
                                        <li><?php echo $Date_Created;?></li>
                                        <li>
                                        <?php echo sprintf("%02d",$cmnt);?>
                                            Comment
                                        </li>
                                    </ul>
                                    <p class="crop-text-3"><?php echo nl2br($Content1);?></p>
                                </div>
                            </div>
                            <?php
                                }
                            } else {
                                echo '<h5 class="title">No Result Found For: \''.$search.'\'</h5>';
                            }
                        }
                        
                        $sql2 = "SELECT * FROM `contributor_articles` WHERE `Title` LIKE '%$search%'";
                        $query2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($query2) > 0) {
                        
                            $total_records = mysqli_num_rows($query2);
                            $total_page = ceil($total_records / $limit);

                            echo '<div class="blog-pagination">';
                            if($page > 1){
                                echo '<a href="blog.php?page=' .($page - 1). '">Prev</a>';
                            }
                            if ($total_page >=1 && $page <= $total_page)
                            {
                                $counter = 1;
                                $link = "";
                                if ($page > ($limit/2)) {
                                    if(1 == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    echo "<a class='$active' href='blog.php?page=1'>1</a> <a>. . .</a>";
                                }
                                for ($x=$page; $x<=$total_page;$x++)
                                {
                                    if($x == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    if($counter < $limit)
                                        $link .= "<a class='$active' href='blog.php?page=" .$x."'>".$x." </a>";

                                    $counter++;
                                }
                                if ($page < $total_page - ($limit/2)) {
                                    if($total_page == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    $link .= "<a>. . .</a> <a class='$active' href='blog.php?page=" .$total_page."'>".$total_page." </a>";
                                }
                            }
                            echo $link;
                            if($total_page > $page){
                                echo '<a href="blog.php?page=' .($page + 1). '">Next</a>';
                            }
                            echo '</div>';
                        }
                    } elseif(isset($_GET['category'])) {
                        $value = $_GET['category'];
                        if($value=='yoga') {
                            $category = "Yoga";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else if($value=='running') {
                            $category = "Running";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else if($value=='weightloss') {
                            $category = "Weightloss";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else if($value=='cardio') {
                            $category = "Cardio";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else if($value=="bodybuilding") {
                            $category = "Body buiding";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else if($value=="nutrition") {
                            $category = "Nutrition";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else if($value=="other") {
                            $category = "Other";
                            echo '<h5 class="title">Category : '.$category.'</h5>';
                        }
                        else {
                            $category = "";
                        }
                        $sql = "SELECT * FROM `contributor_articles` WHERE `Category` = '$category' ORDER BY Comment DESC LIMIT {$offset}, {$limit}";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if(mysqli_num_rows($query)>0) {
                                while ($row = mysqli_fetch_row($query)) {
                                    $Article_Id = $row[0];
                                    $Contributor_Id = $row[1];
                                    $Img_Title = $row[2];
                                    $Title = $row[3];
                                    $Content1 = $row[4];
                                    $Date_Created = $row[9];
                                    $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                    $cmnt = $row[18];
                                    $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
                                    if($query1) {
                                        $result1 = mysqli_fetch_array($query1);
                                        $Author_Name = $result1['Author_Name'];
                                    }
                            ?>
                            <div class="blog-item">
                                <div class="bi-pic">
                                    <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/blog/blog-1.jpg";} ?>" alt="">
                                </div>
                                <div class="bi-text">
                                    <h5><a href="<?php echo "blog-details.php?article=".$Article_Id;?>"><?php echo $Title;?></a></h5>
                                    <ul>
                                        <li>by <?php echo $Author_Name;?></li>
                                        <li><?php echo $Date_Created;?></li>
                                        <li>
                                        <?php echo sprintf("%02d",$cmnt);?>
                                            Comment
                                        </li>
                                    </ul>
                                    <p class="crop-text-3"><?php echo nl2br($Content1);?></p>
                                </div>
                            </div>
                            <?php
                                }
                            }
                        }
                        
                        $sql2 = "SELECT * FROM `contributor_articles` WHERE `Category` = '$category'";
                        $query2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($query2) > 0) {
                        
                            $total_records = mysqli_num_rows($query2);
                            $total_page = ceil($total_records / $limit);

                            echo '<div class="blog-pagination">';
                            if($page > 1){
                                echo '<a href="blog.php?page=' .($page - 1). '">Prev</a>';
                            }
                            if ($total_page >=1 && $page <= $total_page)
                            {
                                $counter = 1;
                                $link = "";
                                if ($page > ($limit/2)) {
                                    if(1 == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    echo "<a class='$active' href='blog.php?page=1'>1</a> <a>. . .</a>";
                                }
                                for ($x=$page; $x<=$total_page;$x++)
                                {
                                    if($x == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    if($counter < $limit)
                                        $link .= "<a class='$active' href='blog.php?page=" .$x."'>".$x." </a>";

                                    $counter++;
                                }
                                if ($page < $total_page - ($limit/2)) {
                                    if($total_page == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    $link .= "<a>. . .</a> <a class='$active' href='blog.php?page=" .$total_page."'>".$total_page." </a>";
                                }
                            }
                            echo $link;
                            if($total_page > $page){
                                echo '<a href="blog.php?page=' .($page + 1). '">Next</a>';
                            }
                            echo '</div>';
                        }
                    } elseif(isset($_GET['tag'])) {
                        $tag = $_GET['tag'];
                        echo '<h5 class="title">Results for : '.$tag.'</h5>';
                        $sql = "SELECT * FROM `contributor_articles` WHERE `Keywords` LIKE '%$tag%' ORDER BY Comment DESC";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if(mysqli_num_rows($query)>0) {
                                while ($row = mysqli_fetch_row($query)) {
                                    $Article_Id = $row[0];
                                    $Contributor_Id = $row[1];
                                    $Img_Title = $row[2];
                                    $Title = $row[3];
                                    $Content1 = $row[4];
                                    $Date_Created = $row[9];
                                    $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                    $cmnt = $row[18];
                                    $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
                                    if($query1) {
                                        $result1 = mysqli_fetch_array($query1);
                                        $Author_Name = $result1['Author_Name'];
                                    }
                            ?>
                            <div class="blog-item">
                                <div class="bi-pic">
                                    <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/blog/blog-1.jpg";} ?>" alt="">
                                </div>
                                <div class="bi-text">
                                    <h5><a href="<?php echo "blog-details.php?article=".$Article_Id;?>"><?php echo $Title;?></a></h5>
                                    <ul>
                                        <li>by <?php echo $Author_Name;?></li>
                                        <li><?php echo $Date_Created;?></li>
                                        <li>
                                        <?php echo sprintf("%02d",$cmnt);?>
                                            Comment
                                        </li>
                                    </ul>
                                    <p class="crop-text-3"><?php echo nl2br($Content1);?></p>
                                </div>
                            </div>
                            <?php
                                }
                            }
                        }
                        
                        $sql2 = "SELECT * FROM `contributor_articles` WHERE `Keywords` LIKE '%$tag%'";
                        $query2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($query2) > 0) {
                        
                            $total_records = mysqli_num_rows($query2);
                            $total_page = ceil($total_records / $limit);

                            echo '<div class="blog-pagination">';
                            if($page > 1){
                                echo '<a href="blog.php?page=' .($page - 1). '">Prev</a>';
                            }
                            if ($total_page >=1 && $page <= $total_page)
                            {
                                $counter = 1;
                                $link = "";
                                if ($page > ($limit/2)) {
                                    if(1 == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    echo "<a class='$active' href='blog.php?page=1'>1</a> <a>. . .</a>";
                                }
                                for ($x=$page; $x<=$total_page;$x++)
                                {
                                    if($x == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    if($counter < $limit)
                                        $link .= "<a class='$active' href='blog.php?page=" .$x."'>".$x." </a>";

                                    $counter++;
                                }
                                if ($page < $total_page - ($limit/2)) {
                                    if($total_page == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    $link .= "<a>. . .</a> <a class='$active' href='blog.php?page=" .$total_page."'>".$total_page." </a>";
                                }
                            }
                            echo $link;
                            if($total_page > $page){
                                echo '<a href="blog.php?page=' .($page + 1). '">Next</a>';
                            }
                            echo '</div>';
                        }
                    } else {
                        $sql = "SELECT * FROM `contributor_articles` ORDER BY Comment DESC LIMIT {$offset}, {$limit}";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if(mysqli_num_rows($query)>0) {
                                while ($row = mysqli_fetch_row($query)) {
                                    $Article_Id = $row[0];
                                    $Contributor_Id = $row[1];
                                    $Img_Title = $row[2];
                                    $Title = $row[3];
                                    $Content1 = $row[4];
                                    $Date_Created = $row[9];
                                    $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                    $cmnt = $row[18];
                                    $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
                                    if($query1) {
                                        $result1 = mysqli_fetch_array($query1);
                                        $Author_Name = $result1['Author_Name'];
                                    }
                            ?>
                            <div class="blog-item">
                                <div class="bi-pic">
                                    <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/blog/blog-1.jpg";} ?>" alt="">
                                </div>
                                <div class="bi-text">
                                    <h5><a href="<?php echo "blog-details.php?article=".$Article_Id;?>"><?php echo $Title;?></a></h5>
                                    <ul>
                                        <li>by <?php echo $Author_Name;?></li>
                                        <li><?php echo $Date_Created;?></li>
                                        <li>
                                        <?php echo sprintf("%02d",$cmnt);?>
                                            Comment
                                        </li>
                                    </ul>
                                    <p class="crop-text-3"><?php echo nl2br($Content1);?></p>
                                </div>
                            </div>
                            <?php
                                }
                            }
                        }
                        
                        $sql2 = "SELECT * FROM `contributor_articles`";
                        $query2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($query2) > 0) {
                           
                            $total_records = mysqli_num_rows($query2);
                            $total_page = ceil($total_records / $limit);

                            echo '<div class="blog-pagination">';
                            if($page > 1){
                                echo '<a href="blog.php?page=' .($page - 1). '">Prev</a>';
                            }
                            if ($total_page >=1 && $page <= $total_page)
                            {
                                $counter = 1;
                                $link = "";
                                if ($page > ($limit/2)) {
                                    if(1 == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    echo "<a class='$active' href='blog.php?page=1'>1</a> <a>. . .</a>";
                                }
                                for ($x=$page; $x<=$total_page;$x++)
                                {
                                    if($x == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    if($counter < $limit)
                                        $link .= "<a class='$active' href='blog.php?page=" .$x."'>".$x." </a>";

                                    $counter++;
                                }
                                if ($page < $total_page - ($limit/2)) {
                                    if($total_page == $page){
                                        $active = "active_page";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    $link .= "<a>. . .</a> <a class='$active' href='blog.php?page=" .$total_page."'>".$total_page." </a>";
                                }
                            }
                            echo $link;
                            if($total_page > $page){
                                echo '<a href="blog.php?page=' .($page + 1). '">Next</a>';
                            }
                            echo '</div>';
                        }
                    }
                ?>

                </div>
                <div class="col-lg-4 col-md-8 p-0 ssl">
                    <div class="sidebar-option">
                        <div class="so-categories">
                            <h5 class="title">Categories</h5>
                            <ul>
                            <?php
                                $sql = "SELECT COUNT(Category), Category FROM `contributor_articles` GROUP BY Category ORDER BY COUNT(Category) DESC";
                                $query = mysqli_query($conn, $sql);
                                if ($query) {
                                    if(mysqli_num_rows($query)>0) {
                                        while ($row = mysqli_fetch_row($query)) {
                                            if($row[1] == "Yoga") {
                                                $Yoga = (int) $row[0];
                                            } elseif($row[1] == "Running") {
                                                $Running = (int) $row[0];
                                            } elseif($row[1] == "Weightloss") {
                                                $Weightloss = (int) $row[0];
                                            } elseif($row[1] == "Cardio") {
                                                $Cardio = (int) $row[0];
                                            } elseif($row[1] == "Body buiding") {
                                                $Bodybuiding = (int) $row[0];
                                            } elseif($row[1] == "Nutrition") {
                                                $Nutrition = (int) $row[0];
                                            } else {
                                                $Other = (int) $row[0];
                                            }
                                        }
                                    }
                                }
                            ?>
                                <li>
                                    <a href="blog.php?category=yoga">Yoga <span><?php if(isset($Yoga)){ echo $Yoga;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=running">Running <span><?php if(isset($Running)){ echo $Running;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=weightloss">Weightloss <span><?php if(isset($Weightloss)){ echo $Weightloss;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=cardio">Cardio <span><?php if(isset($Cardio)){ echo $Cardio;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=bodybuilding">Body buiding <span><?php if(isset($Bodybuiding)){ echo $Bodybuiding;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=nutrition">Nutrition <span><?php if(isset($Nutrition)){ echo $Nutrition;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=other">Other <span><?php if(isset($Other)){ echo $Other;} else { echo 0;}?></span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="so-latest">
                            <h5 class="title">Feature posts</h5>
                            <?php
                                $sql = "SELECT * FROM `contributor_articles` ORDER BY Comment DESC LIMIT 6";
                                $query = mysqli_query($conn, $sql);
                                if($query) {
                                    if(mysqli_num_rows($query)>0) {
                                        while ($row = mysqli_fetch_row($query)) {
                                            $Article_Id = $row[0];
                                            $Img_Title = $row[2];
                                            $Title = $row[3];
                                            $Date_Created = $row[9];
                                            $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                            $cmnt = $row[18];
                            ?>
                            <div class="latest-item">
                                <div class="li-pic">
                                    <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/letest-blog/latest-2.jpg";} ?>" alt="">
                                </div>
                                <div class="li-text">
                                    <h6><a href="<?php echo "blog-details.php?article=".$Article_Id;?>"><?php echo $Title?></a></h6>
                                    <span class="li-time"><?php echo $Date_Created?></span>
                                </div>
                            </div>
                            <?php
                                        }
                                    }
                                }
                            ?>
        
                        <div class="so-tags">
                            <h5 class="title">Popular tags</h5>
                            <div class="tags-cont" style="background-color: #141414;">                                
                        <?php
                        $Keywords = "";
                        $sql = "SELECT * FROM `contributor_articles` ORDER BY Comment DESC";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if(mysqli_num_rows($query)>0) {
                                while ($row = mysqli_fetch_row($query)) {
                                    $Keywords .= ",".$row[12];
                                }
                                $Keywords = explode(",",$Keywords);
                                if (is_array($Keywords)) {
                                    foreach ($Keywords as $key => $val) {
                                        $Keywords[$key] = trim($val);
                                    }
                                }
                                $Keywords = array_unique($Keywords); 
                                $Keywords = array_filter($Keywords);
                                if (is_array($Keywords)) {
                                    foreach ($Keywords as $key => $val) {
                                        ?><a href="<?php echo "blog.php?tag=".$val;?>"><?php echo $val;?></a><?php
                                    }
                                }
                            }
                        }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

    <?php
    include("footer.php");
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