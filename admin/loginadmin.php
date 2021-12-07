<h1>ĐĂNG NHẬP TRANG QUẢN TRỊ</h1>
<section style="color:red;font-weight;"><?=isset($alert)?$alert:''?></section>
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
        <input type="submit" value="Login">
    </section>
</form>