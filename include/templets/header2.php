<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <title><?php gettitle(); ?></title>
    <link rel="stylesheet" type="text/css" href= "<?php   echo $css ;?>normalize.css">
    <link rel="stylesheet" href="<?php   echo $css ;?>grid.css">
    <link rel="stylesheet" type="text/css" href= "<?php echo $css ;?>font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href= "<?php echo $css ;?>frontend.css">
    <meta name="viewport"  content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <nav style="direction: rtl;top:0">
        <!-- nav bar start -=====================-======-->
        <a href="http://localhost/sooq"><div id="tr"></div></a>
        <div class="top-line">

        </div>
        <div class="mid-line">
            <span><i class="fa fa-bars"></i></span>
            <div style="height: 100%; margin: 0 33px;"></div>
            <div id="wrap">
                <button id="search_submit">
                    <i class="fa fa-search"></i>
                </button>
                <form action="search.php"   method="GET">
                    <div>ابحث عما تريد</div>
                    <input id="search" name="search" type="text"  autocomplete="off">
                    <i class="fa fa-times"></i>
                </form>
            </div>
        </div>
        <div class="bottom-line">
            <div class="ul-nav" style="position: relative;">
                <ul>
                    <a style="position: absolute;color: inherit;">الاول</a>
                    <span>
                        <?php
                        foreach (getcats('asc',0,12) as $cat) { ?>
                            <li><a href="Categories.php?catid=<?php echo $cat['ID']; ?>"><?php echo $cat['Name'];?></a></li>
                        <?php } ?>
                    </span>
                    <li id="more">
                        <a style="cursor: pointer;">المذيد</a>
                        <ul>
                            <?php
                            foreach (getcats('desc',1,20) as $cat) { ?>
                                <a href="Categories.php?pageid=<?php echo $cat['ID']; ?>&pagename=<?php echo str_replace (' ','-', $cat['Name']);?>"><li><?php echo $cat['Name'];?></li></a>
                                <?php
                            } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- nav bar end  ================================-->
    </nav>
    <div class="side-nav">
        <div class="crl"><i class="fa fa-user"></i></div>
        <div class="text-center userShow">
            <?php echo isset($_SESSION['user']) ? $userSession : "<a href='login.php'>ادخل | سجل </a>"  ?>
        </div>
        <hr>
        <ul>
            <a href="http://localhost/shop"><li>الرئيسية</li></a>
            <?php if ($userSession != '') { ?>
                <a href="add.php"><li>اضافة اعلان</li></a>
                <a href="profile.php"><li>الصفحة الشخصية</li></a>
                <a href="logout.php"><li>تسجيل الخروج</li></a>
            <?php } ?>
        </ul>
    </div>
    <label id="shadow"></label>
