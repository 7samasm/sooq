<?php
ob_start();
session_start();
include 'config.php';
$catid     = $_GET['catid'];
$prevous      = $page-1  ; $next = $page + 1 ;
$getitems = getitems('cat_id','=',$catid);
if (!isset($catid)) {
	header('Location: Categories.php?catid=4&pagename=حواسيب');
	exit();
}
?>
<div class="container">
	<div class="row mt">
		<?php
		if (empty($getitems)) {
			echo "<div class='alert alert-danger text-center'>عفوا لايوجد<strong>عناصر</strong> :( </div>";
		} else { echo $_SERVER['REQUEST_URI']; ?>
		    <div class="col-xs-12 col-bxs-12 col-sm-6">
			    <div class="opt-bar">
					<span><i class="fa fa-sliders"></i> رتب حسب</span>
					<span>
						رتب
						<i class="fa  fa-sort-desc" style="float: left;"></i>
						<ul>
                            <a href="?catid=<?php echo $_GET['catid'] ?>&page=1" class = 'ctj' data-class="asc" ><li>اقل سعر</li></a>
                            <a href="?catid=<?php echo $_GET['catid'] ?>&page=1" class = 'ctj' data-class="desc"><li>اعلى سعر</li></a>
                            <a href="?catid=<?php echo $_GET['catid'] ?>&page=1" class = 'ctj' data-class="page"><li>حسب الاحدث</li></a>
                        </ul>
					</span>
				</div>
			</div>
			<div class="clear-fix"></div>
		<?php
		    } ?>
        <div id="catsAJ"></div>
		<div class="pagnation col-bxs-12 col-xs-12">
			<div id="nums-container">
				<?php
				$count = TotalCount ('cat_id','items','=',$catid);
				$num = (int) ceil($count / $pageNum);
				/* next & prevous  start********************************/
				if ($count > 0) {  ?>
			        <a
			        href= "?catid=<?php echo $catid."&page=$prevous" ?>"
					class="<?php echo $page == 1  ? 'remove-this-end' : null ?>"
			        >
			        	<span class="next-and-prev"><i class="fa fa-angle-right"></i></span>
			        </a>
			        <a
			        href= "?catid=<?php echo $catid."&page=$next" ?>"
     			    class="<?php echo $page == $num  ? 'remove-this-end' : null ?>"
			        >
			        	<span class="next-and-prev next-page"><i class="fa fa-angle-left"></i></span>
			        </a> <?php
			    }
			    /* next & prevous  end ********************************/
				for ($i=$page- $num_page_count; $i <= $page + $num_page_count; $i++) {
					if ($i > 0 && $i <= $num) {
						if (!isset($_GET['order'])) {?>
							<a  class='pn <?php echo $i == $page ? "selected-page" : null  ?>  '  href='?catid=<?php echo "$catid&page=$i" ?>'>
								<?php echo $i ?>
							</a>
						 <?php
					    }
				    }
		        } ?>
			</div>
		</div>
	</div>
</div>
<script>
    var order = document.getElementsByClassName('ctj'),
        body  = document.getElementsByTagName('body')[0],
        i;
    for ( i = 0; i < order.length ; i++) {
        (function (i) {
            "use strict";
            order[i].onclick = function () {
                document.cookie = "order = " + this.getAttribute('data-class');
                getAjax('catsAJ',"page=<?php echo $page ?>","&part=<?php echo $catid  ?>");
            }
        })(i);
    }
    body.onload = function () {
        getAjax('catsAJ',"page=<?php echo $page ?>","&part=<?php echo $catid  ?>");
    }
</script>
<?php
include  $temp .'footer.php';
ob_end_flush();
?>
