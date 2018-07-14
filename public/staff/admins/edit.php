 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
  //confirm a selection to edit. if false, redirect back.
  if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/admins/index.php'));
  }
  //store id
  $id = $_GET['id'];

  

  //confirm post request
 	if(is_post_request()){

    // Handle form values sent by new.php

      $admin = [];
      $admin['id'] = $id;
      $admin['first_name'] = $_POST['first_name'] ?? '';
      $admin['last_name'] = $_POST['last_name'] ?? '';
      $admin['email'] = $_POST['email'] ?? '';
      $admin['username'] = $_POST['username'] ?? '';
      $admin['hashed_password'] = $_POST['hashed_password'] ?? '';
      $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

    $result = update_admin($admin);
    if($result === true){
        $successstring = "Admin Edited Successfully :)";
        $_SESSION['statusmsg'] = $successstring;

        redirect_to(url_for('/staff/admins/show.php?id=' . $id));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

  }else{
    $admin = find_admin_by_id($id);
  }

  //get the number of subjects, called for the choosing of position
    $admin_set = find_all_admins();
    $admin_count = mysqli_num_rows($admin_set);
    mysqli_free_result($admin_set);
?>

<?php $page_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin edit">
    <h1>Edit Admin</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/admins/edit.php?id='. hsc(urle($id))); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name" value="<?php echo $admin['first_name']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name" value="<?php echo $admin['last_name']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="<?php echo $admin['email']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo $admin['username']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Password</dt>
        <dd><input type="password" name="hashed_password" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Confirm Password</dt>
        <dd><input type="password" name="confirm_password" value="" /></dd>
      </dl>
      <p>
        Passwords need to be 12 characters, and include at least one upper, one lower, a number, and a symbol.
      </p>
      <div id="operations">
        <input type="submit" value="Edit Admin" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
