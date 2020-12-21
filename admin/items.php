<?php

/** Manage Items Add delete or edit  */
ob_start();
session_start();
$pageTitle = 'Items';

if (isset($_SESSION['Username'])) {

  include 'init.php';
  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  /*-------------------------------------------------------------------------------------------------------------------------------------------- */
  if ($do == 'Manage') { // Manage Items 



    $stmt = $con->prepare("SELECT items.* , categories.Name as Cat_Name , users.Username as User_Name FROM items 
                            INNER JOIN categories ON categories.ID = items.Cat_ID
                            INNER JOIN users ON users.UserID = items.Member_ID ");
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $count =  count_rows('items');

    if ($count > 0) {
?>
      <h1 class="text-center">Manage Items</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Prics</td>
              <td>Status</td>
              <td>Adding Date</td>
              <td>Category_Name</td>
              <td>User_Name</td>
              <td>Control</td>
            </tr>
            <?php
            foreach ($rows as $row) {
              echo "<tr>";
              echo "<td>" . $row['Item_ID'] . "</td>";
              echo "<td>" . $row['Name'] . "</td>";
              echo "<td>" . $row['Description'] . "</td>";
              echo "<td>" . $row['Price'] . "</td>";
              echo "<td>";
              if ($row['Status'] == 1) {
                echo "New";
              } elseif ($row['Status'] == 2) {
                echo "Used";
              } else {
                echo "Old";
              }
              echo "</td>";
              echo "<td>" . $row['Add_Date'] . "</td>";
              echo "<td>" . $row['Cat_Name'] . "</td>";
              echo "<td>" . $row['User_Name'] . "</td>";
              echo "<td>
										<a href='items.php?do=Edit&Item_ID=" . $row['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                    <a href='items.php?do=Delete&Item_ID=" . $row['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
              if ($row['Approve'] == 0) {
                echo "<a 
                          href='items.php?do=Approve&Item_ID=" . $row['Item_ID'] . "'class='btn btn-info activate'>
                          <i class='fa fa-check'></i>Approve</a>";
              }
              echo "</td>";
              echo "</tr>";
            }
            ?>


          </table>
          <a href="items.php?do=Add" class="btn btn-primary center "> <i class="fa fa-plus">Add New Item</i> </a>
        </div>
      </div>
    <?php
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>There is no data </div>";
      echo($theMsg);
      echo'<div class="container"><a href="items.php?do=Add" class="btn btn-primary center "> <i class="fa fa-plus">Add New Item</i> </a></div>';
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Edit') { //Edit Items 
    $Item_ID  =  isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
    $stmt = $con->prepare("SELECT * FROM `items` WHERE Item_ID = ?    ");

    $stmt->execute(array($Item_ID));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();


    if ($count > 0) { ?>
      <h1 class="text-center">Edit Items</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="Item_ID" value="<?php echo $Item_ID ?>">

          <div class="form-group form-group-md ">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="name" class="form-control " required="required" placeholder="Name of Items" value="<?php echo $row['Name']; ?>">
            </div>
          </div>


          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="Description" class="form-control" required="required" placeholder="Description of Items" value="<?php echo $row['Description']; ?>">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="price" class="form-control" required="required" placeholder="Price of Items" value="<?php echo $row['Price']; ?>">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made" value="<?php echo $row['Country_Made']; ?>">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2  control-label">Status</label>
            <div class="col-sm-10 col-md-4">
              <select name="status" class="form-control">
                <option value="0" <?php if ($row['Status'] == 0) echo 'selected'; ?>>....</option>
                <option value="1" <?php if ($row['Status'] == 1) echo 'selected'; ?>>New</option>
                <option value="2" <?php if ($row['Status'] == 2) echo 'selected'; ?>>Used</option>
                <option value="3" <?php if ($row['Status'] == 3) echo 'selected'; ?>>Old</option>
              </select>
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2  control-label">Member</label>
            <div class="col-sm-10 col-md-4">
              <select name="member" class="form-control">
                <option value="0">....</option>
                <?php
                $stat = $con->prepare("SELECT * FROM users");
                $stat->execute();
                $users = $stat->fetchAll();
                foreach ($users as $user) {
                  echo "<option value='" . $user['UserID'] . "' ";
                  if ($row['Member_ID'] == $user['UserID']) echo 'selected';
                  echo ">
                       " . $user['Username'] . "
                    </option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2  control-label">Category</label>
            <div class="col-sm-10 col-md-4">
              <select name="categories" class="form-control">
                <option value="0">....</option>
                <?php
                $stat = $con->prepare("SELECT * FROM categories");
                $stat->execute();
                $categories = $stat->fetchAll();
                foreach ($categories as $cat) {
                  echo "<option value='" . $cat['ID'] . "' ";
                  if ($row['Cat_ID'] == $cat['ID']) echo 'selected';
                  echo ">
                       " . $cat['Name'] . "
                    </option>";
                }
                ?>
              </select>
            </div>
          </div>


          <div class="form-group  form-group-md">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" value="Edit Item" class="btn btn-primary btn-lg" />
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
      echo ' <h1 class="text-center">Update Items</h1>';

      $Item_ID       = $_POST['Item_ID'];
      $Name          = $_POST['name'];
      $Description   = $_POST['Description'];
      $Price         = $_POST['price'];
      $Country_Made  = $_POST['country'];
      $Status        = $_POST['status'];
      $Member_ID     = $_POST['member'];
      $Category_ID   = $_POST['categories'];

      $formErrors = array();

      if (empty($Name) || empty($Description) || empty($Price) || empty($Country_Made) || empty($Status)) {
        $formErrors[] = 'Data Cant be <strong>Empty</strong>';
      }
      if ($Status == 0 || $Member_ID == 0  || $Category_ID == 0) {
        $formErrors[] = 'You must Choose From<strong>Select Boxs</strong>';
      }
      foreach ($formErrors as $error) {
        echo '<div class="alert alert-danger text-center container">' . $error . '</div>';
      }
      if (empty($formErrors)) {
        $stmt = $con->prepare("UPDATE 
                                    items 
                                  SET
                                    Name=?,
                                    Description=?,
                                    Price=?,
                                    Country_Made=?, 
                                    Status=?,
                                    Member_ID=?,
                                    Cat_ID=?
                                  WHERE 
                                    Item_ID =?");

        $stmt->execute(array($Name, $Description, $Price, $Country_Made, $Status, $Member_ID, $Category_ID, $Item_ID));


        if ($stmt->rowCount() > 0) {
          $theMsg = "<div class='alert alert-success container text-center'>" . ' Item Updated</div>';
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
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Add') { //add Items
    ?>

    <h1 class="text-center">Add New Items</h1>
    <div class="container">
      <form class="form-horizontal" action="?do=Insert" method="POST">

        <div class="form-group form-group-md ">
          <label class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="name" class="form-control " required="required" placeholder="Name of Items">
          </div>
        </div>


        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="Description" class="form-control" required="required" placeholder="Description of Items">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Price</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="price" class="form-control" required="required" placeholder="Price of Items">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Country</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2  control-label">Status</label>
          <div class="col-sm-10 col-md-4">
            <select name="status" class="form-control">
              <option value="0">....</option>
              <option value="1">New</option>
              <option value="2">Used</option>
              <option value="3">Old</option>
            </select>
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2  control-label">Member</label>
          <div class="col-sm-10 col-md-4">
            <select name="member" class="form-control">
              <option value="0">....</option>
              <?php
              $stat = $con->prepare("SELECT * FROM users");
              $stat->execute();
              $users = $stat->fetchAll();
              foreach ($users as $user) {
                echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2  control-label">Category</label>
          <div class="col-sm-10 col-md-4">
            <select name="categories" class="form-control">
              <option value="0">....</option>
              <?php
              $stat = $con->prepare("SELECT * FROM categories");
              $stat->execute();
              $categories = $stat->fetchAll();
              foreach ($categories as $cat) {
                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>


        <div class="form-group  form-group-md">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
          </div>
        </div>

      </form>
    </div>
<?php }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Insert') { //insert Data

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      echo ' <h1 class="text-center">Added Item</h1>';

      $Name           = $_POST['name'];
      $Description    = $_POST['Description'];
      $price          = $_POST['price'];
      $country        = $_POST['country'];
      $status         = $_POST['status'];
      $member         = $_POST['member'];
      $categories     = $_POST['categories'];

      $formErrors = array();

      if (empty($Name)) {
        $formErrors[] = 'Name Cant Be More Than <strong>20 Characters</strong>';
      }

      if (empty($Description)) {
        $formErrors[] = 'Description Cant Be <strong> Empty</strong>';
      }

      if (empty($price)) {
        $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
      }

      if (empty($country)) {
        $formErrors[] = 'country Cant Be <strong>Empty</strong>';
      }

      if ($status == 0) {
        $formErrors[] = 'You must Choose <strong>Status</strong>';
      }
      if ($member == 0) {
        $formErrors[] = 'You must Choose <strong>Status</strong>';
      }
      if ($categories == 0) {
        $formErrors[] = 'You must Choose <strong>Status</strong>';
      }

      foreach ($formErrors as $error) {
        $theMsg = "<div class='alert alert-danger container text-center pad'>" . $error . ' </div>';
        redirectHome($theMsg, 'back');
      }
      if (empty($formErrors)) {

        $stmt = $con->prepare("INSERT INTO items (Name ,Description  , Price , Country_Made , Status , Add_Date , Cat_ID , Member_ID, Approve)
                                        VALUES  ( :zname ,:zdes        ,:zprice, :zcountry    ,:zstatus , now() , :zcat ,:zmember ,1  ) ");

        $stmt->execute(array(
          'zname'   => $Name,
          'zdes'    => $Description,
          'zprice'  => $price,
          'zcountry' => $country,
          'zstatus' => $status,
          'zcat'    => $categories,
          'zmember' => $member
        ));


        if ($stmt->rowCount() > 0) {
          $theMsg = "<div class='alert alert-success container text-center'>" . ' Item Aded Successfully</div>';
          redirectHome($theMsg , 'back');
        } elseif ($stmt->rowCount() ==  0) {
          $theMsg = "<div class='alert alert-info  container text-center'>" . '  Error happened </div>';
          redirectHome($theMsg, 'back');
        }
      }
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Delete') { //Delete Data
    $Item_ID =  isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
    $check  = checkItem('Item_ID', 'items', $Item_ID);
    if ($check > 0) {
      $stat = $con->prepare("DELETE FROM items WHERE Item_ID = :zID");
      $stat->bindParam(":zID", $Item_ID);
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
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Approve') { //Approve Data
    $Item_ID =  isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
    $check  = checkItem('Item_ID', 'items', $Item_ID);
    if ($check > 0) {
      $stat = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
      $stat->execute(array($Item_ID));
      //header('Location: ' . $_SERVER['HTTP_REFERER']);
      echo '<h1 class="text-center">Approve Members</h1>
            <div class="container">';
      $theMsg = "<div class='alert alert-success container text-center pad'>" . ' Member Approved Successfully</div>';
      redirectHome($theMsg, 'back');
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>You can't Go to this page directly </div>";
      redirectHome($theMsg);
    }
    echo '</div>';
  }
  /*------------------------------------------------------------------------------------------------------------------------------------------- */
  include $tpl . 'footer.php';
} else {
  redirectHome('index.php');
  exit();
}

ob_end_flush();
