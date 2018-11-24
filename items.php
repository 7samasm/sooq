<?php
ob_start();
session_start();
$pagetitle = 'Home Page';
include 'config.php';
//page counter
$stmtip = $con->prepare("UPDATE `items` SET `ip` = `ip` + 1  WHERE `items`.`itemID` = ?");
$stmtip->execute(array($_GET['item']));
//func
$getID = $_GET['item'];
$stmt = $con->prepare(" select
                                items.*,
                                    cats.Name as category_name,
                                    users.username
                                from
                                    items
                                inner join
                                    cats
                                on
                                    cats.ID = items.cat_id
                                inner join
                                    users
                                on
                                    users.userID = items.member_id
                                where 
                                    itemID = $getID");
$stmt->execute();
$rows = $stmt->fetchall();
?>

<div class="container">
    <div class="items mt">
        <?php foreach ($rows as $item) { ?>
            <div class="item-card">
                <img src="<?php echo $item['img'] != '' ? $item['img'] : 'img/flat.png' ?>" height="250" width="100%">
                <h3 class="text-center"><?php echo $item['name'] ?></h3>
                <div style="width: 90%; margin: 0 auto;">
                    <div class="desc"><?php echo $item['description'] == '' ? 'عذرا لا يوجد وصف لهذا العنصر !' : $item['description']; ?></div>
                    <hr>
                    <div class="dl">
                        <div class="row">
                            <div class="col-xs-6 col-bxs-6 col-md-4">
                                <div class="icon"><i class="fa fa-user"></i></div>
                                <a href="users.php?id=<?php echo $item['member_id'] . '&user=' . $item['username'] ?>">
                                    <span> <?php echo $item['username'] ?></span>
                                </a>
                            </div>		          		
                            <div class="col-xs-6 col-bxs-6 col-md-4"> 
                                <div class="icon"><i class="fa fa-phone"></i></div><span> 0924950316</span>
                            </div>
                            <div class="col-xs-6 col-bxs-6 col-md-4">
                                <div class="icon"><i class="fa fa-calendar-check-o"></i></div><span> <?php echo $item['date'] ?></span>
                            </div>
                            <div class="col-xs-6 col-bxs-6 col-md-4">
                                <div class="icon"><i class="fa fa-map-marker"></i></div><span> الخرطوم</span>
                            </div>	
                            <div class="col-xs-6 col-bxs-6 col-md-4">
                                <div class="icon">
                                    <i class="fa fa-folder"></i>
                                </div>
                                <a href="Categories.php?<?php echo 'pageid=' . $item['cat_id'] . '&pagename=' . str_replace(' ', '-', $item['category_name']); ?>">
                                    <span> <?php echo $item['category_name'] ?></span>
                                </a>
                            </div>
                            <div class="col-xs-6 col-bxs-6 col-md-4">
                                <div class="icon"><i class="fa fa-eye"></i></div>
                                <span> <?php echo $item['ip'] ?></span>
                            </div>
                        </div> 
                        <div class="clear-fix"></div>                		         
                    </div>
                    <hr style="margin-bottom: 7px">
                    <div class="row">
                            <div style="margin: 0 auto;width: 132px">
                            <span class="share-icons"></span>
                            <span class="share-icons"></span>
                            <span class="share-icons"></span>
                            <span class="share-icons"></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
include $temp . 'footer.php';
ob_end_flush();
