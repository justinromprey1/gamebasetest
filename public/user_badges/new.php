 <?php 
 	require_once('../../private/initialize.php');
  require_user_login();
 	if(is_post_request()){

    // Handle form values sent by new.php
      $user_badge = [];

      $current_user = find_user_by_username($_SESSION['user_login']) ?? '';
      $user_badge['user_id'] = $current_user['id'];
      
      $user_badge['badge_id'] = $_POST['badge_id'] ?? '';


    $result = insert_user_badge($user_badge);
    if($result === true){
      $new_id = mysqli_insert_id($db);

      $user_badge = find_user_badge_by_id($new_id);

      $successstring = "Submission Entered Successfully :)";
      $_SESSION['statusmsg'] = $successstring;

      redirect_to(url_for('/user_badges/show.php?id=' . $new_id));
    }else{
      $errors = $result;
    }
  }else{
    //display the blank form
  }
  

  $user_badge= [];
  $user_badge['time_complete'] = '';
  $user_badge['user_id'] = '';
  $user_badge['badge_id'] = '';

?>

<?php $page_title = 'Add Badge Earned'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to Gamebase</a>

  <div class="user badge new">
    <h1>Add Badge Earned</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('user_badges/new.php'); ?>" method="post">
      <dl>
        <dt>Badge</dt>
        <dd>
          <select name="badge_id">
            <?php
                $badge_set = find_all_badges();
                while($badge = mysqli_fetch_assoc($badge_set)){
                  echo "<option value=\"" . hsc($badge['id']) . "\"";
                  if($user_badge['badge_id'] == $badge['id']){
                    echo " selected";
                  }
                  $game = find_game_by_id($badge['game_id']);
                  echo ">" . hsc($game['title']) . " -- " . hsc($badge['title']) . "</option>";
                }
                mysqli_free_result($badge_set);
            ?>
          </select>
        </dd>
      </dl>
      
      <div id="operations">
        <input type="submit" value="Add Badge Earned" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
