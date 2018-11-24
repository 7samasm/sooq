<?php
ob_start();
session_start();
$pagetitle = 'الصفحة الرئيسية';
include 'config.php';
//func
echo $_SERVER['REQUEST_URI'];
$getitems = getitems('itemID', '>', 0);
$getitems_one = getitemsRow('itemID', '>', 0);
$getitems_two = getitemsRow('itemID', '>', 0,'order by ip desc');
if (!empty($getitems)) { ?>
    <div class="container">
        <!--
            **********************************
            ********************************
            first tab begin =============================================================================
            ********************************
            ********************************
        -->
        <div class="row mt">
            <div class="col-bxs-12 col-xs-12 tap-col">
                <div class="mrt-tap tap-one">
                    <!-- ============================== first window ================== -->
                    <span data-class='fashon-week' class="selected-tap">اسبوع الاناقة</span>
                    <span data-class='tech'>الكترونيات</span>
                    <div class="tap-cont tc-one">
                        <div class="fashon-week col-bxs-12">
                            <div class="row">
                                <div class="col-md-6 main-tap-img">
                                    <div class="alpum">
                                        <img src="layout/img/wi-1.jpg" width="100%">
                                    </div>
                                    <p>اجعل الذهب خيارك الاول</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/wi-05.jpg" width="100%">
                                        <p class="text-center">لك سيدتي</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/wi-02.jpg" width="100%">
                                        <p class="text-center">اختر عطورك المفضلة باقل الاسعار </p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/wi-04.jpg" width="100%">
                                        <p class="text-center">استكشف الخيارات و اختر هاتفك المفضل </p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/wi-03.jpg" width="100%">
                                        <p class="text-center">اكتشفي تشكيلاتنا الرائعة من الخقائب النسائية </p>
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================== first window end================== -->
                        <!-- ============================== second window start================== -->
                        <div class="tech col-bxs-12">
                            <div class="row">
                                <div class="col-md-6 main-tap-img">
                                    <div class="alpum">
                                        <img src="layout/img/ti-1.jpg" width="100%">
                                    </div>
                                    <p>اختر هاتفك الذكي</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/ti-02.jpg" width="100%">
                                        <p class="text-center">ساعات يد فاخرة</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/td-02.jpg" width="100%">
                                        <p class="text-center">اختر حاسوبك المحمول</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/td-01.jpg" width="100%">
                                        <p class="text-center">الكترونيات متفرقة</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/td-03.jpg" width="100%">
                                        <p class="text-center">تلفزيونات و شاشات</p>
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================== second window end ================== -->
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <!--
            **********************************
            ********************************
            first tab begin =============================================================================
            ********************************
            ********************************
        -->
        <div class="row mb">
            <h3 class="h3-index">سلع شائعة</h3><?php
            foreach ($getitems_two as $item)
            {
                include $temp . 'cards.php';
            } ?>
            <div class="clear-fix"></div>
        </div>
        <div class="row mb">
            <h3 class="h3-index">السلع الاكثر رواجا</h3><?php
            foreach ($getitems_one as $item)
            {
                include $temp . 'cards.php';
            } ?>
            <div class="clear-fix"></div>
        </div>
        <div class="row mb">
            <h3 class="h3-index">صفقات مقترحة لك</h3><?php
            foreach ($getitems_one as $item)
            {
                include $temp . 'cards.php';
            } ?>
            <div class="clear-fix"></div>
        </div>
        <!--
            **********************************
            ********************************
            second tab begin =============================================================================
            ********************************
            ********************************
        -->
        <div class="row mb">
            <div class="col-bxs-12 col-xs-12 tap-col">
                <div class="mrt-tap tap-two">
                    <span data-class='cloth' class="selected-tap">ازياء</span>
                    <span data-class='life-style'>لايف استايل</span>
                    <div class="tap-cont tc-two">
                        <div class="cloth col-bxs-12">
                            <div class="row">
                                <div class="col-md-6 main-tap-img">
                                    <div class="alpum">
                                        <img src="layout/img/c-01.jpg" width="100%">
                                    </div>
                                    <p>اجعل الذهب خيارك الاول</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/c-02.jpg" width="100%">
                                        <p class="text-center">احذية</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/c-03.jpg" width="100%">
                                        <p class="text-center">ازياء له</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/c-04.jpg" width="100%">
                                        <p class="text-center">ازيا لها</p>
                                    </div>
                                    <div class="four-img col-md-6 col-bxs-12 col-xs-12">
                                        <img src="layout/img/c-05.jpg" width="100%">
                                        <p class="text-center">مجوهرات و اكسسوارات</p>
                                    </div>
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="life-style col-bxs-12 col-xs-12">
                            llllllllllllllllll
                       </div>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <!--
            **********************************
            ********************************
            second tab end =============================================================================
            ********************************
            ********************************
        -->
        <div class="row mb">
            <div class="col-bxs-12 tap-col">
                <div class="mrt-tap">
                    <h3>الكترونيات</h3>
                    <span class="selected-tap left-tap">جوالات</span>
                    <span class="left-tap">حواسيب</span>
                    <div class="tap-cont">
                        <div class="col-bxs-12"><?php
                        foreach ($getitems_one as $item)
                        {
                            include $temp . 'cards.php';
                        } ?>
                        </div>
                        <div>llllllllllllllllll</div>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <div class="row mb">
            <div class="col-bxs-12 tap-col">
                <div class="mrt-tap">
                    <h3>لايف استايل</h3>
                    <span class="selected-tap left-tap">جوالات</span>
                    <span class="left-tap">حواسيب</span>
                    <div class="tap-cont">
                        <div class="col-bxs-12"><?php
                        foreach ($getitems_one as $item)
                        {
                            include $temp . 'cards.php';
                        } ?>
                        </div>
                        <div>llllllllllllllllll</div>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <div class="row mb">
            <div class="col-bxs-12 tap-col">
                <div class="mrt-tap">
                    <h3>الموضة و الازياء</h3>
                    <span class="selected-tap left-tap">جوالات</span>
                    <span class="left-tap">حواسيب</span>
                    <div class="tap-cont">
                        <div class="col-bxs-12"><?php
                        foreach ($getitems_one as $item)
                        {
                            include $temp . 'cards.php';
                        } ?>
                        </div>
                        <div>llllllllllllllllll</div>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
        <div class="row">
            <h3 class="h3-index">سلع مضافة حديثا</h3>
            <div class="col-xs-12 col-bxs-12 col-sm-6">
                <div class="opt-bar">
                    <span><i class="fa fa-sliders"></i> رتب حسب</span>
                    <span>
                        رتب
                        <i class="fa  fa-sort-desc" style="float: left;"></i>
                        <ul>
                            <a class = 'ctj' data-class="asc" ><li>اقل سعر</li></a>
                            <a class = 'ctj' data-class="desc"><li>اعلى سعر</li></a>
                            <a class = 'ctj' data-class="page"><li>حسب الاحدث</li></a>
                        </ul>
                    </span>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div id='aj'></div>
            <!--
            ***************pagnation system begin********
            -->
            <div class="pagnation col-bxs-12 col-xs-12">
                <div id="nums-container">
                    <?php
                    $count = TotalCount('itemID', 'items', '>', '0');
                    $num = (int) ceil($count / $pageNum); ?>
                    <!--============next and preveous start====-->
                    <a
                        href="?page=<?php echo $page - 1 ?>"
                        class="<?php echo $page == 1 ? 'remove-this-end' : null ?>"
                    >
                        <span class="next-and-prev"><i class="fa fa-angle-right"></i></span>
                    </a>
                    <a
                    href="?page=<?php echo $page + 1 ?>"
                    class="<?php echo $page == $num ? 'remove-this-end' : null ?>"
                    >
                        <span class="next-and-prev next-page"><i class="fa fa-angle-left"></i></span>
                    </a>
                    <!--============next and preveous end====-->
                   <?php
                    for ($i = $page - $num_page_count; $i <= $page + $num_page_count; $i++)
                    {
                        if ($i > 0 && $i <= $num)
                        { ?>
                            <a  class='pn <?php echo $i == $page ? "selected-page" : null ?> '  href="?page=<?php echo $i ?>">
                                <?php echo $i ?>
                            </a><?php
                        }
                    } ?>
                </div>
            </div>
            <!--
            ***************pagnation system end********
            -->
            <div class="clear-fix"></div>
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
                    getAjax('aj',"page=<?php echo $page ?>","");
                }
            })(i);
        }
        body.onload = function () {
            getAjax('aj',"page=<?php echo $page ?>","");
        }
    </script>
    <?php
}
include $temp . 'footer.php';
ob_end_flush();
