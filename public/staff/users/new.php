 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
 	if(is_post_request()){

    // Handle form values sent by new.php
      $user = [];
      $user['first_name'] = $_POST['first_name'] ?? '';
      $user['last_name'] = $_POST['last_name'] ?? '';
      $user['email'] = $_POST['email'] ?? '';
      $user['username'] = $_POST['username'] ?? '';
      $user['hashed_password'] = $_POST['hashed_password'] ?? '';
      $user['confirm_password'] = $_POST['confirm_password'] ?? '';
      $user['exp'] = '1';
      $user['lev'] = '1';

    //insert admin into database
    $result = insert_user($user);
    if($result === true){
      //redirect to show page for newly created admin
      $new_id = mysqli_insert_id($db);

      $successstring = "User Created Successfully :)";
      $_SESSION['statusmsg'] = $successstring;

      redirect_to(url_for('/staff/users/show.php?id=' . $new_id));
    }else{
      $errors = $result;
    }
  }else{
    //display the blank form
  }
  //get the number of subjects, called for the choosing of position
    $user_set = find_all_users();
    $user_count = mysqli_num_rows($user_set) + 1;
    mysqli_free_result($user_set);

  $user= [];

?>

<?php $page_title = 'Create User'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="user new">
    <h1>Create User</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('staff/users/new.php'); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="" /></dd>
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
        <input type="submit" value="Create User" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
