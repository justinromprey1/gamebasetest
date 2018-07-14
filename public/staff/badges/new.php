 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
 	if(is_post_request()){

    // Handle form values sent by new.php
      $badge = [];
      $badge['title'] = $_POST['title'] ?? '';
      $badge['req'] = $_POST['req'] ?? '';
      $badge['diff'] = $_POST['diff'] ?? '';
      $badge['game_id'] = $_POST['game_id'] ?? '';

    //insert admin into database
    $result = insert_badge($badge);
    if($result === true){
      //redirect to show page for newly created admin
      $new_id = mysqli_insert_id($db);

      //get badge, create new column in users for that badge.
      $result2 = create_user_badge_check_query($new_id);


      $successstring = "Badge Created Successfully :)";
      $_SESSION['statusmsg'] = $successstring;

      redirect_to(url_for('/staff/badges/show.php?id=' . $new_id));
    }else{
      $errors = $result;
    }
  }else{
    //display the blank form
  }
  //get the number of subjects, called for the choosing of position
    $badge_set = find_all_badges();
    $badge_count = mysqli_num_rows($badge_set) + 1;
    mysqli_free_result($badge_set);

  $badge= [];
  $badge['title'] = '';
  $badge['req'] = '';
  $badge['diff'] = '';
  $badge['game_id'] = '';
?>

<?php $page_title = 'Create Badge'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/badges/index.php'); ?>">&laquo; Back to List</a>

  <div class="badge new">
    <h1>Create Badge</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('staff/badges/new.php'); ?>" method="post">
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
                  if($badge['game_id'] == $game['id']){
                    echo " selected";
                  }
                  echo ">" . hsc($game['title']) . "</option>";
                }
                mysqli_free_result($game_set);
            ?>
          </select>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Badge" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
