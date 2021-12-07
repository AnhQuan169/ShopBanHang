<?php
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        //So sánh dữ liệu nhập vào để đăng nhập có tồn tại bên trong database hay không
        $query = "select * from member where username='$username' and password='$password'";
        
        $result = $connect->query($query);
        //Lấy số lượng bản ghi của $result
        if(mysqli_num_rows($result)==0){
            $alert="Sai tên đăng nhập hoặc mật khẩu";
        }else{
            //Chuyển đổi về mảng 1 chiều
            $result=mysqli_fetch_array($result);
            if($result['status']==0){
                $alert="Tài khoản của bạn đang bị khoá hoặc đang trong quá trình xử lí";
            }else{
                //Tạo biến session member để lưu lại giá trị khi đăng nhập xong
                $_SESSION['member']=$username;
                // Cách 1: Dùng Javascript
                // echo "<script>location='?option=home'</script>";
                // Cách 2: Dùng backend 
                //- Nếu tồn tại sản phẩm đã tồn tại trong giỏ hàng, sẽ điều hướng sang trang "order"
                if(isset($_GET['order'])){
                    header("location: ?option=order");
                }elseif($_GET['productid']){
                    $memberid=$result['id'];
                    $productid=$_GET['productid'];
                    $content=$_SESSION['content'];
                    $connect->query("insert comments(memberid,productid,date,content) values($memberid,$productid,now(),'$content')");
                    //Thông báo cho người dùng là đã lưu bình luận của người dùng lại và chờ admin kiểm duyệt để được xuất hiện
                    echo "<script>
                            alert('Your comment is submited and it will be showed soon!');
                            location='?option=productdetail&id=$productid';
                        </script>";
                    
                }
                else{
                    header("location: ?option=home");
                }
            }
        }
    }
?>
<section>
    <h1>Đăng nhập tài khoản</h1>
    <!-- Hiển thị thông báo lỗi cho người dùng đăng nhập sai -->
    <section>
        <?=isset($alert)?$alert:""?>
    </section>
    <section>
        <form method="post">
            <section>
                <label>Username: </label>
                <input type="text" name="username" required>
            </section>
            <section>
                <label>Password: </label>
                <input type="password" name="password" required>
            </section>
            <section>
                <input type="submit" value="Đăng nhập">
            </section>
        </form>
    </section>
</section>
