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

   echo 'welcome';
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Edit') { //Edit Members 

    
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Update') { // Update Data

   
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Add') { //add members
   
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Insert') { //insert Data

    
  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Delete') { //Delete Data


  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ elseif ($do == 'Activate') { //Activate Data


  }
  /*-------------------------------------------------------------------------------------------------------------------------------------------- */ 
  include $tpl . 'footer.php';
} else {
  redirectHome('index.php');
  exit();
}

ob_end_flush();