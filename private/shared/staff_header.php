<?php 
    if(!isset($page_title)){
      $page_title = 'Staff Area';
    }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>GameBase - <?php echo hsc($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for ('/stylesheets/staff.css'); ?>" />
  </head>

  <body>
  	<header>
  		<h1>GameBase Staff Area</h1>
  	</header>

  	<navigation>
  		<ul>
        <li>User: <?php echo $_SESSION['username'] ?? '';?></li>
        <li><a href="<?php echo url_for('index.php'); ?>">Home Page</a></li>
  			<li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
        <li><a href="<?php echo url_for('/staff/logout.php'); ?>">Log Out</a></li>
  		</ul>
  	</navigation>