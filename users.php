<?php 
ob_start(); 
session_start();
$pagetitle =  $_GET['user'];
include 'config.php';
//func
$search = $_GET['user'];
$serchcount = TotalCount ('member_id','items','=',$_GET['id']);
$getitems = getitems('member_id','=', $_GET['id']); 

?>
<div class="container cs">
    <h1></h1>
	<div class="row mt ads-block search-page">
		<?php
		   echo empty($getitems) ? "<div class='alert alert-danger text-center'> $serchcount Result for <strong> $search </strong></div>" : null;
		   echo $serchcount > 0 ? "<div class='text-center search-count'> $serchcount سلعة ل $search </div>" : null;
		   foreach ($getitems as $item) 
		   {
				include $temp . 'cards.php';
		   }
        if (!empty($getitems)) { ?>
            <div class="clear-fix"></div>
			<div class="pagnation">
				<div id="nums-container">
			        <?php
					$num = (int) ceil($serchcount / $pageNum);
					/* next & prevous  start********************************/ ?>
				        <a 
				        href= "<?php echo '?id=' . $_GET['id'] . '&user=' . $_GET['user'] ?>&page=<?php echo $page-1 ?>"
                        class="<?php echo $page == 1  ? 'remove-this-end' : null ?>"
				        >
				        	<span class="next-and-prev"><i class="fa fa-angle-right"></i></span>
				        </a>
				        <a 
				        href= "<?php echo '?id=' . $_GET['id'] . '&user=' . $_GET['user']?>&page=<?php echo $page+1 ?>"
                        class="<?php echo $page == $num  ? 'remove-this-end' : null ?>"
				        >
				        	<span class="next-and-prev next-page"><i class="fa fa-angle-left"></i></span>
				        </a>
					 <?php
					/* next & prevous  end ********************************/			
					for ($i=$page - $num_page_count; $i <= $page + $num_page_count; $i++) {
						if ($i > 0 && $i <= $num) { ?>
							<a  class='pn <?php echo $i == $page ? "selected-page" : null  ?>  '  href="?id=<?php echo $_GET['id'] .'&user='. $_GET['user'] . '&page=' . $i ?>">
								<?php echo $i ?>
							</a>
					     <?php
					    }
			        } ?>
				</div>
			</div>
		 <?php 
		} ?>		
	</div>
</div>
<?php 
include  $temp .'footer.php';
ob_end_flush();
?>