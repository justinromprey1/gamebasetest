<?php require_once('../../private/initialize.php'); ?>

<?php 
  require_user_login();
	//checks if the page id given value exists, if so it sets the variable $id to it
	//else sets $id to 1
	$id = $_GET['id'] ?? 1;

	$c_badge = find_c_badges_by_id($id);
?>
  <div id="message">
	   <li><?php echo $_SESSION['statusmsg'] ?? '';?></li>
     <?php unset($_SESSION['statusmsg']); ?>
  </div>

<h1>Badge : <?php echo hsc($c_badge['title']); ?></h1>

<div class="attributes">
  <dl>
    <dt>Requirement</dt>
    <dd><?php echo hsc($c_badge['req']); ?></dd>
  </dl>
  <dl>
    <dt>Difficulty</dt>
    <dd><?php echo hsc($c_badge['diff']); ?></dd>
  </dl>
  <dl>
    <dt>Game</dt>
    <dd><?php $game = find_game_by_id($c_badge['game_id']);
              echo hsc($game['title']); ?></dd>
  </dl>
  <dl>
    <dt>Completed</dt>
    <dd><?php if($c_badge['completed'] == 1){ echo "True";}else{ echo "False";} ?></dd>
  </dl>
  <dl>
    <dt>User</dt>
    <dd><?php $current_user = find_user_by_username($_SESSION['user_login']) ?? '';
              echo hsc($current_user['username']); ?></dd>
  </dl>
</div>

<br>

<a href="<?php echo url_for('viewgamebase.php'); ?>"> << Back to List</a>


