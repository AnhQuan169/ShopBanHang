<?php
    if(empty($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    if(isset($_GET['action'])){
        $id=isset($_GET['id'])?$_GET['id']:'';
        switch($_GET['action']){
            case 'add':
                //YN: Nếu tồn tại $id bên trong mảng khoá SESSION của "cart"
                if(array_key_exists($id, array_keys($_SESSION['cart']))){
                    $_SESSION['cart'][$id]++;
                }else{
                    $_SESSION['cart'][$id]=1;
                }
                header("Location: ?option=cart");
                break; 
            case 'delete':
                unset($_SESSION['cart'][$id]);
                break; 
            case 'deleteall':
                unset($_SESSION['cart']);
                break;
            case 'update':
                if($_GET['type']=='asc'){
                    $_SESSION['cart'][$id]++;
                }else{
                    if($_SESSION['cart'][$id]>1)
                        $_SESSION['cart'][$id]--;
                }
                header("location: ?option=cart");
                break;
            case 'order':
                //Nếu đã đăng nhập trước rồi, khi nhấn nút "Đặt hàng" tiến hành đặt hàng
                if(isset($_SESSION['member'])){
                    header("location: ?option=order");
                }else{
                    //Nếu chưa đăng nhập vào tài khoản, điều hướng sang trang "Đăng nhập" để người dùng login
                    //Chỉ khi login thành công thì mới cho phép đặt hàng
                    //Sau khi đăng nhập xong sẽ điều hướng sang trang Giỏ hàng
                    header("location: ?option=signin&order=1");
                }
                break;
        }
        // session_unset(); 
        // session_destroy();
    }
?>
<section class="cart">
    <?php
        if(!empty($_SESSION['cart'])):
            // $ids="0";
            // foreach(array_keys($_SESSION['cart']) as $key)
            // $ids.=",".$key;
            //- Lấy các phần tử từ session carts xuống 
            // implode(",",pieces):implode(dấu phân cách các phần tử của mảng,mảng sử dụng)
            $ids=implode(",", array_keys($_SESSION['cart']));
            $query="select * from products where id in($ids)";
            $result=$connect->query($query);
    ?>
    <h1>Giỏ hàng</h1>
    <table border="1" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <td>Image</td>
                <td>Name product</td>
                <td>Quality</td>
                <td>Price (VND)</td>
                <td>Total (VND)</td>
                <Td>Thao tác</Td>
            </tr>
        </thead>
        <tbody>
    <?php
    $total=0;
        foreach($result as $item):
    ?>
            <tr>
                <td width="20%"><img style="width:100%;padding:10px;" src="./assets/images/<?=$item['image']?>"></td>
                <td><?=$item['name']?></td>
                <td>
                    <input type="button" value="-" onclick="location='?option=cart&action=update&type=desc&id=<?=$item['id']?>';">
                    <?=$_SESSION['cart'][$item['id']]?>
                    <input type="button" value="+" onclick="location='?option=cart&action=update&type=asc&id=<?=$item['id']?>';">
                </td>
                <td><?=number_format($item['price'],0,",",".")?></td>
                <td><?=number_format($subTotal=$_SESSION['cart'][$item['id']]*$item['price'],0,",",".")?></td>
                <td>
                    <input type="button" value="Delete" onclick="location='?option=cart&action=delete&id=<?=$item['id']?>';">
                </td>
            </tr>
            <?php $total+=$subTotal; ?>
    <?php
        endforeach;
    ?>
        <tr>
            <td colspan="6" class="totalPrice">
                <section>Tổng tiền (VND): <?=number_format($total,0,",",".");?></section>
                <section>
                    <input type="button" value="Delete cart" onclick="if(confirm('Are you sure?')) location='?option=cart&action=deleteall';">
                    <input type="button" value="Đặt hàng" onclick="location='?option=cart&action=order';">
                </section>

            </td>
        </tr>
        </tbody>
    </table>
    <?php
        else:
    ?>
    <section style="text-align:center;color:blue;font-weight:bold;font-size:25px;">
        Giỏ hàng trống
    </section>
    <?php
        endif;
    ?>
</section>