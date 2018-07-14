<?php require_once('../../../private/initialize.php'); ?>

<?php
  require_login();
  $admin_set = find_all_admins();

?>

<?php $page_title = 'Admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="admins listing">
    <h1>Admins</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/admins/new.php'); ?>">Create New Admin</a>
      	<br>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
  	    <th>Email</th>
        <th>Username</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
        <tr>
          <td><?php echo hsc($admin['id']); ?></td>
          <td><?php echo hsc($admin['first_name']); ?></td>
          <td><?php echo hsc($admin['last_name']); ?></td>
    	    <td><?php echo hsc($admin['email']); ?></td>
          <td><?php echo hsc($admin['username']); ?></td>
          <td><a class="action" href="<?php echo url_for('staff/admins/show.php?id='. hsc(urle($admin['id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('staff/admins/edit.php?id='. hsc(urle($admin['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('staff/admins/delete.php?id='. hsc(urle($admin['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php 
      mysqli_free_result($admin_set);
    ?>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
