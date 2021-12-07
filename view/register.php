<?php
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $query = "select * from member where username='$username'";
        $result = $connect -> query($query);
        if(mysqli_num_rows($result)!=0){
            $alert = "Tên tài khoản đã tồn tại";
        }else{
            $password=md5($_POST['password']);
            $fullname=$_POST['fullname'];
            $mobile=$_POST['mobile'];
            $address=$_POST['address'];
            $email=$_POST['email'];
            $query = "insert member(fullname,username,password,mobile,address,email) 
                values('$fullname','$username','$password','$mobile','$address','$email')";
            $connect->query($query); 
            echo "<script>alert('Bạn đã đăng kí tài khoản thành công. Chúng tôi sẽ liên hệ sớm đến bạn');location='?option=home';</script>";   
        }
    }
?>
<h1>Đăng kí tài khoản</h1>
<section>
    <section style="color:red;"><?=isset($alert)?$alert:"" ?></section>
    <form method="post" onsubmit="if(repassword.value!=password.value){alert('Xác nhận mật khẩu không chính xác!');return false;}">
        <section>
            <label>Fullname: </label>
            <input type="text" name="fullname" required>
        </section>
        <section>
            <label>Username: </label>
            <input type="text" name="username" required>
        </section>
        <section>
            <label>Password: </label>
            <input type="password" name="password" required>
        </section>
        <section>
            <label>Re-password: </label>
            <input type="password" name="repassword" required>
        </section>
        <section>
            <label>Mobile: </label>
            <input type="tel" name="mobile" required  pattern="(0|\+84)\d{9}">
        </section>
        <section>
            <label>Address: </label>
            <textarea type="text" name="address" required></textarea>
        </section>
        <section>
            <label>Email: </label>
            <input type="email" name="email" placeholder="abc@gmail.com" >
        </section>
        <section>
            <input type="submit" value="Đăng kí">
        </section>
    </form>
</section>