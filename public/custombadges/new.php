 <?php 
 	require_once('../../private/initialize.php');
  require_user_login();
 	if(is_post_request()){

    // Handle form values sent by new.php
      $c_badge = [];
      $c_badge['title'] = $_POST['title'] ?? '';
      $c_badge['req'] = $_POST['req'] ?? '';
      $c_badge['diff'] = $_POST['diff'] ?? '';
      $c_badge['game_id'] = $_POST['game_id'] ?? '';

      $current_user = find_user_by_username($_SESSION['user_login']) ?? '';
      $c_badge['user_id'] = $current_user['id'];
      
      $c_badge['completed'] = $_POST['completed'] ?? '';

    //insert admin into database
    $result = insert_c_badge($c_badge);
    if($result === true){
      //redirect to show page for newly created admin
      $new_id = mysqli_insert_id($db);

      $successstring = "Custom Badge Created Successfully :)";
      $_SESSION['statusmsg'] = $successstring;

      redirect_to(url_for('/custombadges/show.php?id=' . $new_id));
    }else{
      $errors = $result;
    }
  }else{
    //display the blank form
  }
  //get the number of subjects, called for the choosing of position
    $c_badge_set = find_all_c_badges();
    $c_badge_count = mysqli_num_rows($c_badge_set) + 1;
    mysqli_free_result($c_badge_set);

  $c_badge= [];
  $c_badge['title'] = '';
  $c_badge['req'] = '';
  $c_badge['diff'] = '';
  $c_badge['game_id'] = '';
?>

<?php $page_title = 'Create Custom Badge'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to Gamebase</a>

  <div class="custom badge new">
    <h1>Create Custom Badge</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('custombadges/new.php'); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Requirement</dt>
        <dd><input type="text" name="req" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Difficulty</dt>
        <dd><input type="number" name="diff" value="" min="1" max="100" /> Must be From 1 to 100</dd>
      </dl>
      <br>
      <dl>
        <dt>Game</dt>
        <dd>
          <select name="game_id">
            <?php
                $game_set = find_all_games();
                while($game = mysqli_fetch_assoc($game_set)){
                  echo "<option value=\"" . hsc($game['id']) . "\"";
                  if($c_badge['game_id'] == $game['id']){
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
      <div id="operations">
        <input type="submit" value="Create Custom Badge" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
