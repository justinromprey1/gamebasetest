<?php

require_once('../../private/initialize.php');
require_user_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('viewgamebase.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_user_badge($id);
    if($result === true){

      $successstring = "Badge Earning Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('viewgamebase.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $user_badge = find_user_badge_by_id($id);
?>

<?php $page_title = 'Delete Badge Earning Submission'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>

  <div class="user_badges delete">
    <h1>Delete Badge Earning Submission</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this Badge Earning Submission?</p>
    <p class="item"><?php $badge = find_badges_by_id($user_badge['badge_id']); 
    $game = find_game_by_id($badge['game_id']);
    echo hsc($game['title']) . " -- " . hsc($badge['title']) . "<br>Time Earned: " . hsc($user_badge['time_complete']); ?></p>

    <form action="<?php echo url_for('user_badges/delete.php?id=' . hsc(urle($user_badge['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Badge Earned" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
