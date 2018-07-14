 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
 	if(is_post_request()){

    // Handle form values sent by new.php
      $game = [];
      $game['title'] = $_POST['title'] ?? '';
      $game['system'] = $_POST['system'] ?? '';
      $game['dev'] = $_POST['dev'] ?? '';
      $game['pub'] = $_POST['pub'] ?? '';
      $game['genre'] = $_POST['genre'] ?? '';
      $game['year'] = $_POST['year'] ?? '';
      $game['release_date'] = $_POST['release_date'] ?? '';

    //insert admin into database
    $result = insert_game($game);
    if($result === true){
      //redirect to show page for newly created admin
      $new_id = mysqli_insert_id($db);

      $successstring = "Game Created Successfully :)";
      $_SESSION['statusmsg'] = $successstring;

      redirect_to(url_for('/staff/games/show.php?id=' . $new_id));
    }else{
      $errors = $result;
    }
  }else{
    //display the blank form
  }
  //get the number of subjects, called for the choosing of position
    $game_set = find_all_games();
    $game_count = mysqli_num_rows($game_set) + 1;
    mysqli_free_result($game_set);

  $game= [];

?>

<?php $page_title = 'Create Game'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/games/index.php'); ?>">&laquo; Back to List</a>

  <div class="game new">
    <h1>Create Game</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('staff/games/new.php'); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>System</dt>
        <dd><input type="text" name="system" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Developer</dt>
        <dd><input type="text" name="dev" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Publisher</dt>
        <dd><input type="text" name="pub" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Genre</dt>
        <dd><input type="text" name="genre" value="" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Year</dt>
        <dd><input type="text" name="year" value="" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Game" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
