<?php
    $query = "select * from products where status=1";
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
                <input type="button" value="Đặt mua">
            </section>
        </section>
    <?php endforeach; ?>
</section>