<?php
    if(isset($_GET['action'])){
        $condition=" where orderid=".$_GET['orderid']." and productid=".$_GET['productid'];
        if($_GET['type']=="asc"){
            $query="update orderdetail set quality=quality+1".$condition;
        }else{
            $query="update orderdetail set quality=quality-1".$condition;
        }
        //Truy vấn
        $connect->query($query);
        header("Location: ?option=orderdetail&id=".$_GET[id]);
    }
    //bắt lại thông tin đã update
    if(isset($_POST['status'])){
        $connect->query("update orders set status=".$_POST['status']." where id=".$_GET['id']);
        //Refresh lại web để khởi động ngay các sô liệu
        header("Refresh:0");
    }
?>
<?php
    // Truy vẫn các giá tri cần thiết cho 1 đơn hàng:
    // 1. Truy vấn người dùng: dựa vào id của table member và memberid của table orders
    // 2. Truy vẫn chi tiết đơn hàng: dựa vào orderid của table orderdetail và id của table orders
    // 3. Truy vấn sản phẩm: dựa vào id của table products và productid của table orderdetail
    // --> Tất cả các truy vấn trên dựa vào id của table orders
    $query="select a.fullname,a.mobile as 'mobilemember',a.address as 'addressmember',a.email as 'emailmember',b.*,c.name as 'nameordermethod' from member a join orders b on a.id=b.memberid join ordermethod c on b.ordermethodid=c.id where b.id=".$_GET['id'];
    $order=mysqli_fetch_array($connect->query($query));


?>
<h1>CHI TIẾT ĐƠN HÀNG<br/>(Mã đơn hàng: <?=$order['id']?>)</h1>
<h2>NGÀY TẠO ĐƠN</h2>
<p>
    <?=$order['orderdate']?>
</p>
<h2>THÔNG TIN NGƯỜI ĐẶT HÀNG</h2>
<table class="table">
    <tbody>
        <tr>
            <td>Họ tên:</td>
            <td><?=$order['fullname']?></td>
        </tr>
        <tr>
            <td>Điện thoại:</td>
            <td><?=$order['mobilemember']?></td>
        </tr>
        <tr>
            <td>Địa chỉ:</td>
            <td><?=$order['addressmember']?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?=$order['emailmember']?></td>
        </tr>
        <tr>
            <td>Ghi chú:</td>
            <td><?=$order['note']?></td>
        </tr>
    </tbody>
</table>
<h2>THÔNG TIN NGƯỜI NHẬN HÀNG</h2>
<table class="table">
    <tbody>
        <tr>
            <td>Họ tên:</td>
            <td><?=$order['fullname']?></td>
        </tr>
        <tr>
            <td>Điện thoại:</td>
            <td><?=$order['mobile']?></td>
        </tr>
        <tr>
            <td>Địa chỉ:</td>
            <td><?=$order['address']?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?=$order['email']?></td>
        </tr>
    </tbody>
</table>
<h2>PHƯƠNG THỨC THANH TOÁN</h2>
<p>
    <?=$order['nameordermethod'];?>
</p>
<?php 
    $query="select b.*,c.name,c.image from orders a join orderdetail b on a.id=b.orderid join products c on b.productid=c.id where a.id=".$order['id'];
    $orderdetails=$connect->query($query);
?>
<form method="post">
    <h2>CÁC SẢN PHẨM ĐẶT MUA</h2>
    <?php
        $count=1;
    ?>
    <table class="table table-bordered">
        <thread>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá bán (VND)</th>
                <th>Số lượng</th>
            </tr>
        </thread>
        <tbody>
            <?php foreach($orderdetails as $item): ?>
                <tr>
                    <td><?=$count++?></td>
                    <td><?=$item['name']?></td>
                    <td><img style="width:70px;" src="../assets/images/<?=$item['image']?>"></td>
                    <td><?=number_format($item['price'],0,',','.')?></td>
                    <td>
                        <input <?=$item['quality']==0?'disabled':''?> type="button" value="-" onclick="location='?option=orderdetail&id=<?=$_GET['id']?>&action=update&type=desc&orderid=<?=$item['orderid']?>&productid=<?=$item['productid']?>';">
                        <?=$item['quality']?>
                        <input type="button" value="+" onclick="location='?option=orderdetail&id=<?=$_GET['id']?>&action=update&type=asc&orderid=<?=$item['orderid']?>&productid=<?=$item['productid']?>';">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>TRẠNG THÁI ĐƠN HÀNG</h2>
    <p style="display:<?=$order['status']==2||$order['status']==3?'none':'unblock'?>"><input type="radio" name="status" value="1" <?=$order['status']==1?'checked':''?>>Chưa xử lí</p>
    <p style="display:<?=$order['status']==3||$order['status']==4?'none':'unblock'?>"><input type="radio" name="status" value="2" <?=$order['status']==2?'checked':''?>>Đang xử lí</p>
    <p style="display:<?=$order['status']==4?'none':'unblock'?>"><input type="radio" name="status" value="3" <?=$order['status']==3?'checked':''?>>Đã xử lí</p>
    <p style="display:<?=$order['status']==3?'none':'unblock'?>"><input type="radio" name="status" value="4" <?=$order['status']==4?'checked':''?>>Huỷ</p>
    <section>
        <a href="?option=order&status=1" class="btn btn-outline-secondary">Quay lại</a>
        <input <?=$order['status']==3?'disabled':''?> type="submit" value="Update đơn hàng" class="btn  btn-primary">
    </section>
</form>