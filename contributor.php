<?php
    include("connect.php");
    session_start();
    require_once 'vendor/autoload.php';

    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $email = $_SESSION['email'];
        $role = $_SESSION['role'];
        $user_id = $_SESSION['userid'];
        if ($role == 'customer') {
            $sql = "SELECT * FROM `customer` WHERE `User_Id`='$user_id'";
            $query = mysqli_query($conn, $sql);
            if($query) {
                $row = mysqli_fetch_array($query);
                $customer_id = $row['Customer_Id'];
                $author_name = $row['Name'];
                $photo = addslashes($row['Photo']);

                $sql1 = "SELECT * FROM `membership` WHERE `Customer_Id`='$customer_id' && Status='1'";
                $query1 = mysqli_query($conn, $sql1);
                if ($query1) {
                    if(mysqli_num_rows($query1) > 0) {
                        $sql2 = "UPDATE `user_master` SET `Role`='contributor' WHERE `User_Id`='$user_id'";
                        $query2 = mysqli_query($conn, $sql2);
                        
                        $sql3 = "SELECT * FROM `contributor` WHERE User_Id='$user_id'";
                        $query3 = mysqli_query($conn, $sql3);
                        if(!mysqli_num_rows($query3) > 0) {
                            $sql4 = "INSERT INTO `contributor`(`Contributor_Id`, `Author_Name`, `About_Author`, `Photo`, `Facebook`, `Twitter`, `Github`, `Instagram`, `Youtube`, `User_Id`, `Customer_Id`) VALUES (NULL,'$author_name','','$photo','','','','','','$user_id','$customer_id')";
                            $query4 = mysqli_query($conn, $sql4);
                        } else {
                            $query4 = true;
                        }
                        if($query2 && $query4){
                            $_SESSION['role'] = 'contributor';
                            $mail = new PHPMailer(true);

                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'help.fitzy@gmail.com';
                            $mail->Password = 'Fitzy@123456789f';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;
                            $mail->setFrom('help.fitzy@gmail.com', 'Fitzy Support');
                            $mail->addAddress($email, $author_name);

                            $mail->isHTML(true);
                            $mail->Subject = 'You have successfully registered for becoming author';
                            
                            $mail->Body    = '<table width="500px" align="center" border="0" style="background-color: #FFFFFF;"><tr><th style="font-size: 28px; padding: 30px; text-align: center;">You are an Author now</th></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">Dear Customer, You have successfully registered for becoming author. Now your are author of fitzy. Your new login credentials are as below,</td></tr><tr><td style="font-size: 18px; padding: 10px;">Email Id: '.$email.'</td></tr><tr><td style="font-size: 18px; padding: 10px;">Password: (same as old password)</td></tr><tr><td style="font-size: 18px; padding: 10px;">Role: Contributor</td></tr><tr><td style="font-size: 18px; padding: 10px; text-align: right;">Thanks,<br>Fitzy</td></tr></table>';
                            
                            $mail->addReplyTo("help.fitzy@gmail.com");
                            $mail->send();
                            
                            header("Location: ./index.php");
                        }
                    } else {
                        header("Location: ./index.php");
                    }
                }
            }
        } else {
            header("Location: ./index.php");
        }
    } else {
        header("Location: ./login.php");
    }
?>