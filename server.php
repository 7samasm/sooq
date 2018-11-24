<?php
$noNav = '';
include 'config.php';
$orderAjax = isset($_REQUEST['order']) ? $_REQUEST['order'] : null;
$reqCats   = isset($_REQUEST['part']) ? $_REQUEST['part'] : null;
$page      = $_REQUEST['page'];
if ($orderAjax && !isset($reqCats)) 
{
    $rows = getAjaxitems('itemID', '>','order by price '.$orderAjax, 0);
} 
elseif($page && !isset($reqCats))
{
    $rows = getAjaxitems('itemID', '>','order by itemID desc', 0);
}
elseif ($reqCats && $orderAjax != 'page')
{
    $rows = getAjaxitems('cat_id', '=','order by price '.$orderAjax, $reqCats);
}
elseif($page && isset($reqCats))
{
    $rows = getAjaxitems('cat_id', '=','order by itemID desc', $reqCats);
}
foreach ($rows as $item) { ?>
    <div class="col-xs-6 col-bxs-2 col-sm-4 col-md-3 col-lg-7c">
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
    </div><?php
}       