<?php
    if(isset($_GET['option'])){
        switch($_GET['option']){
            case 'home':
                //Dùng include để đưa trang homed vào body
                include "view/home.php";
                break;
            case 'cart':
                //Dùng include để đưa trang cart vào body
                include "view/cart.php";
                break;
            case 'order':
                include "view/order.php";
                break; 
            case 'ordersuccess':
                include "view/ordersuccess.php";
                break;
            case 'showproducts':
                include "view/showproducts.php";
                break;
            case 'productdetail':
                include "view/productdetail.php";
                break;
            case 'signin':
                //Dùng include để đưa trang homed vào body
                include "view/signin.php";
                break;
            case 'register':
                //Dùng include để đưa trang homed vào body
                include "view/register.php";
                break;
            case 'logout':
                //Huỷ Session đã lưu
                unset($_SESSION['member']);
                //Quay trở lại trang home ban đầu
                header("location: ?option=home");
                break;
        }
    }else{
        include "view/home.php";
    }
?>