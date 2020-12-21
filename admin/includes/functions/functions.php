<?php

	/*  title function $pageTitle */
	function gettitle(){
		global $pageTitle;
		if(isset($pageTitle)){
			echo $pageTitle;
		}else{
			echo 'Default';
		}
	}

	
	/*
	** Home Redirect Function v2.0
	** This Function Accept Parameters
	** $theMsg = Echo The Message [ Error | Success | Warning ]
	** $url = The Link You Want To Redirect To
	** $seconds = Seconds Before Redirecting
	*/

	function redirectHome($theMsg = null, $url = null, $seconds = 1) {

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

		echo "<div class='alert alert-dark container text-center'>" . ' You Will Be Redirected to '.$link.' After <b>'. $seconds . '</b> Seconds.</div>';

		header("refresh:$seconds;url=$url");

		exit();

	}


	/*
	** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
	*/

	function checkItem($select, $from, $value) {

		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;

	}

	
	/*
	** Count Number Of Items Function v1.0
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
	*/

	function countItems($item, $table ,$where = null) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table  $where");

		$stmt2->execute();

		return $stmt2->fetchColumn();

	}

		/*
	** Get Latest Records Function v1.0
	** Function To Get Latest Items From Database [ Users, Items, Comments ]
	** $select = Field To Select
	** $table = The Table To Choose From
	** $order = The Desc Ordering
	** $limit = Number Of Records To Get
	*/

	function getLatest($select, $table, $order, $limit = 5) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getStmt->execute();

		return $getStmt->fetchAll(PDO::FETCH_ASSOC );

	}

		/*
	** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
	*/

	function count_rows($table) {

			global $con;

			$row = $con->prepare("SELECT  COUNT(*) FROM $table");

			$row->execute();

			return $row->fetchColumn();

	}