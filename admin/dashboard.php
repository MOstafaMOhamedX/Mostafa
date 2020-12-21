<?php

ob_start(); // Output Buffering Start

session_start();

if (isset($_SESSION['Username'])) {

	$pageTitle = 'Dashboard';

	include 'init.php';
	$latest_no = 10;
	$latest = getLatest('*', 'users', 'UserID', $latest_no);
	$latest2 = getLatest('*', 'categories', 'ID', $latest_no);
	$latest3 = getLatest('*','items','Item_ID',$latest_no)

?>
	<!--Start dashboard page-->
	<div class="container home-stats text-center">
		<h1>Dashboard</h1>
		<div class="row">


			<div class="col-md-3 col-sm-6">
				<div class="stat st-users">
					<i class="fa fa-user"></i>
					<div class="infoo">
						Total Members
						<span>
							<a href="members.php"  <?php if(countItems('UserID', 'users', 'WHERE  GroupID =0') == 0 ){echo 'class=\'disabled\'';} ?>  ><?php echo countItems('UserID', 'users', 'WHERE  GroupID =0'); ?></a>
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6">
				<div class="stat st-pinding">
					<i class="fa fa-users"></i>
					<div class="infoo">
						Pinding Members
						<span>
							<a href="members.php?do=Manage&page=pending" <?php if(countItems('UserID', 'users', 'WHERE RegStatus = 0 AND GroupID =0') == 0 ){echo 'class=\'disabled\'';} ?>><?php echo countItems('UserID', 'users', 'WHERE RegStatus = 0 AND GroupID =0'); ?></a>
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-2 col-sm-6">
				<div class="stat st-items">
					<i class="fa fa-plus"></i>
					<div class="infoo">
						Total Items
						<span><a href="items.php" <?php if(countItems('Item_ID', 'items') == 0 ){echo 'class=\'disabled\'';} ?> ><?php echo countItems('Item_ID', 'items'); ?></a></span>
					</div>
				</div>
			</div>
			
			<div class="col-md-2 col-sm-6">
				<div class="stat st-comments">
					<i class="fa fa-tag"></i>	
					<div class="infoo">
						Total categories
						<span><a href="categories.php?sort=ASC" <?php if(countItems('ID', 'categories') == 0 ){echo 'class=\'disabled\'';} ?>><?php echo countItems('ID', 'categories'); ?></a></span>
					</div>
				</div>
			</div>


			<div class="col-md-2 col-sm-6">
				<div class="stat st-members">
						<i class="fa fa-comments"></i>
				<div class="infoo">
						 Total Comments
						<span>
							<a href="comments.php" <?php if(countItems('c_id', 'comments') == 0 ){echo 'class=\'disabled\'';} ?> ><?php echo countItems('c_id', 'comments'); ?></a>
						</span>
				</div>
				</div>
			</div>

		</div>
	</div>

	<div class="container latest">
		<div class="row">


			<div class="col-sm-4">
				<div class="panel panel-default">

					<div class="panel-heading">
						<i class="fa fa-user"></i> Latest  Registerd Users
						<span class="pull-right toggle-info">
							<i class="fa fa-minus fa-lg "></i>
						</span>
					</div>

					<div class="panel-body">
						<?php
						echo "<table class='table center  table-striped table-bordered' col-sm-6>";
						foreach ($latest as $user) {
							echo "<tr>";
							if ($user['GroupID'] == 0) {
								echo
									'
											<td class="btn-dash0"> <label>' . $user['Username'] . '</label><br>
											<div class="btn-dash">
											<a class="btn btn-success" href="members.php?do=Edit&userid=' . $user['UserID'] . '"><i class="fa fa-edit"></i> Edit </a>
											<a class="btn btn-danger "href="members.php?do=Delete&userid=' . $user['UserID'] . '"><i class="fa fa-close"></i> Delete </a>';
								if ($user['RegStatus'] == 0) {
									echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] . "'class='btn btn-info activate'>
											<i class='fa fa-check'></i> Activate</a>";
								}
							}
							echo '</div></td>';
							echo "</tr>";
						}
						echo "</table>";
						?>
					</div>


				</div>
			</div>

			<div class="col-sm-4">
				<div class="panel panel-default">

					<div class="panel-heading">
						<i class="fa fa-user"></i> Latest  categories
						<span class="pull-right toggle-info">
							<i class="fa fa-minus fa-lg "></i>
						</span>
					</div>

					<div class="panel-body">
						<?php
						echo "<table class='table center  table-striped table-bordered' col-sm-6>";
						foreach ($latest2 as $cat) {
							echo "<tr>";
								echo
									'
											<td class="btn-dash0"> <label>' .  $cat['Name']. '</label><br>
											<div class="btn-dash">
											<a class="btn btn-success" href="categories.php?do=Edit&ID=' .$cat['ID'] . '"><i class="fa fa-edit"></i> Edit </a>
											<a class="btn btn-danger "href="categories.php?do=Delete&ID=' .$cat['ID'] . '"><i class="fa fa-close"></i> Delete </a>';
							
							echo '</div></td>';
							echo "</tr>";
						}
						echo "</table>";
						?>
					</div>


				</div>
			</div>

			<div class="col-sm-4">
				<div class="panel panel-default">

					<div class="panel-heading">
						<i class="fa fa-user"></i> Latest  Items
						<span class="pull-right toggle-info">
							<i class="fa fa-minus fa-lg "></i>
						</span>
					</div>
					

					<div class="panel-body">
						<?php
						echo "<table class='table center  table-striped table-bordered' col-sm-6>";
						foreach ($latest3 as $item) {
							echo "<tr>";
								echo
									'
											<td class="btn-dash0"> <label>' .  $item['Name']. '</label><br>
											<div class="btn-dash">
											<a class="btn btn-success" href="items.php?do=Edit&Item_ID=' .$item['Item_ID'] . '"><i class="fa fa-edit"></i> Edit </a>
											<a class="btn btn-danger "href="items.php?do=Delete&Item_ID=' .$item['Item_ID'] . '"><i class="fa fa-close"></i> Delete </a>';
											if ($item['Approve'] == 0) {
												echo "<a 
														 href='items.php?do=Approve&Item_ID=" . $item['Item_ID'] . "'class='btn btn-info activate'>
														 <i class='fa fa-check'></i>Approve</a>";
							 }
							echo '</div></td>';
							echo "</tr>";
						}
						echo "</table>";
						?>
					</div>


				</div>
			</div>

		</div>
	</div>
	<!--end dashboard page-->
<?php

	include $tpl . 'footer.php';
} else {

	header('Location: index.php');

	exit();
}

ob_end_flush(); // Release The Output

?>