<div class="col-xs-6 col-bxs-4 col-sm-3 col-md-2 col-lg-7c">
    <a href="<?php echo 'items.php?item=' . $item['itemID'] ?>">
        <div class="card-elm">
            <img src="<?php echo $item['img'] != '' ? $item['img'] : 'img/flat.png' ?>" width="100%" height="110">
            <div class="hpd">
                <p><?php echo $item['name'] ?></p>
            </div>
            <div class="ppd">
                <p class="pp"><span class="price-show-primry"><?php echo $item['price'] ?></span><span> جنيه</span></p>
            </div>
        </div>
    </a>
</div>