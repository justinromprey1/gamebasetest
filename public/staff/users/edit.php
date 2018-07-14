 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
  //confirm a selection to edit. if false, redirect back.
  if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/users/index.php'));
  }
  //store id
  $id = $_GET['id'];

  

  //confirm post request
 	if(is_post_request()){

    // Handle form values sent by new.php

      $user = [];
      $user['id'] = $id;
      $user['first_name'] = $_POST['first_name'] ?? '';
      $user['last_name'] = $_POST['last_name'] ?? '';
      $user['email'] = $_POST['email'] ?? '';
      $user['username'] = $_POST['username'] ?? '';
      $user['hashed_password'] = $_POST['hashed_password'] ?? '';
      $user['confirm_password'] = $_POST['confirm_password'] ?? '';

    $result = update_user($user);
    if($result === true){
        $successstring = "User Edited Successfully :)";
        $_SESSION['statusmsg'] = $successstring;

        redirect_to(url_for('/staff/users/show.php?id=' . $id));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

  }else{
    $user = find_user_by_id($id);
  }

  //get the number of subjects, called for the choosing of position
    $user_set = find_all_users();
    $user_count = mysqli_num_rows($user_set);
    mysqli_free_result($user_set);
?>

<?php $page_title = 'Edit User'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="user edit">
    <h1>Edit User</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/users/edit.php?id='. hsc(urle($id))); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="<?php echo $user['email']; ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo $user['username']; ?>" /></dd>
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
        <input type="submit" value="Edit User" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
