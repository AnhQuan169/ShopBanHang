<?php
    $query="select * from member where username='".$_SESSION['member']."'";
    $member = mysqli_fetch_array($connect->query($query));
?>
<?php
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $note=$_POST['note'];
        $ordermethodid = $_POST['ordermethodid'];
        $memberid = $member['id'];
        $query="insert orders(ordermethodid,memberid,name,address,mobile,email,note) values($ordermethodid,$memberid,'$name','$address','$mobile','$email','$note')";  
        $connect->query($query);
        $query="select id from orders order by id desc limit 1";
        $orderid=mysqli_fetch_array($connect->query($query))['id'];
        foreach($_SESSION['cart'] as $key=>$value){
            $productid=$key;
            $quality=$value;
            $query="select price from products where id=$key";
            $price=mysqli_fetch_array($connect->query($query))['price'];
            $query="insert orderdetail values($productid,$orderid,$quality,$price)";
            $connect->query($query);
        }
        unset($_SESSION['cart']);
        header("location: ?option=ordersuccess");
    }
?>

<h1 style="font-size:2em">Đặt hàng</h1>
<h2>Thông tin người nhận</h2>
<form method="post">
    <section>
        <section>
            <label>Họ tên: </label>
            <input type="text" name="name" value="<?=$member['fullname']?>">
        </section>
        <section>
            <label>Điện thoại: </label>
            <input type="tel" name="mobile" value="<?=$member['mobile']?>">
        </section>
        <section>
            <label>Địa chỉ: </label>
            <textarea name="address" rows="3" ><?=$member['address']?></textarea>
        </section>
        <section>
            <label>Email: </label>
            <input type="email" name="email" value="<?=$member['email']?>">
        </section>
        <section>
            <label>Ghi chú: </label>
            <textarea name="note" rows="3" value=""></textarea>
        </section>
    </section>
    <h2>Chọn phương thức thanh toán</h2>
    <?php
        $query="select * from ordermethod where status";
        $result=$connect->query($query);
    ?>
    <select name="ordermethodid">
        <?php foreach ($result as $item): ?>
            <option value="<?=$item['id']?>"><?=$item['name']?></option>
        <?php endforeach; ?>
    </select>
    <section>
        <input type="submit" value="Đặt hàng" style="margin-top:10px;">
    </section>
</form>
