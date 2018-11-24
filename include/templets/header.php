<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title><?php gettitle(); ?></title>
	<link rel="stylesheet" type="text/css" href= "<?php   echo $css ;?>bootstrap.css">
    <link rel="stylesheet" type="text/css" href= "<?php echo $css ;?>font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href= "<?php echo $css ;?>frontend.css">
    <meta name="viewport"  content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo lang ('home') ; ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
         <?php
           foreach (getcats() as $cat) { ?>
          <li><a href="Categories.php?pageid=<?php echo $cat['ID']; ?>&pagename=<?php echo str_replace (' ','-', $cat['Name']);?>"><?php echo $cat['Name'];?></a></li>
         <?php } ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">more<span class="caret"></span></a>
            <ul class="dropdown-menu">
               <?php
                 foreach (getcats(5,100) as $cat) { ?>
                <li><a href="Categories.php?pageid=<?php echo $cat['ID']; ?>&pagename=<?php echo str_replace (' ','-', $cat['Name']);?>"><?php echo $cat['Name'];?></a></li>
               <?php } ?>
            </ul>
          </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

