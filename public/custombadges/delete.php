<?php

require_once('../../private/initialize.php');
require_user_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('viewgamebase.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_c_badge($id);
    if($result === true){

      $successstring = "Custom Badge Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('viewgamebase.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $c_badge = find_c_badges_by_id($id);
?>

<?php $page_title = 'Delete Custom Badge'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>

  <div class="custom badge delete">
    <h1>Delete Custom Badge</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this Custom Badge?</p>
    <p class="item"><?php echo hsc($c_badge['title']); ?></p>

    <form action="<?php echo url_for('custombadges/delete.php?id=' . hsc(urle($c_badge['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Custom Badge" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
