<?php 
    if(isset($_POST['content'])):
        $content=$_POST['content'];
        //Lấy id của sản phẩm
        //Khi ta bấm váo sản phẩm để xem chi tiết sản phẩm, id của sản phẩm sẽ được đưa lên link web
        // ta gọi lại id đó với "$_GET['id']"
        $productid=$_GET['id'];
        //Kiểm tra tồn tại tên đăng nhập hay chưa, tức là người dùng đã đăng nhập hay chưa
        //Nếu đã đăng nhập tài khoản rồi
        //Người dùng bình luận, nội dung bình luận sẽ được lưu lại vào table comments để admin kiểm duyệt
        if(isset($_SESSION['member'])):
            
            //Tiến hành lấy bản ghi từ id của người
            //  Các thông tin của người dùng từ table Member sẽ được truy vấn ra thông qua 'memberid' 
            //  Khi người dùng đăng nhập vào tài khoả, hệ thông sẽ lưu lại session, phiên hoạt động của tài khoản
            //  với memberid
            //->Ta lấy lại memberid đó để truy vấn table Member
            $memberid=mysqli_fetch_array($connect->query("select * from member where username='".$_SESSION['member']."'"));
            //Sau khi lấy được toàn bộ thông tin của người dùng đã đăng nhập thông qua username ở session
            //Ta lấy được id của người dùng và cho nó bằng memberid của table Comment, vậy ta cho id của người dùng
            $memberid=$memberid['id'];
            //Tiến hành 'insert' bình luận của người dùng vào table Comments 
            $connect->query("insert comments(memberid,productid,date,content) values($memberid,$productid,now(),'$content')");
            //Thông báo cho người dùng là đã lưu bình luận của người dùng lại và chờ admin kiểm duyệt để được xuất hiện
            echo "<script>alert('Your comment is submited and it will be showed soon!')</script>";
        else:
            $_SESSION['content']=$content;
            echo "<script>
                    alert('You must signin to comment!');
                    location='?option=signin&productid=$productid';
                </script>";
        endif;
    endif;
?>
<?php 
    $id = $_GET['id'];
    $query = "select * from products where id=$id";
    $result = $connect->query($query);
    //Chuyển đổi thành mảng 1 chiều
    $item = mysqli_fetch_array($result);

?>

<h1>Chi tiết sản phẩm</h1>
<section class="productdetail">
    <section class="img">
        <img src="assets/images/<?=$item['image']?>">
    </section>
    <section class="name">
        <?=$item['name']?>
    </section>
    <section class="price">
        <!-- Định dạng cho giá: number_format(giá trị cần định dạng, độ chính xác của số cần định dạng, 
        kí tự dùng để định dạng cho phần nguyên và thập phân, kí tự dùng để đinh dạng cho hàng nghìn) -->
        <?=number_format($item['price'],0,',','.')?> VND
    </section>
    <section>
        <input type="button" value="Đặt mua"  onclick="location='?option=cart&action=add&id=<?=$item['id']?>';">
    </section>
</section>
<section class="description"><?=$item['description'] ?></section>
<hr>
<section>
    <h4>Comment</h4>
    <form method="post">
        <section style="padding:5px 10px;">
            <textarea name="content" style="width:100%;" row="5" class="form-control" placeholder="Write comment here..."></textarea>
        </section>
        <section>
            <input type="submit" class="btn btn-primary" value="Đăng lên">
        </section>
    </form>

    <?php 
        $comments=$connect->query("select * from member a join comments b on a.id=b.memberid join products c on b.productid=c.id where b.status and productid=".$_GET['id']);
        if(mysqli_num_rows($comments)==0):
            echo "<section style='color:green;'>No comments</section>";
        else:
            //Dùng foreach để duyệt qua tất cả comment của sản phẩm đã chọn
            foreach($comments as $comment):
    ?>
                <section style="font-weight:bold;">
                    <?=$comment['username'];?>
                </section>
                <section style="padding-left:10px;">
                    <?=$comment['content'];?>
                </section>
    <?php
            endforeach;
        endif; 
    ?>  
</section>