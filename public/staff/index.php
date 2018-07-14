<?php 
	require_once('../../private/initialize.php'); 
  //unset($_SESSION['admin_id']);
  require_login();
	$page_title = 'Staff Menu';
	include(SHARED_PATH . '/staff_header.php'); 
?>

  	<div id = "content">
  		<div id="main-menu">
  			<h2>Main Menu</h2>
  			<ul>
          <li><a href="<?php echo url_for('staff/admins/index.php'); ?>">Admins</a></li>
          <li><a href="<?php echo url_for('staff/users/index.php'); ?>">Users</a></li>
          <li><a href="<?php echo url_for('staff/games/index.php'); ?>">Games</a></li>
          <li><a href="<?php echo url_for('staff/badges/index.php'); ?>">Badges</a></li>
  			</ul>
		</div>
  	</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>  	
