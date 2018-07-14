 <?php 
 	require_once('../../../private/initialize.php');
  require_login();
  //confirm a selection to edit. if false, redirect back.
  if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/games/index.php'));
  }
  //store id
  $id = $_GET['id'];

  

  //confirm post request
 	if(is_post_request()){

    // Handle form values sent by new.php

      $game = [];
      $game['id'] = $id;
      $game['title'] = $_POST['title'] ?? '';
      $game['system'] = $_POST['system'] ?? '';
      $game['dev'] = $_POST['dev'] ?? '';
      $game['pub'] = $_POST['pub'] ?? '';
      $game['genre'] = $_POST['genre'] ?? '';
      $game['year'] = $_POST['year'] ?? '';
      $game['release_date'] = $_POST['release_date'] ?? '';


    $result = update_game($game);
    if($result === true){
        $successstring = "Game Edited Successfully :)";
        $_SESSION['statusmsg'] = $successstring;

        redirect_to(url_for('/staff/games/show.php?id=' . $id));
    }else{
      $errors = $result;
      //var_dump($errors);
    }

  }else{
    $game = find_game_by_id($id);
  }

  //get the number of subjects, called for the choosing of position
    $game_set = find_all_games();
    $game_count = mysqli_num_rows($game_set);
    mysqli_free_result($game_set);
?>

<?php $page_title = 'Edit Game'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/games/index.php'); ?>">&laquo; Back to List</a>

  <div class="game edit">
    <h1>Edit Game</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/games/edit.php?id='. hsc(urle($id))); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="<?php echo hsc($game['title']); ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>System</dt>
        <dd><input type="text" name="system" value="<?php echo hsc($game['system']); ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Developer</dt>
        <dd><input type="text" name="dev" value="<?php echo hsc($game['dev']); ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Publisher</dt>
        <dd><input type="text" name="pub" value="<?php echo hsc($game['pub']); ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Genre</dt>
        <dd><input type="text" name="genre" value="<?php echo hsc($game['genre']); ?>" /></dd>
      </dl>
      <br>
      <dl>
        <dt>Year</dt>
        <dd><input type="text" name="year" value="<?php echo hsc($game['year']); ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Game" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
