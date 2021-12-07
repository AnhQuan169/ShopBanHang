<a href="?option=home">Home</a>
<a href="?option=news">News</a>
<a href="?option=feetback">Feetback</a>
<a href="?option=cart">Cart</a>
<?php if(empty($_SESSION['member'])): ?>
    <a href="?option=signin">Sign in</a>
    <a href="?option=register">Register</a>
<?php else: ?>
<section>
    <span style="color:green;">Hello: <?=$_SESSION['member'] ?></span>
    <a href="?option=logout">Đăng xuất</a>
</section>
<?php endif; ?>