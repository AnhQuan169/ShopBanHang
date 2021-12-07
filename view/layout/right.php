<section>
    <form>
        <input type="hidden" name="option" value="showproducts">
        <input type="range" name="range" min="100000" max="50000000" step="500000" oninput="document.getElementById('max').innerHTML=this.value;" value="<?=isset($_GET['range'])?$_GET['range']:""?>">
        <br/>
        <span id="max"><?=isset($_GET['range'])?number_format($_GET['range'],'0',',','.')." VND":""?></span>
        <br/>
        <input type="submit" value="Search">
    </form>
</section>