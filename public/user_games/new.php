 <?php 
 	require_once('../../private/initialize.php');
  require_user_login();
 	if(is_post_request()){

    // Handle form values sent by new.php
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


    $result = insert_user_game($user_game);
    if($result === true){
      //redirect to show page for newly created admin
      $new_id = mysqli_insert_id($db);

      $successstring = "Submission Entered Successfully :)";
      $_SESSION['statusmsg'] = $successstring;

      redirect_to(url_for('/user_games/show.php?id=' . $new_id));
    }else{
      $errors = $result;
    }
  }else{
    //display the blank form
  }
  

  $user_game= [];
  $user_game['time_input'] = '';
  $user_game['completed'] = '';
  $user_game['time_complete'] = '';
  $user_game['format'] = '';
  $user_game['status'] = '';
  $user_game['user_rating'] = '';
  $user_game['game_id'] = '';

?>

<?php $page_title = 'Add Game Played'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to Gamebase</a>

  <div class="user game new">
    <h1>Add Game Played</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('user_games/new.php'); ?>" method="post">
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
        <input type="submit" value="Add Game Played" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
