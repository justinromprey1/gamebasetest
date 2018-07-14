 <?php 
 	require_once('../../private/initialize.php');
  require_user_login();
  //confirm a selection to edit. if false, redirect back.
  if(!isset($_GET['id'])){
    redirect_to(url_for('viewgamebase.php'));
  }
  //store id
  $id = $_GET['id'];

  

  //confirm post request
 	if(is_post_request()){

    $user_game = [];
    $user_game['time_input'] = $_POST['time_input'] ?? '';
    $user_game['completed'] = $_POST['completed'] ?? '';
    $user_game['time_complete'] = $_POST['time_complete'] ?? '';
    $user_game['format'] = $_POST['format'] ?? '';
    $user_game['status'] = $_POST['status'] ?? '';
    $user_game['user_rating'] = $_POST['user_rating'] ?? '';

    $current_user = find_user_by_username($_SESSION['user_login']) ?? '';
    $user_game['user_id'] = $current_user['id'];
      
    $user_game['game_id'] = $_POST['game_id'] ?? '';


    $result = update_user_game($user_game);
    if($result === true){
        $successstring = "Game Submission Edited Successfully :)";
        $_SESSION['statusmsg'] = $successstring;

        redirect_to(url_for('/user_games/show.php?id=' . $id));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

  }else{
    $user_game = find_user_game_by_id($id);
  }

?>

<?php $page_title = 'Edit User Game'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>

  <div class="user_game edit">
    <h1>Edit Game Submission</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('user_games/edit.php'); ?>" method="post">
      <dl>
        <dt>Game</dt>
        <dd>
          <select name="game_id">
            <?php
                $game_set = find_all_games();
                while($game = mysqli_fetch_assoc($game_set)){
                  echo "<option value=\"" . hsc($game['id']) . "\"";
                  if($user_game['game_id'] == $game['id']){
                    echo " selected";
                  }
                  echo ">" . hsc($game['title']) . "</option>";
                }
                mysqli_free_result($game_set);
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Completed</dt>
        <dd>
          <input type="hidden" name="completed" value="0" />
          <input type="checkbox" name="completed" value="1" />
        </dd>
      </dl>
      <dl>
      <dl>
        <dt>Format</dt>
        <dd>
          <select name="format">
            <option value="Physical"<?php if($user_game['format'] == "Physical") { echo " selected"; } ?>>Physical</option>
            <option value="Digital"<?php if($user_game['format'] == "Digital") { echo " selected"; } ?>>Digital</option>
          </select>
        </dd>
      </dl>
      <br>
      <dl>
        <dt>Status</dt>
        <dd>
          <select name="status">
            <option value="Own"<?php if($user_game['format'] == "Own") { echo " selected"; } ?>>Own</option>
            <option value="Want to Buy"<?php if($user_game['format'] == "Want to Buy") { echo " selected"; } ?>>Want to Buy</option>
            <option value="Rented/Borrowed"<?php if($user_game['format'] == "Rented/Borrowed") { echo " selected"; } ?>>Rented/Borrowed</option>
            <option value="Don't Want"<?php if($user_game['format'] == "Don't Want") { echo " selected"; } ?>>Don't Want</option>
          </select>
        </dd>
      </dl>
      <br>
      <dl>
        <dt>Your Rating</dt>
        <dd><input type="number" name="user_rating" value="" min="0" max="10"/></dd>
        <dd>Rating is from 0 to 10.
      </dl>
      <br>
      <div id="operations">
        <input type="submit" value="Edit Game Submission" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
