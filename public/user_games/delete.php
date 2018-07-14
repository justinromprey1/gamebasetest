<?php

require_once('../../private/initialize.php');
require_user_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('viewgamebase.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_user_game($id);
    if($result === true){

      $successstring = "Game Submission Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('viewgamebase.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $user_game = find_user_game_by_id($id);
?>

<?php $page_title = 'Delete Game Submission'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>

  <div class="user_games delete">
    <h1>Delete Game Submission</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this Game Submission?</p>
    <p class="item"><?php $game = find_game_by_id($user_game['game_id']);
echo hsc($game['title']); echo "<br>Time Submitted: "; echo hsc($user_game['time_input']); ?></p>

    <form action="<?php echo url_for('user_games/delete.php?id=' . hsc(urle($user_game['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Game Submission" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
