<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title><?php gettitle();  ?></title>
  <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
  <link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
  <link rel="stylesheet" href="<?php echo $css ?>frontend.css" />

</head>


<body id="body">

  <div class="upper-bar container">
    <?php
    if (isset($_SESSION['user'])) { ?>

      <?php
      if (empty(getimage($_SESSION['uid']))) {
        echo "<img class=\"my-image img-thumbnail img-circle\" src='admin/Uploads/avatars/avatar.png ' alt='' />"; 
      } else {
        echo "<img class=\"my-image img-thumbnail img-circle\" src='admin/Uploads/avatars/"; echo getimage($_SESSION['uid']); echo" ' alt='' />";
      }
      ?>
      
      <div class="btn-group my-info">
        <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <?php echo $sessionUser  ?>
          <span class="caret"></span>
        </span>
        <ul class="dropdown-menu">
          <li><a href="profile.php">My Profile</a></li>
          <li><a href="newad.php">New Item</a></li>
          <li><a href="profile.php#my-ads">My Items</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>

    <?php

    } else {
    ?>
      <a href="login.php">
        <span class="login">Login/Signup</span>
      </a>
    <?php } ?>
  </div>

  <nav class="navbar navbar-inverse">
    <div class="navbar-header">
      <span style="font-size:30px;cursor:pointer" class="navbar-brand" onclick="openNav()">&#9776; </span>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <input type="text" placeholder="What are you looking for?">
    <i class="fa fa-search "></i>
  </nav>


  <div class="nav2">
    <ul>
      <li class="Cats">
        <?php foreach (get_cat() as $cat) {
          echo '<li> <a href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . str_replace(' ', '-', $cat['Name']) . '">'  . $cat['Name'] . '</a></li>';
        } ?>

      </li>
    </ul>
  </div>


  <div id="mySidenav" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="drop1">
      <a onclick="block1()">All Categories</a>
    </div>

    <div class="menu1" id="menu1">
      <?php foreach (get_cat() as $cat) {
        echo '<div> <a href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . str_replace(' ', '-', $cat['Name']) . '">'  . $cat['Name'] . '</a></div>';
      } ?>
    </div>

    <dl class="accordion" data-accordion="dci02w-accordion" data-multi-expand="true" data-allow-all-closed="true" role="tablist">
      <dt class="font-normal"><a class="level2">Home</a></dt>
      <dt class="font-normal"><a class="level2">Track Orders</a></dt>
      <dt class="font-normal"><a class="level2">My Account</a></dt>
      <dt class="font-normal"><a class="level2">Account Summary</a></dt>
      <dt class="font-normal"><a class="level2">Customer Service</a></dt>
      <dt class="font-normal"><a id="appboy-newsfeed"> Newsfeed <span id="appboy-newsfeed-counter" style="display: none;"></span></a></dt>
    </dl>


    <li class="accordion-item is-active" data-accordion-item="">
      <div class="accordion-content" data-tab-content="" style="display: block;" role="tabpanel" aria-labelledby="4pn7s6-accordion-label" aria-hidden="false" id="4pn7s6-accordion">
        <div class=" after">
          <ul class="no-bullet clearfix">
            <li class="refinement" data-refinement="New">
              <label class="sk-clr2 sk-clr2-eff ">
                New
                <span class="txtcolor-gray">(<span>1103</span>)</span>

              </label>
            </li>
          </ul>
        </div>
      </div>
    </li>

  </div>