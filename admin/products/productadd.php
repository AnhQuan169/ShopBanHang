<?php
    if(isset($_POST['name'])){
        // Bắt lại name
        $name = $_POST['name'];
        //Kiểm tra name của brand có trùng với brand đã tồn tại
        $query="select * from products where name='$name'";
        //Nếu đã có tên hãng sản xuất như vậy rồi
        if(mysqli_num_rows($connect->query($query))!=0){
            $alert="Đã tòn tại tên sản phẩm này!";
        }else{
            $brand_id=$_POST['brand_id'];
            $price=$_POST['price'];
            $description= $_POST['description'];
            $status=$_POST['status'];
            //---Bắt lấy image 
            //-Xử lí phần ảnh:
            $store="../assets/images/";
            $imagename=$_FILES['image']['name'];
            //-Lấy nguồn
            $imageTemp=$_FILES['image']['tmp_name'];
            //-Lấy phần đuôi tên của file ảnh
            $exp3=substr($imagename,strlen($imagename)-3);#jpg,...
            //-Lấy tên file ảnh có đuôi là 4 kí tự
            $exp4=substr($imagename,strlen($imagename)-4);#jpeg,webp,...
            if($exp3=='jpg' || $exp3=='png' || $exp3=='bmp' || $exp3=='gif' || $exp3=='JPG' || $exp3=='PNG' || $exp3=='BMP' || $exp3=='GIF' || $exp4=='JPEG'|| $exp4=='jpeg' || $exp4=='webp' || $exp4=='WEBP'){
                $imagename=time().'_'.$imagename;
                move_uploaded_file($imageTemp,$store.$imagename);
                $connect->query("insert products(name,price,image,description,status,brand_id) values('$name','$price','$imagename','$description','$status','$brand_id')");
                header("Location: ?option=products");
                unset($_SESSION["alert"]);
            }else{
                $alert="File đã chọn không phải file ảnh";
            }
            //---------------------- 
        }
    }
?>
<!-- Truy vấn vào table "brands" để lấy ra name của brands -->
<?php 
    $brands=$connect->query("select * from brands");
?>
<h1>THÊM SẢN PHẨM MỚI</h1>
<!-- Câu lệnh triển khai cho thông báo, khi mắc phải lỗi nào từ người dùng nhập vào,
Các câu lệnh bào lỗi sẽ hiện ở đây -->
<section style="color:red;font-weight:200;text-align:center;">
    <?=isset($alert)?$alert:''?>
</section>
<section class="container col-md-6">
    <form method="post" enctype="multipart/form-data">
        <section class="form-group">
            <label>Hãng sản xuất: </label>
            <br/>
            <select name="brand_id" class="form-control">
                <option hidden>---Chọn hãng sản xuất---</option>
                <?php foreach ($brands as $item):?>
                    <option value="<?=$item['id'];?>"><?=$item['name'];?></option>
                <?php endforeach; ?>
            </select>
        </section>
        <section class="form-group">
            <label>Tên sản phẩm: </label>
            <input name="name" class="form-control" type="text" required>
        </section>
        <section class="form-group">
            <label>Giá: </label>
            <input name="price" class="form-control" type="number" min="100000" required>
        </section>
        <section class="form-group">
            <label>Hình ảnh: </label>
            <input name="image" class="form-control" type="file" required>
        </section>
        <section class="form-group">
            <label>Mô tả: </label>
            <textarea name="description" id="description" required></textarea>
            <script>CKEDITOR.replace("description");</script>
        </section>
        
        <section class="form-group">
            <label>Trạng thái sản phẩm: </label>
            <br/>
            <input name="status" type="radio" value="1" checked>Active
            <input name="status" type="radio" value="0">Unactive
        </section>
        <section>
            <a href="?option=products" class="btn btn-secondary">Quay lại</a>
            <input type="submit" value="Thêm mới" class="btn btn-primary">
        </section>
    </form>
</section>