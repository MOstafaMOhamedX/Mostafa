<?php

/** Manage members Add delete or edit  */
ob_start();
session_start();
$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {

  include 'init.php';
  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  /*-------------------------------------------------------------------------------------------------------------------------------------------- */
  if ($do == 'Manage') { // Manage Members
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=  1  ");
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
      $query = '';
      if (isset($_GET['page']) && $_GET['page'] == 'pending') {
        $query = 'AND RegStatus = 0';
      }
      if (isset($_GET['page']) && $_GET['page'] == 'active') {
        $query = 'AND RegStatus = 1';
      }

      $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=  1  $query ");
      $stmt->execute();
      $rows = $stmt->fetchAll();



?>
      <h1 class="text-center">Manage Members</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table manage-members text-center table table-bordered">
            <tr>
              <td>ID</td>
              <td>Avatar</td>
              <td>Username</td>
              <td>Email</td>
              <td>FullName</td>
              <td>Register Date</td>
              <td>Control</td>
            </tr>
            <?php
            foreach ($rows as $row) {
              echo "<tr>";
              echo "<td>" . $row['UserID'] . "</td>";
              echo "<td>";
              if (empty($row['avatar'])) {
                echo "<img src='Uploads/avatars/avatar.png' alt='' />";
              } else {
                echo "<img src='Uploads/avatars/" . $row['avatar'] . "' alt='' />";
              }
              echo "</td>";
              echo "<td>" . $row['Username'] . "</td>";
              echo "<td>" . $row['Email'] . "</td>";
              echo "<td>" . $row['FullName'] . "</td>";
              echo "<td>" . $row['Date'] . "</td>";
              echo "<td>
										<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
              if ($row['RegStatus'] == 0) {
                echo "<a 
                          href='members.php?do=Activate&userid=" . $row['UserID'] . "'class='btn btn-info activate'>
                          <i class='fa fa-check'></i> Activate</a>";
              }
              echo "</td>";
              echo "</tr>";
            } ?>


          </table>
          <a href="members.php?do=Add" class="btn btn-primary center "> <i class="fa fa-plus"> Add New Member</i> </a>
        </div>

      </div>
    <?php
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>There is no data </div>";
      echo ($theMsg);
      echo '<div class="container"><a href="members.php?do=Add" class="btn btn-primary center "> <i class="fa fa-plus"> Add New Member</i> </a></div>';
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Edit') { //Edit Members 

    $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();


    if ($count > 0) { ?>
      <h1 class="text-center">Edit Members</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="userid" value="<?php echo $userid ?>">

          <div class="form-group form-group-md">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="Username" class="form-control " autocomplete="off" value="<?php echo $row['Username']; ?>" required="required">
            </div>
          </div>


          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-4">
              <input type="password" name="newpassword" class="form-control" autocomplete="new-password value=" placeholder="Leave It If You didn't want to change Password">
              <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-4">
              <input type="Email" name="Email" class="form-control" value="<?php echo $row['Email']; ?>" required="required">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">FullName</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="FullName" class="form-control" value="<?php echo $row['FullName']; ?>" required="required">
            </div>
          </div>

          

          <div class="form-group  form-group-md">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" value="Edit" class="btn btn-primary btn-lg" />
            </div>
          </div>

        </form>
      </div>
    <?php } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Update') { // Update Data

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      echo ' <h1 class="text-center">Update Members</h1>';
      $id      = $_POST['userid'];
      $user    = $_POST['Username'];
      $email   = $_POST['Email'];
      $name    = $_POST['FullName'];
      $pass    = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);

      $formErrors = array();

      if (strlen($user) > 20) {
        $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
      }

      if (empty($user) || strlen($user) < 4) {
        $formErrors[] = 'Username Cant Be <strong> Less than 4 Characters</strong>';
      }

      if (empty($name)) {
        $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
      }

      if (empty($email)) {
        $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
      }

      foreach ($formErrors as $error) {
        echo '<div class="alert alert-danger text-center container">' . $error . '</div>';
      }
      if (empty($formErrors)) {
        $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");

        $stmt->execute(array($user, $email, $name, $pass, $id));


        if ($stmt->rowCount() > 0) {
          $theMsg = "<div class='alert alert-success container text-center'>" . ' Profile Updated</div>';
          redirectHome($theMsg, 'back');
        } elseif ($stmt->rowCount() ==  0) {
          $theMsg = "<div class='alert alert-info  container text-center'>" . ' Data Doesn\'t Change</div>';
          redirectHome($theMsg, 'back');
        }
      }
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Add') { //add members
    ?>
    <h1 class="text-center">Add New Members</h1>
    <div class="container">
      <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

        <div class="form-group form-group-md ">
          <label class="col-sm-2 control-label">Username</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="Username2" class="form-control " autocomplete="off" required="required" placeholder="Username">
          </div>
        </div>


        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10 col-md-4">
            <input type="password" name="password2" class="form-control password" autocomplete="new-password" placeholder="Password" required="required">
            <i class="show-pass fa fa-eye fa-2x"></i>
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10 col-md-4">
            <input type="Email" name="Email2" class="form-control" required="required" placeholder="Email">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">FullName</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="FullName2" class="form-control" placeholder="FullName" required="required">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Member Photo</label>
          <div class="col-sm-10 col-md-4">
            <input type="file" name="avatar" class="form-control" placeholder="FullName" required="required">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
          </div>
        </div>

      </form>
    </div>
<?php
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Insert') { //insert Data

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      echo ' <h1 class="text-center">Added Members</h1>';

      $avatar_name =  $_FILES['avatar']['name'];
      $avatar_size =  $_FILES['avatar']['type'];
      $avatar_tmpN =  $_FILES['avatar']['tmp_name'];
      $avatar_size =  $_FILES['avatar']['size'];
      $avatar_extentions =  array('jpg', 'jepg', 'png',  'gif');
      $file_exp    =  explode('.', $avatar_name);
      $file_end    =  end($file_exp);
      $avatar_ext  =  strtolower($file_end);




      $user      = $_POST['Username2'];
      $email     = $_POST['Email2'];
      $name      = $_POST['FullName2'];
      $pass      = $_POST['password2'];
      $hashpass  = sha1($_POST['password2']);

      $formErrors = array();

      if (strlen($user) > 20) {
        $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
      }

      if (empty($user) || strlen($user) < 4) {
        $formErrors[] = 'Username Cant Be <strong> Less than 4 Characters</strong>';
      }

      if (empty($name)) {
        $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
      }

      if (empty($email)) {
        $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
      }
      if (!empty($avatar_name) && !in_array($avatar_ext, $avatar_extentions)) {
        $formErrors[] = 'This extiontions not <strong>Allowed</strong>';
      }
      if (empty($avatar_name)) {
        $formErrors[] = ' avatar <strong>required</strong>';
      }
      if ($avatar_size > 4194304) {
        $formErrors[] = ' avatar Size<strong>Large</strong>';
      }


      foreach ($formErrors as $error) {
        $theMsg = "<div class='alert alert-danger container text-center pad'>" . $error . ' </div>';
        redirectHome($theMsg, 'back');
      }


      if (empty($formErrors)) {

        $avatar = rand(0, 1000000000000) . '_' . $avatar_name;
        move_uploaded_file($avatar_tmpN, "Uploads\avatars\\" . $avatar);


        $check = checkItem("Email", "users", $email);
        if ($check == 1) {
          $theMsg = "<div class='alert alert-danger container text-center pad'>" . ' This user is exist</div>';
          redirectHome($theMsg, 'back');
        } else {
          $stmt = $con->prepare("INSERT INTO users (Username ,Password ,Email , FullName , RegStatus , Date , avatar)
                                VALUES  ( :zuser , :zpass , :zemail , :zname , 1 , now() , :zavatar) ");

          $stmt->execute(array(
            'zuser' => $user,
            'zpass' => $hashpass,
            'zemail' => $email,
            'zname' => $name,
            'zavatar' => $avatar
          ));


          if ($stmt->rowCount() > 0) {
            $theMsg = "<div class='alert alert-success container text-center'>" . ' Member Aded Successfully</div>';
            redirectHome($theMsg, 'back');
          } elseif ($stmt->rowCount() ==  0) {
            $theMsg = "<div class='alert alert-info  container text-center'>" . '  Error happened </div>';
            redirectHome($theMsg, 'back');
          }
        }
      }
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Delete') { //Delete Data


    $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    $check  = checkItem('UserID', 'users', $userid);
    if ($check > 0) {


      $stat = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
      $stat->bindParam(":zuser", $userid);
      $stat->execute();
      //header('Location: ' . $_SERVER['HTTP_REFERER']);
      echo '<h1 class="text-center">Delete Members</h1>
            <div class="container">';
      $theMsg = "<div class='alert alert-success container text-center pad'>" . ' Member Deleted Successfully</div>';
      redirectHome($theMsg, 'back');
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
    echo '</div>';
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Activate') { //Activate Data


    $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    $check  = checkItem('UserID', 'users', $userid);
    if ($check > 0) {
      echo '
      <h1 class="text-center">Activate Members</h1>
      <div class="container">
    ';

      $stat = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
      $stat->execute(array($userid));
      $theMsg = "<div class='alert alert-success container text-center pad'>" . ' Member Activated Successfully </div>';
      redirectHome($theMsg, 'back');
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
    echo '</div>';
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ else {
    $theMsg = "<div class='alert alert-danger container text-center pad'>Error</div>";
    redirectHome($theMsg);
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */

  include $tpl . 'footer.php';
} else {
  $theMsg = "<div class='alert alert-danger container text-center pad'>Error</div>";
  redirectHome($theMsg, 'index.php');
  exit();
}
ob_end_flush();
