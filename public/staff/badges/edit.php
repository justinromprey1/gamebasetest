 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
  //confirm a selection to edit. if false, redirect back.
  if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/badges/index.php'));
  }
  //store id
  $id = $_GET['id'];

  

  //confirm post request
 	if(is_post_request()){

    // Handle form values sent by new.php

      $badge = [];
      $badge['id'] = $id;
      $badge['title'] = $_POST['title'] ?? '';
      $badge['req'] = $_POST['req'] ?? '';
      $badge['diff'] = $_POST['diff'] ?? '';
      $badge['game_id'] = $_POST['game_id'] ?? '';


    $result = update_badge($badge);
    if($result === true){
        $successstring = "Badge Edited Successfully :)";
        $_SESSION['statusmsg'] = $successstring;

        redirect_to(url_for('/staff/badges/show.php?id=' . $id));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

  }else{
    $badge = find_badges_by_id($id);
  }

    $badge_set = find_all_badges();
    $badges_count = mysqli_num_rows($badge_set);
    mysqli_free_result($badge_set);
?>

<?php $page_title = 'Edit Badge'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/badges/index.php'); ?>">&laquo; Back to List</a>

  <div class="badge edit">
    <h1>Edit Badge</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/badges/edit.php?id='. hsc(urle($id))); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="<?php echo hsc($badge['title']); ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Requirement</dt>
        <dd><input type="text" name="req" value="<?php echo hsc($badge['req']); ?>" /></dd>
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
        <input type="submit" value="Edit Game" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
