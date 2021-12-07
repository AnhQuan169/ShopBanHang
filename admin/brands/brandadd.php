<?php
    if(isset($_POST['name'])){
        // Bắt lại name
        $name = $_POST['name'];
        //Kiểm tra name của brand có trùng với brand đã tồn tại
        $query="select * from brands where name='$name'";
        //Nếu đã có tên hãng sản xuất như vậy rồi
        if(mysqli_num_rows($connect->query($query))!=0){
            $alert="Đã tòn tại tên hãng này!";
        }else{
            $description= $_POST['description'];
            $status=$_POST['status'];
            $query="insert brands(name,description,status) values('$name','$description','$status')";
            $connect->query($query);
            header('Location: ?option=brands');
        }

    }
?>
<h1>THÊM HÃNG SẢN XUẤT MỚI</h1>
<!-- Câu lệnh triển khai cho thông báo, khi mắc phải lỗi nào từ người dùng nhập vào,
Các câu lệnh bào lỗi sẽ hiện ở đây -->
<section style="color:red;font-weight:200;text-align:center;">
    <?=isset($alert)?$alert:''?>
</section>
<section class="container col-md-6">
    <form method="post">
        <section class="form-group">
            <label>Tên hãng: </label>
            <input name="name" class="form-control" type="text">
        </section>
        <section class="form-group">
            <label>Mô tả: </label>
            <input name="description" class="form-control" type="text">
        </section>
        <section class="form-group">
            <label>Trạng thái hãng: </label>
            <br/>
            <input name="status" type="radio" value="1" checked>Active
            <input name="status" type="radio" value="0">Unactive
        </section>
        <section>
            <a href="?option=brands" class="btn btn-secondary">Quay lại</a>
            <input type="submit" value="Thêm mới" class="btn btn-primary">
        </section>
    </form>
</section>