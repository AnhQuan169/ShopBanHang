<?php
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $products=$connect->query("SELECT * FROM products where brand_id=$id");
        if(mysqli_num_rows($products)!=0){
            $connect->query("update brands set status=0 where id=$id");
        }else{
            $connect->query("delete from brands where id=$id");
        }
    }
?>
<?php
    // Lấy dữ liệu table brands 
    $query="select * from brands";
    $result=$connect->query($query);
?>
<h1>HÃNG SẢN XUẤT</h1>
<section style="text-align:center;">
    <a href="?option=brandadd" class="btn btn-success">Thêm hãng</a>
</section>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã hãng</th>
            <th>Tên hãng</th>
            <th>Description</th>
            <th>Trạng thái hãng</th>
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
                <td><?=$item['description']?></td>
                <td><?=$item['status']==1?'Active':'Unactive'?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=brandupdate&id=<?=$item['id']?>" onclick="">Update</a>
                    <a class="btn btn-sm btn-danger"href="?option=brands&id=<?=$item['id']?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>