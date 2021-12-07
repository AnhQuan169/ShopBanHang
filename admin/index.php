<?php
    session_start();
    $connect = new mysqli('localhost','root','','mobileshop');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <script src="../assets/public/ckeditor/ckeditor.js"></script>
    <title>Admin</title>
</head>
<body>
    <?php
        if(isset($_POST['username'])){
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $query= "select * from admin where username='$username' and password='$password'";
            //Truy vấn vào
            $result=$connect->query($query);
            //Check điều kiện
            //Chưa điền username, password, hoặc thông tin điền vào không tồn tại trong database
            if(mysqli_num_rows($result)==0){
                $alert="Sai tên đăng nhập hoặc mật khẩu";
            }else{
                //Đưa dữ liệu nhận được thành 1 mảng
                $result=mysqli_fetch_array($result);
                //Check dữ liệu vớI status
                if($result['status']==0){
                    $alert="Tài khoản của bạn đang bị khoá";
                }else{
                    $_SESSION['admin']=$username;
                    header("Refresh:0");
                }  
            }
        }
    ?>
    <section>
        <?php 
            if(isset($_SESSION['admin'])){
                include "admincontrolpanel.php";
            }else{
                include "loginadmin.php"; 
            }
            
        ?>
    </section>
</body>
</html>