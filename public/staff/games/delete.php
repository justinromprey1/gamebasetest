<?php

require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/games/index.php'));
}
$id = $_GET['id'];


if(is_post_request()) {

    $result = delete_game($id);
    if($result === true){

      $successstring = "Game Deleted Successfully :)";
      $_SESSION['statusmsg'] = $successstring;
      redirect_to(url_for('/staff/games/index.php'));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

}else{
  //display blank
}
  $game = find_game_by_id($id);
?>

<?php $page_title = 'Delete Game'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/games/index.php'); ?>">&laquo; Back to List</a>

  <div class="game delete">
    <h1>Delete Game</h1>
  
  <?php echo display_errors($errors); ?>

    <p>Are you sure you want to delete this Game?</p>
    <p class="item"><?php echo hsc($game['title']); ?></p>

    <form action="<?php echo url_for('/staff/games/delete.php?id=' . hsc(urle($game['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Game" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
