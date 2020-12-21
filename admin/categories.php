<?php

/** Manage categories Add delete or edit  */
ob_start();
session_start();
$pageTitle = 'categories';

if (isset($_SESSION['Username'])) {

  include 'init.php';
  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  /*-------------------------------------------------------------------------------------------------------------------------------------------- */
  if ($do == 'Manage') { // Manage categories 

    $sort = 'Desc';
    $sort_array = array('ASC', 'DESC');
    if (isset($_GET['sort']) && in_array($_GET['sort'],  $sort_array)) {

      $sort = $_GET['sort'];
    }

    $stmt = $con->prepare("SELECT * FROM categories ORDER BY ordering $sort  ");
    $stmt->execute();
    $cats = $stmt->fetchAll();

    $count =  count_rows('categories');

    if ($count > 0) {
?>
      <h1 class="text-center">Manage categories</h1>
      <div class="container">

        <div class="panel-heading">
          <a href="?sort=DESC" class="  right <?php if ($sort == 'DESC') {
                                                echo 'active';
                                              } ?>">Desc</a>
          <label class="right">|</label>
          <a href="?sort=ASC" class=" right <?php if ($sort == 'ASC') {
                                              echo 'active';
                                            } ?>">Asc</a>
          <label class="right" style="margin-top: 1px;">Ordering :</label>
        </div>

        <div class="panel-body">
          <?php

          echo "<table class='table center  table-striped table-bordered'>";
          echo "<th class='center'>ID</th>";
          echo "<th class='center'>Name</th>";
          echo "<th class='center'>Description</th>";
          //echo "<th class='center'>Ordering</th>";
          echo "<th class='center'>Visibility</th>";
          echo "<th class='center'>Comment</th>";
          echo "<th class='center'>Ads</th>";
          echo "<th class='center'>Control</th>";
          foreach ($cats as $cat) {
            echo "<tr>";
            echo "<td>" . $cat['ID']          . "</td>";
            echo "<td class='text-danger'><b>" . $cat['Name']          . "</b></td>";
            echo "<td style='width: 35%'>" . $cat['Description']   . "</td>";
            //echo "<td>" . $cat['Ordering']      . "</td>";
            echo "<td>";
            if ($cat['Visibility'] == 1) {
              echo 'Hidden';
            } else {
              echo 'visible';
            }
            echo "</td>";
            echo "<td>";
            if ($cat['Allow_Comment'] == 1) {
              echo 'Comment disable';
            } else {
              echo 'Comment enable';
            }
            echo "</td>";
            echo "<td>";
            if ($cat['Allow_Ads'] == 1) {
              echo 'Ads disable';
            } else {
              echo 'Ads enable';
            }
            echo "</td>";
            echo "<td>
                        <a href='categories.php?do=Edit&ID=" . $cat['ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                        <a href='categories.php?do=Delete&ID=" . $cat['ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
            echo "</td>";
            echo "</tr>";
          }
          echo "</table>";
          ?>
          <a href="categories.php?do=Add" class="btn btn-primary "> <i class="fa fa-plus">Add New categories</i> </a>
        </div>

      </div>
    <?php
    } else {
      $theMsg = "<div class='alert alert-info  container text-center'>There is no data </div>";
      echo ($theMsg);
      echo '<div class="container"><a href="categories.php?do=Add" class="btn btn-primary "> <i class="fa fa-plus">Add New categories</i> </a></div>';
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Edit') { //Edit categories 

    $ID =  isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

    $stmt->execute(array($ID));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();


    if ($count > 0) { ?>
      <h1 class="text-center">Edit categories</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">

          <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">

          <div class="form-group form-group-md ">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="name" class="form-control " autocomplete="off" required="required" placeholder="Name of categories" value="<?php echo $row['Name']; ?>">
            </div>
          </div>


          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="Description" class="form-control" placeholder="Description of categories" value="<?php echo $row['Description']; ?>">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="Ordering" class="form-control" placeholder="Number to arrange Ordering" value="<?php echo $row['Ordering']; ?>">
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Visbile</label>
            <div class="col-sm-10 col-md-4">
              <div>
                <input id="Vis-yes" type="radio" name="Visbillity" value="0" <?php if ($row['Visibility'] == 0) echo 'checked' ?>>
                <label for="Vis-yes">Yes </lable>
              </div>
              <div>
                <input id="Vis-no" type="radio" name="Visbillity" value="1" <?php if ($row['Visibility'] == 1) echo 'checked' ?>>
                <label for="Vis-no">NO </lable>
              </div>
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Allow Commenting</label>
            <div class="col-sm-10 col-md-4">
              <div>
                <input id="com-yes" type="radio" name="Commenting" value="0" <?php if ($row['Visibility'] == 0) echo 'checked' ?>>
                <label for="com-yes">Yes </lable>
              </div>
              <div>
                <input id="com-no" type="radio" name="Commenting" value="1" <?php if ($row['Visibility'] == 1) echo 'checked' ?>>
                <label for="com-no">NO </lable>
              </div>
            </div>
          </div>

          <div class="form-group  form-group-md">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-4">
              <div>
                <input id="Ads-yes" type="radio" name="Ads" value="0" <?php if ($row['Visibility'] == 0) echo 'checked' ?>>
                <label for="Ads-yes">Yes </lable>
              </div>
              <div>
                <input id="Ads-no" type="radio" name="Ads" value="1" <?php if ($row['Visibility'] == 1) echo 'checked' ?>>
                <label for="Ads-no">NO </lable>
              </div>
            </div>
          </div>


          <div class="form-group  form-group-md">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" value="Edit Member" class="btn btn-primary btn-lg" />
            </div>
          </div>

        </form>
      </div>

    <?php } else {
      $theMsg = "<div class='alert alert-info  container text-center'>There is no such ID </div>";
      redirectHome($theMsg);
    }
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Update') { // Update Data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      echo ' <h1 class="text-center">Update Members</h1>';
      $id           = $_POST['ID'];
      $Name         = $_POST['name'];
      $Description  = $_POST['Description'];
      $Ordering     = $_POST['Ordering'];
      $Visbile      = $_POST['Visbillity'];
      $Commenting   = $_POST['Commenting'];
      $Ads          = $_POST['Ads'];

      $formErrors = array();

      if (empty($Name)) {
        $formErrors[] = 'Name Cant Be Less Than <strong>3 Characters</strong>';
      }

      foreach ($formErrors as $error) {
        echo '<div class="alert alert-danger text-center container">' . $error . '</div>';
      }


      if (empty($formErrors)) {
        $stmt = $con->prepare("UPDATE categories SET 
        Name = ?, Description = ? , Ordering = ? , Visibility = ? , Allow_Comment = ? , Allow_Ads =? WHERE ID = ?");

        $stmt->execute(array($Name, $Description, $Ordering, $Visbile, $Commenting, $Ads, $id));


        if ($stmt->rowCount() > 0) {
          $theMsg = "<div class='alert alert-success container text-center'>" . ' categories Updated</div>';
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
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Add') { //add categories 
    ?>
    <h1 class="text-center">Add New categories</h1>
    <div class="container">
      <form class="form-horizontal" action="?do=Insert" method="POST">

        <div class="form-group form-group-md ">
          <label class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="name" class="form-control " autocomplete="off" required="required" placeholder="Name of categories">
          </div>
        </div>


        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="Description" class="form-control" placeholder="Description of categories">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Ordering</label>
          <div class="col-sm-10 col-md-4">
            <input type="text" name="Ordering" class="form-control" placeholder="Number to arrange Ordering">
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Visbile</label>
          <div class="col-sm-10 col-md-4">
            <div>
              <input id="Vis-yes" type="radio" name="Visbillity" value="0" checked>
              <label for="Vis-yes">Yes </lable>
            </div>
            <div>
              <input id="Vis-no" type="radio" name="Visbillity" value="1">
              <label for="Vis-no">NO </lable>
            </div>
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Allow Commenting</label>
          <div class="col-sm-10 col-md-4">
            <div>
              <input id="com-yes" type="radio" name="Commenting" value="0" checked>
              <label for="com-yes">Yes </lable>
            </div>
            <div>
              <input id="com-no" type="radio" name="Commenting" value="1">
              <label for="com-no">NO </lable>
            </div>
          </div>
        </div>

        <div class="form-group  form-group-md">
          <label class="col-sm-2 control-label">Allow Ads</label>
          <div class="col-sm-10 col-md-4">
            <div>
              <input id="Ads-yes" type="radio" name="Ads" value="0" checked>
              <label for="Ads-yes">Yes </lable>
            </div>
            <div>
              <input id="Ads-no" type="radio" name="Ads" value="1">
              <label for="Ads-no">NO </lable>
            </div>
          </div>
        </div>


        <div class="form-group  form-group-md">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
          </div>
        </div>

      </form>
    </div>
<?php }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Insert') { //insert Data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      echo ' <h1 class="text-center">Added categories</h1>';
      $name            = $_POST['name'];
      $Ordering        = $_POST['Ordering'];
      $Description     = $_POST['Description'];
      $Visbillity      = $_POST['Visbillity'];
      $Commenting      = $_POST['Commenting'];
      $Ads             = $_POST['Ads'];

      $formErrors = array();

      if (empty($name)) {
        $formErrors[] = 'name Cant Be <strong>Empty</strong>';
      }

      foreach ($formErrors as $error) {
        $theMsg = "<div class='alert alert-danger container text-center pad'>" . $error . ' </div>';
        redirectHome($theMsg, 'back');
      }
      if (empty($formErrors)) {

        $check = checkItem('name', "categories", $name);
        if ($check == 1) {
          $theMsg = "<div class='alert alert-danger container text-center pad'>" . ' This categories is exist</div>';
          redirectHome($theMsg, 'back');
        } else {
          $stmt = $con->prepare("INSERT INTO categories (Name ,Description ,Ordering , Visibility , Allow_Comment , Allow_Ads)
                                  VALUES  ( :zName , :zDescription, :zOrdering , :zVisibility , :zAllow_Comment ,:zAllow_Ads ) ");

          $stmt->execute(array(
            'zName'        => $name,
            'zDescription' => $Description,
            'zOrdering'    => $Ordering,
            'zVisibility'  => $Visbillity,
            'zAllow_Comment' => $Commenting,
            'zAllow_Ads'   => $Ads
          ));


          if ($stmt->rowCount() > 0) {
            $theMsg = "<div class='alert alert-success container text-center'>" . ' categories Aded Successfully</div>';
            redirectHome($theMsg);
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
    $ID =  isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
    $check  = checkItem('ID', 'categories', $ID);
    if ($check > 0) {
      $stat = $con->prepare("DELETE FROM categories WHERE ID = :zcat");
      $stat->bindParam(":zcat", $ID);
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
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */
  include $tpl . 'footer.php';
} else {
  redirectHome('index.php');
  exit();
}

ob_end_flush();
