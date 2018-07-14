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

    // Handle form values sent by new.php
    $c_badge = [];
    $c_badge['title'] = $_POST['title'] ?? '';
    $c_badge['req'] = $_POST['req'] ?? '';
    $c_badge['diff'] = $_POST['diff'] ?? '';
    $c_badge['game_id'] = $_POST['game_id'] ?? '';

    $current_user = find_user_by_username($_SESSION['user_login']) ?? '';
    $c_badge['user_id'] = $current_user['id'];
      
    $c_badge['completed'] = $_POST['completed'] ?? '';


    $result = update_c_badge($c_badge);
    if($result === true){
        $successstring = "Custom Badge Edited Successfully :)";
        $_SESSION['statusmsg'] = $successstring;

        redirect_to(url_for('/custombadges/show.php?id=' . $id));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

  }else{
    $c_badge = find_c_badges_by_id($id);
  }

    $c_badge_set = find_all_badges();
    $c_badges_count = mysqli_num_rows($c_badge_set);
    mysqli_free_result($c_badge_set);
?>

<?php $page_title = 'Edit Custom Badge'; ?>
<?php include(SHARED_PATH . '/public_head.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('viewgamebase.php'); ?>">&laquo; Back to List</a>

  <div class="badge edit">
    <h1>Edit Badge</h1>

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
        <input type="submit" value="Edit Custom Badge" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
