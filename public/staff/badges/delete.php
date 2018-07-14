<?php

require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/badges/index.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_badge($id);
    if($result === true){

      $successstring = "Badge Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('/staff/badges/index.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $badge = find_badges_by_id($id);
?>

<?php $page_title = 'Delete Badge'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/badges/index.php'); ?>">&laquo; Back to List</a>

  <div class="badge delete">
    <h1>Delete Badge</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this Badge?</p>
    <p class="item"><?php echo hsc($badge['title']); ?></p>

    <form action="<?php echo url_for('/staff/badges/delete.php?id=' . hsc(urle($badge['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Badge" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
