<?php 
    $product=mysqli_fetch_array($connect->query("select * from products where id=".$_GET['id']));
?>
<?php
    if(isset($_POST['name'])){
        // Bắt lại name
        $name = $_POST['name'];
        //Kiểm tra name của brand có trùng với brand đã tồn tại
        $query="select * from products where name='$name' and id!=".$product['id'];
        //Nếu đã có tên hãng sản xuất như vậy rồi
        if(mysqli_num_rows($connect->query($query))!=0){
            $alert="Đã có sản phẩm khác có tên này!";
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
                // Xoá ảnh cũ 
                //Dấu chấm ở đây là để nối 2 biến với nhau
                unlink($store.$product['image']);
            }   
            else{
                $alert="File đã chọn không phải file ảnh";
            }  
            if(empty($imagename)){
                $imagename=$product['image'];
            }
            $connect->query("update products set name='$name',price='$price',image='$imagename',description='$description',status='$status',brand_id='$brand_id' where id=".$product['id']);
            header("Location: ?option=products");
            //---------------------- 
        }
    }
?>
<!-- Truy vấn vào table "brands" để lấy ra name của brands -->
<?php 
    $brands=$connect->query("select * from brands");
?>
<h1>CHỈNH SỬA SẢN PHẨM</h1>
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
                    <!-- Đem id của select brand so sánh với id brand của sản phẩm mình chọn update
                        - Nếu bằng thì cho hiển thị tên hãng sản xuất của sản phẩm mình đã chọn
                        - Nếu không bằng thì trả về rỗng -->
                    <option value="<?=$item['id'];?>" <?=$item['id']==$product['brand_id']?'selected':"";?>><?=$item['name'];?></option>
                <?php endforeach; ?>
            </select>
        </section>
        <section class="form-group">
            <label>Tên sản phẩm: </label>
            <input name="name" class="form-control" type="text" required value="<?=$product['name'];?>">
        </section>
        <section class="form-group">
            <label>Giá: </label>
            <input name="price" class="form-control" type="number" min="100000" required value="<?=$product['price'];?>">
        </section>
        <section class="form-group">
            <label>Hình ảnh: </label>
            <br/>
            <image src="../assets/images/<?=$product['image'];?>" style="width:50%;">
            <input name="image" class="form-control" type="file">
        </section>
        <section class="form-group">
            <label>Mô tả: </label>
            <textarea name="description" id="description" required><?=$product['description'];?></textarea>
            <script>CKEDITOR.replace("description");</script>
        </section>
        
        <section class="form-group">
            <label>Trạng thái sản phẩm: </label>
            <br/>
            <input name="status" type="radio" value="1" <?=$product['status']==1?'checked':""; ?> checked>Active
            <input name="status" type="radio" value="0" <?=$product['status']==0?'checked':""; ?> >Unactive
        </section>
        <section>
            <a href="?option=products" class="btn btn-secondary">Quay lại</a>
            <input type="submit" value="Chỉnh sửa" class="btn btn-primary">
        </section>
    </form>
</section>