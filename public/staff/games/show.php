<?php require_once('../../../private/initialize.php'); ?>

<?php 
  require_login();
	//checks if the page id given value exists, if so it sets the variable $id to it
	//else sets $id to 1
	$id = $_GET['id'] ?? 1;

	$game = find_game_by_id($id);
?>
  <div id="message">
	   <li><?php echo $_SESSION['statusmsg'] ?? '';?></li>
     <?php unset($_SESSION['statusmsg']); ?>
  </div>

<h1>Game : <?php echo hsc($game['title']); ?></h1>

<div class="attributes">
  <dl>
    <dt>System</dt>
    <dd><?php echo hsc($game['system']); ?></dd>
  </dl>
  <dl>
    <dt>Developer</dt>
    <dd><?php echo hsc($game['dev']); ?></dd>
  </dl>
  <dl>
    <dt>Publisher</dt>
    <dd><?php echo hsc($game['pub']); ?></dd>
  </dl>
  <dl>
    <dt>Genre</dt>
    <dd><?php echo hsc($game['genre']); ?></dd>
  </dl>
  <dl>
    <dt>Year</dt>
    <dd><?php echo hsc($game['year']); ?></dd>
  </dl>
</div>

<br>

<a href="<?php echo url_for('staff/games/index.php'); ?>"> << Back to List</a>


