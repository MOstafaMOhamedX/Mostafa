<?php

/** Manage comments Add delete or edit  */
ob_start();
session_start();
$pageTitle = 'comments';

if (isset($_SESSION['Username'])) {

  include 'init.php';
  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  /*-------------------------------------------------------------------------------------------------------------------------------------------- */
  if ($do == 'Manage') { // Manage comments 
   

    $stmt = $con->prepare("SELECT comments.* , items.Name  as item_name, users.Username as user_name
                            FROM comments 
                              INNER JOIN items ON items.Item_ID = comments.item_id
                              INNER JOIN users ON users.UserID = comments.user_id ");
    $stmt->execute();
    $comments = $stmt->fetchAll();

    $count =  count_rows('comments');

    if ($count > 0) {

?>
    <h1 class="text-center">Manage comments</h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>ID</td>
            <td>Comment</td>
            <td>Status</td>
            <td>Date</td>
            <td>Item ID</td>
            <td>User ID</td>
            <td>Control</td>
          </tr>
          <?php
          foreach ($comments as $comment) {
            echo "<tr>";
            echo "<td>" . $comment['c_id'] . "</td>";
            echo "<td style=' width: 50%;'>" . $comment['comment'] . "</td>";
            echo "<td>" . $comment['status'] . "</td>";
            echo "<td>" . $comment['comment_date'] . "</td>";
            echo "<td>" . $comment['item_name'] . "</td>";
            echo "<td>" . $comment['user_name'] . "</td>";
            echo "<td>
										<a href='comments.php?do=Delete&c_id=" . $comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </table>
      </div>
      
    </div>
    <?php
  } else {
    $theMsg = "<div class='alert alert-info  container text-center'>There is no data </div>";
    echo($theMsg);
  }
}
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Delete') { //Delete Data
    $c_id   =  isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;
    $check  = checkItem('c_id', 'comments', $c_id);
    if ($check > 0) {
      $stat = $con->prepare("DELETE FROM comments WHERE c_id = :zID");
      $stat->bindParam(":zID", $c_id);
      $stat->execute();
      //header('Location: ' . $_SERVER['HTTP_REFERER']);
      echo '<h1 class="text-center">Delete Comments</h1>
            <div class="container">';
      $theMsg = "<div class='alert alert-success container text-center pad'>" . ' Comment Deleted Successfully</div>';
      redirectHome($theMsg, 'back');
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
    echo '</div>';

  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ 
  include $tpl . 'footer.php';
} else {
  redirectHome('index.php');
  exit();
}

ob_end_flush();