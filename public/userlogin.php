<?php
require_once('../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  
  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    // Using one variable ensures that msg is the same
    $login_failure_msg = "Log in was unsuccessful.";

    $user = find_user_by_username($username);
    if($user) {

      if(password_verify($password, $user['hashed_password'])) {
        // password matches
        log_in_user($user);
        redirect_to(url_for('/index.php'));
      } else {
        // username found, but password does not match
        $errors[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors[] = $login_failure_msg;
    }

  }

}

?>

<?php $page_title = 'Log in'; ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Home</a>

  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>
  <?php if(isset($_SESSION['user_id'])){ echo "You are already logged in, you dingus!"; }?>

  <form action="userlogin.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo hsc($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
