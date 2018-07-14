<?php

require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/users/index.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_user($id);
    if($result === true){

      $successstring = "User Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('/staff/users/index.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $user = find_user_by_id($id);
?>

<?php $page_title = 'Delete User'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="user delete">
    <h1>Delete User</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this user?</p>
    <p class="item"><?php echo hsc($user['first_name'] . " " . $user['last_name']); ?></p>

    <form action="<?php echo url_for('/staff/users/delete.php?id=' . hsc(urle($user['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete User" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
