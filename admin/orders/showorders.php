<?php
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $connect->query("delete from orderdetail where orderid=$id");
        $connect->query("delete from orders where id=$id");
        header("Location: ?option=order&status=4");
    }
?>
<?php
    $status=$_GET["status"];
    // Lấy dữ liệu table orderss 
    $query="select * from orders where status=".$_GET['status'];
    $result=$connect->query($query);
?>
<h1>DANH SÁCH ĐƠN HÀNG <?=$status==1?'CHƯA XỬ LÍ':($status==2?'ĐANG XỬ LÍ':($status==3?'ĐÃ XỬ LÍ':'HUỶ'))?></h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Ngày tạo đơn</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php $count=1; ?>
        <?php foreach ($result as $item): ?>
            <tr>
                <td><?=$count++?></td>
                <td><?=$item['id']?></td>
                <td><?=$item['orderdate']?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=orderdetail&id=<?=$item['id']?>" onclick="">Detail</a>
                    <a style="display:<?=$status!=4?'none':'unblock'?>" class="btn btn-sm btn-danger" href="?option=order&id=<?=$item['id']?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>