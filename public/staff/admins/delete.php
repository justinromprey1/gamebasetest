<?php

require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_admin($id);
    if($result === true){

      $successstring = "Admin Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('/staff/admins/index.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $admin = find_admin_by_id($id);
?>

<?php $page_title = 'Delete Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin delete">
    <h1>Delete Admin</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this admin?</p>
    <p class="item"><?php echo hsc($admin['first_name'] . " " . $admin['last_name']); ?></p>

    <form action="<?php echo url_for('/staff/admins/delete.php?id=' . hsc(urle($admin['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Admin" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
