<?php
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $products=$connect->query("SELECT * FROM orderdetail where productid=$id");
        if(mysqli_num_rows($products)!=0){
            $connect->query("update products set status=0 where id=$id");
        }else{
            $connect->query("delete from products where id=$id");
            unlink("../assets/images/".$_GET["image"]);
        }
    }
?>
<?php
    // Lấy dữ liệu table brands 
    $query="select * from products";
    $result=$connect->query($query);
?>
<h1>DANH SÁCH SẢN PHẨM</h1>
<section style="text-align:center;">
    <a href="?option=productadd" class="btn btn-success">Thêm sản phẩm</a>
</section>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php $count=1; ?>
        <?php foreach ($result as $item): ?>
            <tr>
                <td><?=$count++?></td>
                <td><?=$item['id']?></td>
                <td><?=$item['name']?></td>
                <td><img style="width:100px;" src="../assets/images/<?=$item['image']?>"></td>
                <td><?=number_format($item['price'],'0',',','.')?> VND</td>
                <td><?=$item['status']==1?'Active':'Unactive'?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=productupdate&id=<?=$item['id']?>" onclick="">Update</a>
                    <a class="btn btn-sm btn-danger"href="?option=products&id=<?=$item['id']?>&image=<?=$item['image']?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>