<?php require_once('../../../private/initialize.php'); ?>

<?php 
  require_login();
	//checks if the page id given value exists, if so it sets the variable $id to it
	//else sets $id to 1
	$id = $_GET['id'] ?? 1;

	$admin = find_admin_by_id($id);
?>
  <div id="message">
	   <li><?php echo $_SESSION['statusmsg'] ?? '';?></li>
     <?php unset($_SESSION['statusmsg']); ?>
  </div>

<h1>Admin : <?php echo hsc($admin['first_name'] . " " . $admin['last_name']); ?></h1>

<div class="attributes">
  <dl>
    <dt>Name</dt>
    <dd><?php echo hsc($admin['first_name'] . " " . $admin['last_name']); ?></dd>
  </dl>
  <dl>
    <dt>Email</dt>
    <dd><?php echo hsc($admin['email']); ?></dd>
  </dl>
  <dl>
    <dt>Email</dt>
    <dd><?php echo hsc($admin['username']); ?></dd>
  </dl>
</div>

<br>

<a href="<?php echo url_for('staff/admins/index.php'); ?>"> << Back to List</a>


