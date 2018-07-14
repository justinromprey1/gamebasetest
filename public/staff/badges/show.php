<?php require_once('../../../private/initialize.php'); ?>

<?php 
  require_login();
	//checks if the page id given value exists, if so it sets the variable $id to it
	//else sets $id to 1
	$id = $_GET['id'] ?? 1;

	$badge = find_badges_by_id($id);
?>
  <div id="message">
	   <li><?php echo $_SESSION['statusmsg'] ?? '';?></li>
     <?php unset($_SESSION['statusmsg']); ?>
  </div>

<h1>Badge : <?php echo hsc($badge['title']); ?></h1>

<div class="attributes">
  <dl>
    <dt>Requirement</dt>
    <dd><?php echo hsc($badge['req']); ?></dd>
  </dl>
  <dl>
    <dt>Difficulty</dt>
    <dd><?php echo hsc($badge['diff']); ?></dd>
  </dl>
  <dl>
    <dt>Game</dt>
    <dd><?php $game = find_game_by_id($badge['game_id']);
              echo hsc($game['title']); ?></dd>
  </dl>
</div>

<br>

<a href="<?php echo url_for('staff/badges/index.php'); ?>"> << Back to List</a>


