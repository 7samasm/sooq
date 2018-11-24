<?php 
ob_start(); 
session_start();
$pagetitle= "dashbord";
if (isset($_SESSION['username'])) {
	include 'config.php';
	// latest start ===>
	$lmtAndHeading = 5;
	$getlastUsers    = getlatest ('*','users','userID','DESC',$lmtAndHeading);
	$getlastItems    = getlatest ('*','items','itemID','DESC',$lmtAndHeading);
	$getlastComments = getlatest ('*','comments','c_id','DESC',$lmtAndHeading);
	// latest end   ===>
	?>
	<div class="container stat-home text-center">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-3">
			    <a href="Members.php">
					<div class="stat">
					    Total Members
					    <span><?php echo TotalCount ('userID','users','>',0); ?></span>
					</div>
				</a>
			</div>
			<div class="col-md-3">
			    <a href="Members.php?page=pending">
					<div class="stat st-nxt">
					    Pending Members
					    <span><?php echo TotalCount ('reg','users','=',0); ?></span>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="items.php">
					<div class="stat">
					    Total Items
					    <span><?php echo TotalCount ('itemID','items','>',0); ?></span>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="comments.php">
					<div class="stat st-nxt">
					    Total Comments
					    <span><?php echo TotalCount ('c_id','comments','>',0); ?></span>
					</div>
				</a>
			</div>									
		</div>
	</div>

	<div class="container">
		<div class="row latest">
			<div class="col-sm-6">
				<div class="panel panel-default panel-border-none">
					<div class="panel-heading panel-color1">
						<i class="fa fa-users"></i>&nbsp Latest <?php echo $lmtAndHeading; ?> Reg Users
					</div>
					<div class="panel-body">
						<?php
						  foreach ($getlastUsers as $row) { ?>
						    <div class="fe">
							  	<a href="Members.php?do=edit&userid=<?php echo $row['userID'] ;?>">
							  	   <?php echo $row['username']; ?>
							  	</a>
							  	<?php
							  	if ($row['reg'] == 0 ) {?>
							  	<a href="Members.php?do=active&userid=<?php echo $row['userID'] ;?>">
							  		<span class="btn-cle fa fa-check"></span>
							  	</a>
							  	<?php } ?>	
						  	</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default panel-border-none">
					<div class="panel-heading panel-color2">
						<i class="fa fa-shopping-cart"></i>&nbsp Latest <?php echo $lmtAndHeading; ?> Items
					</div>
					<div class="panel-body">
						<?php
						  foreach ($getlastItems as $row) { ?>
						    <div class="fe">
							  	<a href="items.php?do=edit&itemid=<?php echo $row['itemID'] ;?>">
							  	   <?php echo $row['name']; ?>
							  	</a>
						  	</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default panel-border-none">
					<div class="panel-heading panel-color2" style="background: #e74c3c">
						<i class="fa fa-comments-o"></i>&nbsp Latest <?php echo $lmtAndHeading; ?> comments <span class='cc' title="pending comments"><?php echo TotalCount ('status','comments','=',0); ?></span>
					</div>
					<div class="panel-body">
						<?php
						  foreach ($getlastComments as $row) { ?>
						    <div class="fe">
							  	<a href="comments.php?do=edit&commentid=<?php echo $row['c_id'] ;?>">
							  	   <?php echo $row['comment']; ?>
							  	</a>
                                <?php
							  	if ($row['status'] == 0 ) {?>
							  	<a href="comments.php?do=active&comment=<?php echo $row['c_id'] ;?>">
							  		<span class="btn-cle fa fa-check"></span>
							  	</a>
							  	<?php } ?>								  	
						  	</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default panel-border-none admin-add">
					<div class="panel-heading panel-color3">
						<i class="fa fa-sliders"></i>&nbsp options
					</div>
					<div class="panel-body" style="padding: 10px 0;">
						<div class="add-opts">
							<div class="add-container">
							    <h4 id="h4-icon-1"><i class='fa fa-plus'></i> Add</h4>
							    <div class="all-crle">
									<div class="add-menu">
									    <a href="Categories.php?do=add">
											<div class="i-container"><i class="fa fa-tag"></i></div>
											<p>add cat</p>
										</a>
									</div>
									<div class="add-menu">
									    <a href="Members.php?do=add">
											<div class="i-container"><i class="fa fa-users"></i></div>
											<p>add user</p>
										</a>
									</div>
									<div class="add-menu">
										<a href="items.php?do=add">
											<div class="i-container"><i class="fa fa-shopping-cart"></i></div>
											<p>add items</p>
										</a>
									</div>
								</div>								
							</div>
						</div>
						<?php if ( $_SESSION['ID'] == 1 ) { ?>
						<hr>
						<div class="add-opts">
							<div class="add-container">
							    <h4 id="h4-icon-2"><i class='fa fa-plus'></i> Admin</h4>
							    <div class="all-crle">
									<div class="add-menu">
									    <a href="Members.php?page=aa">
											<div class="i-container"><i class="fa fa-user-plus"></i></div>
											<p>add admin</p>
										</a>
									</div>
									<div class="add-menu">
									    <a href="Members.php?page=admins">
											<div class="i-container"><?php echo TotalCount ('groupID','users','=',1); ?></div>
											<p>total admins</p>
										</a>
									</div>
								</div>								
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>						
		</div>
	</div>
	<?php
	include  $temp .'footer.php';
    
} else {

	header('location: index.php');
    exit();
}
ob_end_flush();

