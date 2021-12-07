<?php
    //1.Khai báo 1 biến query để chứa câu truy vấn
    //2.Khai báo biến để chứa kết quả truy vấn
    //3.Chuyển đổi thành mảng
    $brand=mysqli_fetch_array($connect->query("select * from brands where id=".$_GET["id"]));
?>
<?php
    if(isset($_POST['name'])){
        // Bắt lại name
        $name = $_POST['name'];
        //Kiểm tra name của brand có trùng với brand đã tồn tại
        $query="select * from brands where name='$name' and id!=".$brand['id'];
        //Nếu đã có tên hãng sản xuất như vậy rồi
        if(mysqli_num_rows($connect->query($query))!=0){
            $alert="Đã có hãng khác tòn tại tên này!";
        }else{
            $description= $_POST['description'];
            $status=$_POST['status'];
            $query="update brands set name='$name',description='$description',status='$status' where id=".$brand['id'];
            $connect->query($query);
            header('Location: ?option=brands');
        }

    }
?>

<h1>CẬP NHẬT HÃNG SẢN XUẤT</h1>
<!-- Câu lệnh triển khai cho thông báo, khi mắc phải lỗi nào từ người dùng nhập vào,
Các câu lệnh bào lỗi sẽ hiện ở đây -->
<section style="color:red;font-weight:200;text-align:center;">
    <?=isset($alert)?$alert:''?>
</section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            <label>Tên hãng: </label>
            <input name="name" class="form-control" type="text" value="<?=$brand['name']?>">
        </section>
        <section class="form-group">
            <label>Mô tả: </label>
            <input name="description" class="form-control" type="text" value="<?=$brand['description']?>">
        </section>
        <section class="form-group">
            <label>Trạng thái hãng: </label>
            <br/>
            <input name="status" type="radio" value="1" <?=$brand['status']==1?'checked':''?>>Active
            <input name="status" type="radio" value="0" <?=$brand['status']==0?'checked':''?>>Unactive
        </section>
        <section>
            <a href="?option=brands" class="btn btn-secondary">Quay lại</a>
            <input type="submit" value="Chỉnh sửa" class="btn btn-primary">
        </section>
    </form>
</section>