<?php
    $option='home';

    $query = "select * from products where status=1";
    //Tìm kiếm các sản phẩm theo hãng sản xuất
    if(isset($_GET['brand_id'])){
        //Nối chuỗi $query vào câu lệnh tiếp theo
        $query.= " and brand_id=".$_GET['brand_id'];
        $option='showproducts&brand_id='.$_GET['brand_id'];
    }
    //Tìm kiếm các sản phẩm khi nhập tên sản phẩm vào ô tìm kiếm
    elseif(isset($_GET['keyword'])){
        $query.= " and name like'%".$_GET['keyword']."%'";
        $option='showproducts&keyword='.$_GET['keyword'];
    }
    //Tìm kiếm sản phẩm khi chọn giá cả
    elseif(isset($_GET['range'])){
        $query.= " and price<=".$_GET['range'];
        $option='showproducts&range='.$_GET['range'];
    }
    //$page: xem các sản phẩm ở trang số bao nhiêu
    $page=1;
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    //Số lượng sản phẩm trong 1 trang
    $productsperpage=3;
    //Lấy sản phẩm bắt đầu từ chỉ số sản phẩm thứ mấy trong bảng 
    $from=($page-1)*$productsperpage;
    $totalProducts = $connect->query($query);
    //Tính ra tổng số trang dựa trên tổng số sản phẩm/Số sản phẩm trong 1 trang
    // Hàm Ceil(): Làm tròn trên cho số trang tính ra 
    $totalPages=ceil(mysqli_num_rows($totalProducts)/$productsperpage);
    
    //Cho phép lấy kết quả trong 1 khoảng
    // Lấy các sản phẩm ở trang hiện thời
    //"limit "lấy sản phẩm từ vị trí sản phẩm thứ mấy","Số lượng sản phẩm lấy ra""
    $query.=" limit $from,$productsperpage";

    $result = $connect->query($query);
?>

<section class="products">
    <?php foreach($result as $item): ?>
        <section class="product">
            <section class="img">
                <a href="?option=productdetail&id=<?=$item['id']?>"><img src="assets/images/<?=$item['image']?>"></a>
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
                <input type="button" value="Đặt mua" onclick="location='?option=cart&action=add&id=<?=$item['id']?>';">
            </section>
        </section>
    <?php endforeach; ?>
</section>
<section class="pages">
    <?php for($i=1;$i<=$totalPages;$i++):?>
        <a class="<?=(empty($_GET["page"])&&$i==1)||(isset($_GET["page"])&&$_GET["page"]==$i)?'highlight':""?>"  href="?option=<?=$option?>&page=<?=$i?>"><?=$i?></a>
    <?php endfor;?>
</section>