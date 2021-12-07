<?php
$query = "select * from brands where status";
$result = $connect->query($query);

?>

<?php foreach($result as $item): ?>
    <section>
        <a href="?option=showproducts&brand_id=<?=$item['id']?>"><?=$item['name'] ?></a>
    </section>
<?php endforeach; ?>