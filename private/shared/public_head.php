<?php 
    if(!isset($page_title)){
      $page_title = 'Public Area';
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
  		<h1>Your GameBase</h1>
  	</header>

  	<navigation>
  		<ul>
        <li>User: <?php echo $_SESSION['user_login'] ?? '';?></li>
  			<li><a href="<?php echo url_for('index.php'); ?>">Home</a></li>
        <li><a href="<?php echo url_for('viewgamebase.php'); ?>">Menu</a></li>
        <li><a href="<?php echo url_for('userlogout.php'); ?>">Log Out</a></li>
  		</ul>
  	</navigation>