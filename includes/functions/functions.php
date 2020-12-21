<?php


/*
	** Get Latest Records Function v1.0
	** Function To Get Latest Items From Database [ Users, Items, Comments ]
	** $select = Field To Select
	** $table = The Table To Choose From
	** $order = The Desc Ordering
	** $limit = Number Of Records To Get
	*/

function getLatest($select, $table, $order, $limit = 5)
{

	global $con;

	$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

	$getStmt->execute();

	$rows = $getStmt->fetchAll();

	return $rows;
}



/*  title function $pageTitle */
function gettitle()
{
	global $pageTitle;
	if (isset($pageTitle)) {
		echo $pageTitle;
	} else {
		echo 'Default';
	}
}




function redirectHome($theMsg = null, $url = null, $seconds = 1)
{

	if ($url === null) {

		$url = './dashboard.php';

		$link = 'Homepage';
	} else {

		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

			$url = $_SERVER['HTTP_REFERER'];

			$link = 'Previous Page';
		} else {

			$url = './dashboard.php';

			$link = 'Homepage';
		}
	}

	echo $theMsg;

	echo "<div class='alert alert-dark container text-center'>" . ' You Will Be Redirected to ' . $link . ' After <b>' . $seconds . '</b> Seconds.</div>';

	header("refresh:$seconds;url=$url");

	exit();
}




function checkItem($select, $from, $value)
{

	global $con;

	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

	$statement->execute(array($value));

	$count = $statement->rowCount();

	return $count;
}



function countItems($item, $table, $where = null)
{

	global $con;

	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table  $where");

	$stmt2->execute();

	return $stmt2->fetchColumn();
}



function get_items($cat_id)
{

	global $con;

	$getStmt = $con->prepare("SELECT * FROM items WHERE  Cat_ID = $cat_id ORDER BY Item_ID DESC  ");

	$getStmt->execute(array($cat_id));

	return $getStmt->fetchAll();
}


function get_cat()
{

	global $con;

	$getStmt = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

	$getStmt->execute();

	return $getStmt->fetchAll();
}



function count_rows($table)
{

	global $con;

	$row = $con->prepare("SELECT  COUNT(*) FROM $table");

	$row->execute();

	return $row->fetchColumn();
}


function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC")
{

	global $con;

	$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

	$getAll->execute();

	$all = $getAll->fetchAll();

	return $all;
}

/*
	** Check If User Is Not Activated
	** Function To Check The RegStatus Of The User
	*/

function checkUserStatus($user)
{

	global $con;

	$stmtx = $con->prepare("SELECT 
									Username, RegStatus 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									RegStatus = 0");

	$stmtx->execute(array($user));

	$status = $stmtx->rowCount();

	return $status;
}



/*
	** Check If User Is Not Activated
	** Function To Check The RegStatus Of The User
	*/

function getimage($id)
{

	global $con;

	$getStmt = $con->prepare("SELECT 
									avatar 
								FROM 
								users 
								WHERE 
								UserID = ? ");
	$getStmt->execute(array($id));

	$rows = $getStmt->fetchColumn();

	return $rows;
}
