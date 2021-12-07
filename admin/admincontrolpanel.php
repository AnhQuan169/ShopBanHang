<?php
    $chuaxuli=mysqli_num_rows($connect->query("select * from orders where status=1"));
    $dangxuli=mysqli_num_rows($connect->query("select * from orders where status=2"));
    $daxuli=mysqli_num_rows($connect->query("select * from orders where status=3"));
    $huy=mysqli_num_rows($connect->query("select * from orders where status=4"));
?>

<table class="table table-bordered tbl-admin">
    <tbody>
        <tr>
            <td style="width:15%;height:100px;">hello: <?=$_SESSION['admin']?>
                <br/>
                <a href="?option=logout">Logout</a>
            </td>
            <td align="center">ADMIN CONTROL PANEL</td>
        </tr>
        <tr>
            <td>
                <section>
                    <a href="?option=brands">Hãng sản xuất</a>
                </section>
                <section>
                    <a href="?option=products">Sản phẩm</a>
                </section>
                <section>
                    Đơn hàng
                    <section><a href="?option=order&status=1">&nbsp;&nbsp;&nbsp;>> Đơn hàng chưa xử lí [<span style="color:red;"><?=$chuaxuli?></span>]</a></section>
                    <section><a href="?option=order&status=2">&nbsp;&nbsp;&nbsp;>> Đơn hàng đang xử lí [<span style="color:red;"><?=$dangxuli?></span>]</a></section>
                    <section><a href="?option=order&status=3">&nbsp;&nbsp;&nbsp;>> Đơn hàng đã xử lí [<span style="color:red;"><?=$daxuli?></span>]</a></section>
                    <section><a href="?option=order&status=4">&nbsp;&nbsp;&nbsp;>> Đơn hàng huỷ [<span style="color:red;"><?=$huy?></span>]</a></section>
                </section>
            </td>
            <td>
                <?php 
                    if(isset($_GET['option'])){
                        switch($_GET['option']){
                            case 'logout':
                                unset($_SESSION['admin']);
                                //rút gọn link lại, bỏ đi session logout
                                header("Location: .");
                                break;
                            case 'brands':
                                include "brands/showbrands.php";
                                break;
                            case 'brandadd':
                                include "brands/brandadd.php";
                                break;
                            case 'brandupdate':
                                include "brands/brandupdate.php";
                                break;
                            case 'products':
                                include "products/showproducts.php";
                                break;
                            case 'productadd':
                                include "products/productadd.php";
                                break;
                            case 'productupdate':
                                include "products/productupdate.php";
                                break;
                            case 'order':
                                include "orders/showorders.php";
                                break;
                            case 'orderdetail':
                                include "orders/orderdetail.php";
                                break;
                        }
                    }
                ?>
            </td>
        </tr>
    </tbody>
</table>